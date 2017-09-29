<?php

namespace App\Http\Controllers\Home;

use App\Models\Follow;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;

class FollowController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_following' => 'on'
        ]);
    }
    public function index()
    {
        $follows = Follow::with('user.lecturer.room')->where('my_id',$this->user->id)->paginate(12);
        return view('home.user.follow.index')->with('follows',$follows);
    }

    public function follow(Request $request)
    {
        //检查身份是否合法
        $check = User::find($request->lecturer_id);
        if(empty($check)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if($check->type != 2){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if($this->user->id == $request->lecturer_id){
            return ['status' => false,'msg' => '非法操作！'];
        }
        //验证是否已经关注
        $follow = Follow::where('my_id',$this->user->id)->where('user_id',$request->lecturer_id)->first();
        if(!empty($follow)){
            return ['status' => false,'msg' => '您已经关注！'];
        }
        Follow::create([
           'my_id' => $this->user->id,
            'user_id' => $request->lecturer_id,
            'created_time' => Carbon::now()
        ]);
        return ['status' => true,'msg' => '关注成功！'];
    }

    //定向取消关注
    public function unFollow(Request $request)
    {
        Follow::destroy($request->follow_id);
        return ['status' => true,'msg' => '成功取消关注！'];
    }

    //直播室取消关注
    public function unFollowLive(Request $request)
    {
        if(empty($request->lecturer_id)){
            return ['status' => false,'msg' => '操作失败！'];
        }
        $follow = Follow::where('my_id',$this->user->id)->where('user_id',$request->lecturer_id)->first();
        if(empty($follow)){
            return ['status' => false,'msg' => '操作失败！'];
        }
        $follow->delete();
        return ['status' => true,'msg' => '成功取消关注！'];
    }
}
