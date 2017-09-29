<?php

namespace App\Http\Controllers\Home;

use App\Models\LiveMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//直播通知
class LiveMessageController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
           '_live_message' => 'on'
        ]);
    }

    public function index()
    {
        $livemessages = LiveMessage::with('user')->orderBy('id','desc')->where('user_id',$this->user->id)->paginate(10);
        return view('home.lecturer.live_message.index')->with('livemessages',$livemessages);
    }

    public function create()
    {
        return view('home.lecturer.live_message.create');
    }

    public function store(Request $request)
    {
        if(empty($request->title)){
            return back()->with('error','标题不能为空！')->withInput();
        }
        if(empty($request->start_time) or empty($request->end_time)){
            return back()->with('error','时间不能为空！')->withInput();
        }
        $start = $request->start_time;
        $end_time = $request->end_time;
        if($start > $end_time){
            return back()->with('error','请填写正确的时间区域！')->withInput();
        }
        if($start < Carbon::now()){
            return back()->with('error','开始时间不能小于当前时间！')->withInput();
        }
        LiveMessage::create([
            'user_id' => $this->user->id,
            'title' => $request->title,
            'thumb' => $request->thumb,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'created_time' => Carbon::now()
        ]);
        return redirect(route('live.message'));
    }

    public function edit($id)
    {
        $livemessage = LiveMessage::find($id);
        if(empty($livemessage)){
            return redirect(route('live.message'));
        }
        if($livemessage->user_id != $this->user->id){
            return redirect(route('live.message'));
        }
        return view('home.lecturer.live_message.edit')->with('livemessage',$livemessage);
    }

    public function update(Request $request,$id)
    {
        $livemessage =  LiveMessage::find($id);
        if(empty($livemessage)){
            return redirect(route('live.message'));
        }
        if($livemessage->user_id != $this->user->id){
            return redirect(route('live.message'));
        }
        if(empty($request->title)){
            return back()->with('error','标题不能为空！')->withInput();
        }
        if(empty($request->start_time) or empty($request->end_time)){
            return back()->with('error','时间不能为空！')->withInput();
        }
        $start = $request->start_time;
        $end_time = $request->end_time;
        if($start > $end_time){
            return back()->with('error','请填写正确的时间区域！')->withInput();
        }
        if($start < Carbon::now()){
            return back()->with('error','开始时间不能小于当前时间！')->withInput();
        }
        $livemessage->update($request->all());
        return redirect(route('live.message'));
    }

    public function delete(Request $request)
    {
        $m = LiveMessage::where('user_id',$this->user->id)->find($request->id);
        if(empty($m)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        LiveMessage::destroy($request->id);
        return ['status' => true,'msg' => '删除成功！'];
    }
}
