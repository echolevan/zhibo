<?php

namespace App\Http\Controllers\Home;

use App\Models\Live_history;
use Illuminate\Http\Request;
use App\Http\Requests;

//直播历史
class LiveHistoryListController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_live_history' => 'on'
        ]);
    }

    public function index()
    {
        $history = Live_history::with('user')->where('user_id',$this->user->id)->where('status',1)->paginate(6);
        return view('home.lecturer.streams_list.index')->with('history',$history);
    }

    public function delete(Request $request)
    {
        $live = Live_history::find($request->id);
        if(empty($live)){
            return ['status' => false,'msg' => '非法操作'];
        }
        $live->update(['status' => 2]);
        return ['status' => true,'msg' => '删除成功'];
    }
}
