<?php

namespace App\Http\Controllers\Home;

use App\Models\Comment;
use App\Models\Lecturer;
use App\Models\Live_history;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Event;
use App\Events\LiveEvent;
use Validator;
class BackLiveController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_back_live' => 'on'
        ]);
    }

    public function index(Request $request)
    {
        $where = function($query) use ($request){
            if($request->has('type') and $request->type != ''){
                $search = "%" . $request->type . "%";
                $user_id = Lecturer::where('lecturer_type', 'like', $search)->select('user_id')->distinct()->get();
                $query->whereIn('user_id',$user_id);
            }
        };
        $back = Live_history::orderBy('id','desc')->where('status',1)->where($where)->paginate(20);
        return view('home.back_live.index')->with('back',$back);
    }

    public function backLive($id)
    {
        $back_live = Live_history::find($id);
        if(empty($back_live))
        {
            return redirect(route('home'));
        }
        Event::fire(new liveEvent($back_live));
        $comments = Comment::with('user','children.user.oauth')
            ->where('back_live_id',$id)
            ->where('parent_id',0)
            ->orderBy('id','desc')
            ->get();
        return view('home.back_live.live')->with('back_live',$back_live)->with('comments',$comments);
    }

    public function addBackLiveComment(Request $request)
    {
        if(empty($request->back_live_id)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        $live = Live_history::find($request->back_live_id);
        if(empty($live)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if($live->user_id == $this->user->id){
            return ['status' => false,'msg' => '请不要评论自己！'];
        }
        $validator = Validator::make(['contents' => $request->contents], [
            'contents' => 'required|max:50',
        ]);
        if ($validator->fails()) {
            return ['status' => false,'msg' => '内容不能为空,切字数最多为50！'];
        }
        //查看评论是否过于频繁
        //查找当前登陆用户最新发布的评论
        $comment = Comment::where('back_live_id',$request->back_live_id)->where('user_id',$this->user->id)->orderBy('id','desc')->first();
        if(!empty($comment)){
            $time = date("Y-m-d H:i:s",strtotime($comment->created_time));
            $intervalTime =  date("Y-m-d H:i:s", strtotime("$time +300 second"));
            $now = date('Y-m-d H:i:s',strtotime(Carbon::now()));
            if($intervalTime > $now){
                return ['status' => false,'msg' => '您已经评论过了，请稍后发布！'];
            }
        }
        if(empty($this->user->thumb)){
            $thumb = $this->user->oauth->avatar_url;
        }else{
            $thumb = $this->user->thumb;
        }
        if(empty($this->user->name)){
            $name = $this->user->oauth->nickname;
        }else{
            $name = $this->user->name;
        }
        $comment = Comment::create([
            'back_live_id' => $request->back_live_id,
            'user_id' => $this->user->id,
            'contents' => $request->contents,
            'created_time' => Carbon::now()
        ]);
        $info = [
            'thumb' => $thumb,
            'name' => $name,
            'contents' => $comment->contents,
            'time' => date('Y-m-d H:i:s')
        ];
        return ['status' => true,'msg' => '添加成功！','info' => $info];
    }

    public function replyBackLiveComment(Request $request)
    {
        if(empty($request->back_live_id)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if(empty($request->id)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        $article = Live_history::find($request->back_live_id);
        if(empty($article)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        $comment = Comment::find($request->id);
        if(empty($comment)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if($comment->parent_id != 0){
            return ['status' => false,'msg' => '非法操作！'];
        }
        $validator = Validator::make(['contents' => $request->contents], [
            'contents' => 'required|max:50',
        ]);
        if ($validator->fails()) {
            return ['status' => false,'msg' => '内容不能为空,切字数最多为50！'];
        }
        if($comment->user_id == $this->user->id){
            return ['status' => false,'msg' => '请不要回复自己的评论！'];
        }
        //查看评论是否过于频繁
        //查找当前登陆用户最新发布的评论
        $check_comment = Comment::where('back_live_id',$request->back_live_id)->where('parent_id',$request->id)->first();
        if(!empty($check_comment)){
            $time = date("Y-m-d H:i:s",strtotime($check_comment->created_time));
            $intervalTime =  date("Y-m-d H:i:s", strtotime("$time +300 second"));
            $now = date('Y-m-d H:i:s',strtotime(Carbon::now()));
            if($intervalTime > $now){
                return ['status' => false,'msg' => '您已经回复过了，请稍后发布！'];
            }
        }
        Comment::create([
            'back_live_id' => $request->back_live_id,
            'user_id' => $this->user->id,
            'parent_id' => $request->id,
            'contents' => $request->contents,
            'created_time' => Carbon::now()
        ]);
        return ['status' => true,'msg' => '添加成功！'];
    }
}
