<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Live_history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Events\ArticleView;
class ArticleController extends Controller
{
    public function __construct()
    {
        view()->share([
            '_mobile_article' => 'curr'
        ]);
    }

    public function index()
    {
        $views = Article::with('user')->where('type',2)->get();
        return view('mobile.article.index')->with('views',$views);
    }

    public function details($id)
    {
        $details = Article::find($id);
        if(empty($details)){
            return redirect(route('mobile'));
        }
        Event::fire(new ArticleView($details));
        $comments = Comment::with('user','children.user.oauth')
            ->where('article_id',$id)
            ->where('parent_id',0)
            ->orderBy('id','desc')
            ->get();
        return view('mobile.article.details')->with('details',$details)->with('comments',$comments);
    }

    public function reply($article_id,$comment_id)
    {
        $check_article = Article::find($article_id);
        if(empty($check_article)){
            return redirect(route('mobile.view'));
        }
        $check_comment = Comment::where('id',$comment_id)->where('article_id',$article_id)->first();
        if(empty($check_comment)){
            return redirect(route('mobile.view'));
        }
        return view('mobile.article.reply')->with('article_id',$article_id)->with('comment_id',$comment_id);
    }

    public function replyLive($back_live_id,$comment_id)
    {
        $check_live = Live_history::find($back_live_id);
        if(empty($check_live)){
            return redirect(route('mobile.back_live'));
        }
        $check_comment = Comment::where('id',$comment_id)->where('back_live_id',$back_live_id)->first();
        if(empty($check_comment)){
            return redirect(route('mobile.back_live'));
        }
        return view('mobile.back_live.reply')->with('back_live_id',$back_live_id)->with('comment_id',$comment_id);
    }
}
