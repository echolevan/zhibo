<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Focus;
use App\Models\Lecturer;
use App\Models\LiveMessage;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        view()->share([
           '_mobile_index' => 'curr'
        ]);
    }

    public function index()
    {
        //预告
        //查看今日
        $today = date('Y-m-d',strtotime(Carbon::now()));
        $today_start = $today." 00:00:00";
        $tomorrow = date('Y-m-d',strtotime(Carbon::tomorrow()));
        $tomorrow_end = $tomorrow." 23:59:59";
        $live_message = LiveMessage::orderBy('id','desc')->whereBetween('start_time',[$today_start,$tomorrow_end])->take(6)->get();
        $live = Lecturer::orderBy('id','desc')->with('user','room')->orderBy('sort','asc')->get();
        $lives = [];
        foreach($live as $v)
        {
            if(!empty($v->user)){
                if(!empty($v->room)){
                    $lives[] = $v;
                }
            }
        }
        $lives = collect($lives)->take(6);
        $livings = Room::with('lecturer.user')->where('lecturer_id','!=',0)->get();
        $living = [];
        foreach($livings as $v)
        {
            if(!empty($v->lecturer->user)){
                if(empty(liveStatus($v->streams_name)['status'])){
                    $living[] = $v;
                }
            }
        }
        $living = collect($living)->take(6);
        return view('mobile.index')->with('lives',$lives)->with('live_message',$live_message)->with('living',$living);
    }

    public function state()
    {
        return view('mobile.state');
    }
}
