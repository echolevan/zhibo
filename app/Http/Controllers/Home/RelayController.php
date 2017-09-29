<?php
/**
 * @author: hemengze@cmstop.com
 * Date: 2017/9/23 21:29
 */

namespace App\Http\Controllers\Home;

use App\Jobs\RelayLive;
use App\Models\Lecturer;
use App\Models\LiveRelay;
use App\Models\Room;
use App\Services\Relay\RelayCancel;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RelayController extends CommonController{

    public function index(Request $request){
        if($request->isMethod('GET')){
            view()->share([
                '_relay' => 'on'
            ]);
            return view('home.lecturer.relay.index');
        }elseif ($request->isMethod('POST')){
            $this->validate($request, [
                'room-url' => 'required|url'
            ], [
                'roomUrl.required' => '请输入地址信息',
                'roomUrl.url' => '请输入正确的地址'
            ]);
            $url = $request->input('room-url');
            if($streams_name = $this->getStreamsNameFromUrl($url)){
                $room = Room::where('streams_name', $streams_name)->with('lecturer')->first();
                return $this->_relay($room);
            }else{
                return back()->with('error', '输入的地址不正确！');
            }
        }
    }

    public function cancel(Request $request){
        $room_id = $request->input('room_id');
        $room = Room::where('id', $room_id)->first();
        $room->relay_room_id = null;
        $room->save();
        RelayCancel::cancel($room_id);
        return response()->json([
            'code' => 0
        ]);
    }

    public function relay(Request $request){
        $relay_id = $request->input('relay_id');
        $relay = LiveRelay::where('id', $relay_id)->first();
        if(is_null($relay)){
            return back()->with('error', '转播未找到！');
        }

        return $this->_relay($relay->fromRoom);
    }

    protected function _relay(Room $room){
        if(empty($room)){
            return back()->with('error', '房间未找到');
        }
        $myRoom = $this->getMyRoom();
        if(empty($myRoom)){
            return back()->with('error', '请先申请直播');
        }

        if($myRoom->relay_room_id > 0){
            return back()->with('error', '正在转播，请断开转播之后再转播');
        }

        $canRelay = LiveRelay::where('from_room', $room->id)->where('to_room', $myRoom->id)->where('expired_at', '>', Carbon::now())->first();
        if($canRelay){
            $this->dispatch((new RelayLive($canRelay))->onQueue('relay'));
            return back()->with('msg', '转播成功！');
        }

        if($this->user->gold < $room->relay_amount){
            return back()->with('error', '金币不足，请先充值');
        }

        if($room->relay_amount == 0){
            $canRelay = LiveRelay::create([
                'from_room' => $room->id,
                'to_room' => $myRoom->id,
                'expired_at' => Carbon::now()->addMonth()->toDateTimeString(),
                'amount' => $room->relay_amount
            ]);
            $this->dispatch((new RelayLive($canRelay))->onQueue('relay'));
            return back()->with('msg', '转播成功！');
        }

        $canRelay = \DB::transaction(function () use ($room, $myRoom) {
            $this->user->gold -= $room->relay_amount;
            $room->lecturer->user->gold += $room->relay_amount;
            $this->user->save();
            $room->lecturer->user->save();
            return LiveRelay::create([
                'from_room' => $room->id,
                'to_room' => $myRoom->id,
                'expired_at' => Carbon::now()->addMonth(),
                'amount' => $room->relay_amount
            ]);
        });

        if($canRelay){
            $this->dispatch((new RelayLive($canRelay))->onQueue('relay'));
            return back()->with('msg', '转播成功！');
        }else{
            return back()->with('error', '转播失败！');
        }
    }

    public function detail(){
        view()->share([
            '_relay_detail' => 'on'
        ]);
        $myRelay = collect();
        $relayMe = collect();
        $room = $this->getMyRoom();
        if(!is_null($room)){
            $relayMe = LiveRelay::where('from_room', $room->id)->with(['toRoom' => function($query){
                $query->with('lecturer');
            }])->orderBy('expired_at', 'desc')->limit(10)->get();
            $myRelay = LiveRelay::where('to_room', $room->id)->with(['fromRoom' => function($query){
                $query->with('lecturer');
            }])->orderBy('expired_at', 'desc')->limit(10)->get();
        }
        return view('home.lecturer.relay.detail', [
            'myRelay' => $myRelay,
            'relayMe' => $relayMe
        ]);
    }

    protected function getMyRoom(){
        $lecturer = Lecturer::where('user_id',$this->user->id)->first();
        return Room::where('lecturer_id',$lecturer->id)->first();
    }

    function amount(Request $request){
        $this->validate($request, [
            'roomUrl' => 'required|url'
        ], [
            'roomUrl.required' => '请输入地址信息',
            'roomUrl.url' => '请输入正确的地址'
        ]);

        $url = $request->input('roomUrl');

        $data = [
            'code' => 0
        ];
        do{
            if($streams_name = $this->getStreamsNameFromUrl($url)){
                $room = Room::where('streams_name', $streams_name)->first();
                if(empty($room)){
                    $data['code'] = -1;
                    $data['error'] = '房间未找到';
                    break;
                }
                $data['amount'] = $room->relay_amount;
            } else{
                $data['code'] = -1;
                $data['error'] = '输入的地址不正确';
                break;
            }
        }while(0);
        return new JsonResponse($data);
    }

    protected function getStreamsNameFromUrl($url){
        if (preg_match('%/live/(\d+)/(\d+)%', $url, $regs)) {
            return $regs[2];
        }
        return false;
    }
}