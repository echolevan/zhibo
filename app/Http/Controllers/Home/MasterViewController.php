<?php

namespace App\Http\Controllers\Home;

use App\Models\Article;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Events\ArticleView;
use Validator;
class MasterViewController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_master_view' => 'on'
        ]);
    }


    public function index(Request $request)
    {
        $gid = 'sh000001';
        $f = Article::financeInfo($gid);
        if(empty(trim($request->id)) or $request->id == 1){
            if($request->has('type') and $request->type == 1){
                $views = Article::with('user','comments')->where('type',1)->where('is_delete','!=',2)->orderBy('count','desc')->paginate(6);
            }else{
                $views = Article::with('user','comments')->where('type',1)->where('is_delete','!=',2)->orderBy('id','desc')->paginate(6);
            }
        }else{
            if($request->has('type') and $request->type == 1){
                $views = Article::with('user','comments')->where('type',2)->where('is_delete','!=',2)->orderBy('count','desc')->paginate(6);
            }else{
                $views = Article::with('user','comments')->where('type',2)->where('is_delete','!=',2)->orderBy('id','desc')->paginate(6);
            }
        }
        $active = $request->id;
        $hot_views = Article::where('type',1)->where('is_delete','!=',2)->orderBy('count','desc')->take(10)->get();
        //牛人观点
        $best = Article::with('user','comments')->where('type',1)->where('is_delete','!=',2)->orderBy('id','asc')->take(6)->get();
        return view('home.master_view.index')
            ->with('views',$views)
            ->with('active',$active)
            ->with('hot_views',$hot_views)
            ->with('best',$best)
            ->with('f',$f);
    }


    //股市信息
    public function financeInfo()
    {
        $gid = 'sh000001';
        $res = [];
        $res = finance($gid)['result']['0']['dapandata'];
        $data = [];
        $data = [
            'dot' => substr($res['dot'],0,-2),
            'name'=> $res['name'],
            'nowPic' => substr($res['nowPic'],0,-2),
            'rate' => $res['rate']
        ];
        return $data;
    }


    //文章 观点详情
    public function details($id)
    {
        $gid = 'sh000001';
        $f = Article::financeInfo($gid);
        $details = Article::find($id);
        $info = finance($details->description);
        if(empty($details)){
            return redirect(route('home'));
        }
        Event::fire(new ArticleView($details));
        $comments = Comment::with('user','children.user.oauth')
            ->where('article_id',$id)
            ->where('parent_id',0)
            ->orderBy('id','desc')
            ->get();
        //牛人观点
        $best = Article::with('user','comments')->where('type',1)->where('is_delete','!=',2)->orderBy('id','asc')->take(6)->get();
        $hot_views = Article::where('type',1)->where('is_delete','!=',2)->orderBy('count','desc')->take(10)->get();
        return view('home.master_view.details')
            ->with('details',$details)
            ->with('comments',$comments)
            ->with('best',$best)
            ->with('hot_views',$hot_views)
            ->with('f',$f)
            ->with('info',$info);
    }

    //添加评论
    public function addComment(Request $request)
    {
        if(empty($request->article_id)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        $article = Article::find($request->article_id);
        if(empty($article)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if($article->user_id == $this->user->id){
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
        $comment = Comment::where('article_id',$request->article_id)->where('user_id',$this->user->id)->orderBy('id','desc')->first();
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
           'article_id' => $request->article_id,
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

    //回复评论
    public function replyComment(Request $request)
    {
        if(empty($request->article_id)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if(empty($request->id)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        $article = Article::find($request->article_id);
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
        $check_comment = Comment::where('article_id',$request->article_id)->where('parent_id',$request->id)->first();
        if(!empty($check_comment)){
            $time = date("Y-m-d H:i:s",strtotime($check_comment->created_time));
            $intervalTime =  date("Y-m-d H:i:s", strtotime("$time +300 second"));
            $now = date('Y-m-d H:i:s',strtotime(Carbon::now()));
            if($intervalTime > $now){
                return ['status' => false,'msg' => '您已经回复过了，请稍后发布！'];
            }
        }
        Comment::create([
            'article_id' => $request->article_id,
            'user_id' => $this->user->id,
            'parent_id' => $request->id,
            'contents' => $request->contents,
            'created_time' => Carbon::now()
        ]);
        return ['status' => true,'msg' => '添加成功！'];
    }
}
