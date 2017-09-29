<?php

namespace App\Http\Controllers\Home;

use App\Models\Consume;
use App\Models\Forbid;
use App\Models\Gift_history;
use App\Models\Gifts;
use App\Models\Lecturer;
use App\Models\Live_history;
use App\Models\Message;
use App\Models\Room;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use App\Events\GiftEvent;
use App\Http\Requests;
use App\Http\Controllers\Api\IndexController;
use DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;
use App\Models\Article;

class LiveController extends CommonController
{
    public function index($user_id,$stream,Request $request)
    {
		
        if($request->has('forumid') and $request->has('user_id') and $request->has('token')){
            if(md5(env('APP_KEY').$request->forumid) == $request->token){
                //判断用户是否存在
                $user = User::find($request->forumid);				
                if(!empty($user)){
                    session()->put('live_promotion',$request->forumid);
                    return redirect(route('live',[$user_id,$stream]));
                }
            }
			
			
        }

		
        $lecturer = Lecturer::where('user_id',$user_id)->first();
        if(empty($lecturer)){
            return redirect(route('home'));
        }
        $room = Room::where('streams_name',$stream)->first();
        if(empty($room)){
            return redirect(route('home'));
        }
        if($room->status == 2){
            return redirect(route('home'));
        }
        if($room->lecturer_id != $lecturer->id){
            return redirect(route('home'));
        }
		
		
		if ($room->is_vip==2&&$room->vip_pass!=Cookie::get('vip_pass')){
			return view('home.vip_login')->with('room',$room)->with('lecturer',$lecturer);
		}
		
		
        $gifs = Gifts::where('is_delete',1)->take(9)->get();
        //查看今日提问
        $today = date('Y-m-d',strtotime(Carbon::now()));
        $start = $today." 00:00:00";
        $end = $today." 23:59:59";
        $messages = Message::orderBy('id','desc')->where('to_user_id',$lecturer->user_id)->whereBetween('created_time',[$start,$end])->get();

        //礼物榜
        $gifUserId = Gift_history::where('receiver_id',$user_id)->select('send_id')->distinct()->get();
        $GifTop = Gift_history::select('send_name',DB::raw('sum(all_price) as sum_price'))
            ->whereIn('send_id',$gifUserId)
            ->groupBy('send_id')
            ->orderBy(DB::raw('sum(all_price)'), 'desc')
            ->take(10)
            ->get();
        // ws address
        $wsAddress = "ws://" . config('api.chat_server_host') . ":".config('api.chat_server_port')."/".config('api.chat_server_path')."/".$stream;
        
        //为开播 推荐视频
        $history = Live_history::with('user')->where('user_id',$user_id)->paginate(2);

        $userData = "";
        if (\Auth::check()){
            $uid = $this->user->id;
            $user = User::where('id', $uid)->first();
            $user->name = $user->name ? $user->name : ($user->email ? $user->email : "");
            
            // 获取用户的level level > 10000 主播
            // 此处status不是user表里的status 禁言是针对某个房间禁言，不可用user表的status来表示
            //判断是否被禁言
            $user->status = 1;  // 1:正常，2：禁言
            $ban = Forbid::where('room_id',$room->id)->where('user_id',$uid)->first();
            if(!empty($ban)){
                $user->status = 2;
            }
            $user->level = 1;
            if($lecturer->user_id == $uid){
                $user->level = 10000; // 10000 直播  1 普通用户
            }
            $userData = generateValidateJson($user, config('api.api_secret_key'));
        }
        //return $room;
        if(\Route::currentRouteName() == 'mobile.live'){
            $view = view('mobile.live.index');
        }else{
            $view = view('home.live.index');
        }
		
		
		//文章
        $articles = Article::with('user','comments')->where('user_id',$user_id)->where('type',2)->where('is_delete','!=',2)->orderBy('id','desc')->paginate(2);
		$viewpoint = Article::with('user','comments')->where('user_id',$user_id)->where('type',1)->where('is_delete','!=',2)->orderBy('id','desc')->paginate(2);
		
        return $view
            ->with('lecturer',$lecturer)
            ->with('room',$room)
            ->with('gifs',$gifs)
            ->with("wsAddress", $wsAddress)
            ->with("userData", $userData)
            ->with('messages',  json_encode($messages))
            ->with('reply_msg',  $messages)
            ->with('GifTop',$GifTop)
            ->with('history',$history)
            ->with('articles',$articles)
            ->with('viewpoints',$viewpoint);
    }

    public function ban(Request $request)
    {
        //如果是自己，不能被禁用
        $room = Room::with('lecturer')->find($request->room_id);
        if(empty($room)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        //判断是不是自己房间的主播
        if($room->lecturer->user_id != $this->user->id){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if($request->uid == $room->lecturer->user_id){
            return ['status' => false,'msg' => '不能禁言自己！'];
        }
        //判断是否已经被禁言
        $ban = Forbid::where('room_id',$request->room_id)->where('user_id',$request->uid)->first();
        if(!empty($ban)){
            return ['status' => false,'msg' => '该用户已经被禁言！'];
        }
        if($request->uid != 0){
            Forbid::create([
                'user_id' => $request->uid,
                'room_id' => $request->room_id,
            ]);
        }
        $res = new IndexController();
        $res->updateUserStatus($request->cid,2);
    }

    public function giveGift(Request $request)
    {
        $number = $request->number;
        if(empty($number)){
            return ['status' => false,'msg' => '购买数量不能为空！'];
        }
        if(!preg_match("/^[0-9][0-9]*$/",$number)){
            return ['status' => false,'msg' => '请填写正整数！'];
        }
        $gift = Gifts::find($request->gift_id);
        if(empty($gift)){
            return ['status' => false,'msg' => '礼物不存在！'];
        }
        $user = User::find($request->user_id);
        if(empty($user)){
            return ['status' => false,'msg' => '用户不存在！'];
        }
        if($user->type != 2){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if($this->user->id == $request->user_id){
            return ['status' => false,'msg' => '请不要给自己送礼物！'];
        }
        $price = $number*($gift->price);
        //检查是否是送礼员 是否自己的送礼员
        $g = [];
        if($this->user->fake == 2 && $this->user->pid == $request->user_id){
            $g = ([
                'gift_id' => $gift->id,
                'gift_name' => $gift->name,
                'num' => $number,
                'all_price' => $price,
                'gift_price' => $gift->price,
                'send_name' => $this->user->name,
                'send_id' => $this->user->id,
            ]);
        }else{
            if((($this->user->gold)-$price) < 0){
                return ['status' => false,'msg' => '金币不足，请充值！'];
            }
            if(empty($this->user->name)){
                $name = $this->user->oauth->nickname;
            }else{
                $name = $this->user->name;
            }
            if(empty($user->name)){
                $receiver_name = $user->oauth->nickname;
            }else{
                $receiver_name = $user->name;
            }
            $g = Gift_history::create([
                'gift_id' => $gift->id,
                'gift_name' => $gift->name,
                'num' => $number,
                'all_price' => $price,
                'gift_price' => $gift->price,
                'send_name' => $name,
                'send_id' => $this->user->id,
                'receiver_name' => $receiver_name,
                'receiver_id' => $user->id,
                'create_time' => Carbon::now()
            ]);
            $this->user->update(['gold' => ($this->user->gold)-$price]);
            $user->update(['award' => ($user->award)+$price]);
            //写入消费记录
            Consume::create([
                'user_id' => $this->user->id,
                'to_user_id' => $user->id,
                'type' => '赠送了礼物 '.$number.'个'.$gift->name,
                'price' => $price,
                'created_time' => Carbon::now()
            ]);
        }
        
        // broadcast gift
        IndexController::sendGift($this->user->id, $name, $user->id, $receiver_name, $gift->id, $gift->name, $number, $gift->price, $price);
        
        return ['status' => true,'msg' => '赠送成功！'];
    }
//gift:App\\Events\\GiftEvent



	//vip房间用户输入密码登录，写入cookie密码
	public function vipRoomCheck(Request $request){
		if ($request->isMethod('post')){
			$_reqData = $request->all();
			$room = Room::where('streams_name',$_reqData['stream'])->first();
			$_retMsg = array('status'=>-1,'message'=>'密码不正确');
			
			if ($room->is_vip==2&&$room->vip_pass==$_reqData['vip_pass']){
				$_retMsg = array('status'=>1,'message'=>'登录成功');				
				Cookie::queue('vip_pass', $_reqData['vip_pass'], 60);
				return response()->json($_retMsg);
			}
			return response()->json($_retMsg);
			//return redirect('live/'.$vip['user_id'].'/'.$vip['stream']);
		}
	}

}

