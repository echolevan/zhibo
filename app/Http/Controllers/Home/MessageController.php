<?php

namespace App\Http\Controllers\Home;

use App\Models\Consume;
use App\Models\Lecturer;
use App\Models\Message;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Api\IndexController;

class MessageController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
           '_message' => 'on'
        ]);
    }
    //用户消息中心
    public function index()
    {
        $message = Message::with('user')->where('user_id',$this->user->id)->where('type',2)->orderBy('id','desc')->get();
        return view('home.user.message.index')->with('message',$message);
    }

    //提问
    public function question(Request $request)
    {
        if(empty($request->to_user_id)){
           return ['status' => false,'msg' => '操作失败！'];
        }
        $user = User::find($request->to_user_id);
        if(empty($user)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if($user->type != 2){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if($this->user->id == $user->id){
            return ['status' => false,'msg' => '请不要给自己提问！'];
        }
        //验证提问金额
        if(empty($request->reply_price) and $request->reply_price < 1){
            return ['status' => false,'msg' => '请输入正确的提问金额！'];
        }
        //查询此讲师收费规则
        if($this->user->gold < $request->reply_price){
            return ['status' => false,'msg' => '您的余额不足，请充值！'];
        }
        $messageInfo =  Message::create([
            'user_id' => $this->user->id,
            'to_user_id' => $request->to_user_id,
            'title' => $request->title,
            'reply_price' => $request->reply_price,
            'type' => 1,
            'created_time' => Carbon::now()
        ]);
        $this->user->update(['gold' => ($this->user->gold)-$request->reply_price]);
        //写入消费记录
        Consume::create([
            'user_id' => $this->user->id,
            'to_user_id' => $request->to_user_id,
            'type' => '向讲师提问 ',
            'price' => $request->reply_price,
            'created_time' => Carbon::now()
        ]);
        // broadcast question
        IndexController::sendQuestion($this->user->id, $this->user->name, $messageInfo->id, $request->title, $request->reply_price, 1);
        
        return ['status' => true,'msg' => '提问成功'];
    }

    //讲师问题处理
    public function reply()
    {
        $message = Message::with('user','tuUser')->where('to_user_id',$this->user->id)->orderBy('id','desc')->get();
        return view('home.lecturer.reply.index')->with('message',$message);
    }

    //讲师查看我的问题
    public function replyShow($id)
    {
        $message = Message::with('user.oauth')->find($id);
        if(empty($message)){
            return redirect(route('lecturer.message'));
        }
        $message->update(['is_read' => 2]);
        $time = date('i',strtotime(Carbon::now())-strtotime($message->end_time));
        return view('home.lecturer.reply.show')->with('message',$message)->with('time',$time);
    }

    //回复提问
    public function replyQuestion(Request $request)
    {
        if(empty($request->reply)){
            return ['status' => false,'msg' => '回复不能为空！'];
        }
        $message = Message::with('user.oauth')->find($request->message_id);
        if(empty($message)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if($message->reply){
            return ['status' => false,'msg' => '你已经回复过了！'];
        }
        $user = User::find($message->user_id);
        if($user->gold<$message->reply_price){
            return ['status' => false,'msg' => '提问用户余额不足！'];
        }
        $message->update(['status' => 2,'reply' =>$request->reply,'end_time' => Carbon::now()]);
        $info = ([
           'thumb' => $message->user->thumb,
            'msg' => $request->reply
        ]);
        //User::find($message->user_id)->decrement('gold', $message->reply_price);
        User::find($message->to_user_id)->increment('award',$message->reply_price);
        
        // solved question
        IndexController::solvedQuestion($request->message_id, $request->reply, 2);
        
       return ['status' => true,'info' => $info];
    }

    //撤销回复
    public function removeReply(Request $request)
    {
        $message = Message::find($request->message_id);
        $time = date('i',strtotime(Carbon::now())-strtotime($message->end_time));
        if($time > 5){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if(empty($message)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        $message->update(['status' => 1,'reply' =>'','end_time' => '']);
        return ['status' => true,'msg' => '撤回成功！'];
    }

    //会员查看我的消息
    public function show($id)
    {
        $message = Message::with('user.oauth','tuUser')->find($id);
        if(empty($message)){
            return redirect(route('user.message'));
        }
        $message->update(['is_read' => 2]);
        return view('home.user.message.show')->with('message',$message);
    }
}
