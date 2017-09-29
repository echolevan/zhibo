<?php

namespace App\Http\Controllers\Home;

use App\Models\Live_history;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PlayController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_play' => 'on'
        ]);
    }

    public function index()
    {
        if($this->user->type != 2){
            return redirect(route('user'));
        }
        return view('home.lecturer.play.index');
    }

    //保存直播回放并保存直播截图
    public function stopLive(Request $request)
    {
        if(empty($request->title)){
            return ['status' => false,'msg' => '请输入视频标题！'];
        }
        if(empty($request->name)){
            return ['status' => false,'msg' => '非法操作'];
        }
        //检查流是否存在，及状态
        $streams = Room::where('streams_name',$request->name)->first();
        if(empty($streams)){
            return ['status' => false,'msg' => '非法操作'];
        }
        $thumb = liveThumb($request->name)['fname'];
        $liveUrl =  liveSave($request->name,session()->get('start_time')-500)['fname'];
        Live_history::create([
            'user_id' => $this->user->id,
            'title' => $request->title,
            'thumb' => config('qiniu.medium').'/'.$thumb,
            'url' => config('qiniu.medium').'/'.$liveUrl,
            'created_time' => Carbon::now()
        ]);
        disableStream($request->name);
        return ['status' => true,'msg' => '保存成功！'];
    }
    public function changeStreamStatus(Request $request)
    {
        if(empty($request->name)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        //判断是否禁用
        $res = getStream($request->name);
        if($res['disabledTill'] == 0){
            disableStream($request->name);
            return ['status' => true,'msg' => '禁用成功！'];
        }
        if($res['disabledTill'] == -1){
            enableStream($request->name);
            return ['status' => true,'msg' => '启用成功！'];
        }
        return ['status' => false,'msg' => '操作失败！'];
    }

}
