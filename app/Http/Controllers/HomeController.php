<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Home\CommonController;
use App\Http\Requests;
use App\Models\Article;
use App\Models\Lecturer;

use App\Models\Live_history;
use App\Models\LiveMessage;
use App\Models\Profit;
use App\Models\Room;
use App\Models\TypeArticle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Focus;
use App\User;
use DB;
class HomeController extends CommonController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        view()->share([
           '_index' => 'on'
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $focus = Focus::with('lecturer.user.history')->get();
        if($request->has('forumid') and $request->has('user_id') and $request->has('token')){
            if(md5(env('APP_KEY').$request->forumid) == $request->token){
                //判断用户是否存在
                $user = User::find($request->forumid);
                if(!empty($user)){
                    session()->put('promotion',$request->forumid);
                    return redirect(route('home'));
                }
            }
        }
        $live = Lecturer::orderBy('sort','asc')->with('user','room')->get();
        $lives = [];
        foreach($live as $v)
        {
            if(!empty($v->user)){
                if(!empty($v->room)){
                    $lives[] = $v;
                }
            }
        }
        $lives = collect($lives)->take(9);
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
        $living = collect($living)->take(10);
        $view = Article::with('user')->orderBy('id','desc')->where('type',1)->where('is_delete','!=',2)->get();
        $views = [];
        foreach($view as $v)
        {
            if(!empty($v->user)){
                    $views[] = $v;
            }
        }
        $views = collect($views)->take(6);
        //预告
        //查看今日
        $today = date('Y-m-d',strtotime(Carbon::now()));
        $today_start = $today." 00:00:00";
        $today_end = $today." 23:59:59";
        $live_message_today = LiveMessage::orderBy('id','desc')->whereBetween('start_time',[$today_start,$today_end])->where('start_time','>',Carbon::now())->take(4)->get();
        //查看明日
        $tomorrow = date('Y-m-d',strtotime(Carbon::tomorrow()));
        $tomorrow_start = $tomorrow." 00:00:00";
        $tomorrow_end = $tomorrow." 23:59:59";
        $live_message_tomorrow = LiveMessage::orderBy('id','desc')->whereBetween('start_time',[$tomorrow_start,$tomorrow_end])->take(4)->get();

        //直播回看
        $back_lives = Live_history::with('user')->orderBy('id','desc')->where('status',1)->get();
        $back_live = [];
        foreach($back_lives as $v)
        {
            if(!empty($v->user)){
                $back_live[] = $v;
            }
        }
        $back_live = collect($back_live)->take(10);
        //文章点击
        $articles = Article::orderBy('count','desc')->where('type',2)->where('is_delete','!=',2)->take(10)->get();

        //总收益
        $countUserId = Profit::select('user_id')->distinct()->get();
        $counts = Profit::with('user')->select('user_id',DB::raw('sum(earnings) as sum_earnings'),DB::raw('sum(gain) as sum_gain'))
            ->whereIn('user_id',$countUserId)
            ->groupBy('user_id')
            ->orderBy(DB::raw('sum(gain)'), 'desc')
            ->take(7)
            ->get();

        //观点
        $types = TypeArticle::with(['articles'=>function($query){
        }])->get();

        return view('home.index',compact('types'))
            ->with('focus',$focus)
            ->with('lives',$lives)
            ->with('views',$views)
            ->with('living',$living)
            ->with('live_message_today',$live_message_today)
            ->with('live_message_tomorrow',$live_message_tomorrow)
            ->with('back_live',$back_live)
            ->with('articles',$articles)
            ->with('counts',$counts);
    }

    //发送短信验证码
    public function sendMobileCode(Request $request)
    {
        $user_check = User::where('phone',$request->phone)->first();
        if(!empty($user_check)){
            return ['status' => false,'msg' => '手机号码已绑定！'];
        }
        $res = new Verify();
        return $res->sendMobileCode($request->phone);
    }

    public function live(Request $request)
    {
        if($request->has('lecturer_id') and $request->lecturer_id != ''){
            $focus = Focus::with('lecturer.user.history')->where('lecturer_id',$request->lecturer_id)->first();
        }else{
            $focus = Focus::with('lecturer.user.history')->first();
        }
        return view('home.live')->with('focus',$focus);
    }

    public function cutFocus(Request $request)
    {
        $lecturer = Lecturer::with('room')->find($request->lecturer_id);
        if(empty($lecturer)){
            return ['status' => false,'msg' => '操作失败！'];
        }
        //判断是否在直播
        $data = [];
       // return liveStatus($lecturer->room->streams_name);
        if(empty(liveStatus($lecturer->room->streams_name)['status'])){
            $data = [
                'status' => '1',
               'thumb' => photoUrl($lecturer->room->streams_name),
                'url' => playUrl($lecturer->room->streams_name)
            ];
        }else{
            //查找历史记录
            $history = Live_history::where('user_id',$lecturer->user_id)->first();
            if(empty($history)){
                $data = [
                    'status' => '2',
                    'thumb' => $request->focus,
                    'url' => ''
                ];
            }else{
                $data = [
                    'status' => '3',
                    'thumb' => 'http://'.$history->thumb,
                    'url' => 'http://'.$history->url
                ];
            }
        }
        return ['status' => true,'msg' => '切换成功，等待播放！','info' => $data];
    }

    //服务条款
    public function state()
    {
        return view('home.state');
    }
}
