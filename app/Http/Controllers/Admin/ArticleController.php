<?php

namespace App\Http\Controllers\Admin;
use App\Models\Comment;
use App\Models\View;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Requests;
use Validator;


class ArticleController extends CommonController
{

    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_article' => 'am-in'
        ]);
    }

    ///文章列表
    public function index()
    {
        $articles = Article::with('user')->orderBy('etime', 'desc')->paginate(10);//1为显示
        $users = User::with('oauth')->get();
        return view('admin.article.article_list')->with('articles', $articles)->with('users',$users)->with('typeid',0);
    }

    ///跳转至文章新增页面
    public function createArticle()
    {
        return view('admin.article.article_create');
    }

    ///单条文章详细
    public function editArticle(Request $request)
    {
        $article = Article::find($request->id);
        if (empty($article)) {
            return back()->with('error', '该文章不存在');
        }
        return view('admin.article.article_edit')->with('article', $article);
    }


    public function articleComment(Request $request)
    {
        $comments = Comment::with('user','children.user.oauth')
            ->where('article_id',$request->id)
            ->where('parent_id',0)
            ->orderBy('id','desc')
            ->get();
        return view('admin.article.article_comment')
            ->with('comments',$comments);

    }
    public function delComment(Request $request)
    {
        Comment::where('parent_id',$request->id)->get();
        $result = Comment::where('id', $request->id)->delete();
        if ($result == 1) {
            return back()->with('msg', '删除成功');
        } else {
            return back()->with('error', '删除成功');
        }

    }


    ///新增文章
    public function addArticle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contents' => 'required'
        ]);
        if ($validator->fails()) {
            $res = self::res(false, '请按要求填写字段！');
            return $res;
        }
        if (empty($request->type)) {
            $res = self::res(false, '请先添加文章分类！');
            return $res;
        }
        $all = $request->all();
        $all['ctime'] = Carbon::now();;
        $all['etime'] = $all['ctime'];

        $result = Article::create($all);
        if (!empty($result['id'])) {
            $res = self::res(true, '添加成功！');
        } else {
            $res = self::res(false, '添加失败！');
        }
        return $res;
    }

    ///编辑文章
    public function updateArticle(Request $request)
    {

        $article = Article::find($request->id);

        if (empty($article)) {
            $res = self::res(false, '该文章不存在！');
            return $res;
        }
        $validator = Validator::make($request->all(), [
            'contents' => 'required'
        ]);
        if ($validator->fails()) {
            $res = self::res(false, '请按要求填写字段！');
            return $res;
        }
        if (empty($request->type)) {
            $res = self::res(false, '请先添加文章分类！');
            return $res;
        }
        $all = $request->all();
        $all['etime'] = Carbon::now();
        $article->update($all);
        $res = self::res(true, '修改成功！');
        return $res;
    }


    ///删除文章
    public function delArticle(Request $request)
    {
        $article = Article::find($request->id);
        if (empty($article)) {
            $res = self::res(false, '该文章不存在！');
            return $res;
        }
        $result = Article::where('id', $request->id)->delete();
        if ($result == 1) {
            $res = self::res(true, '删除成功！');
        } else {
            $res = self::res(false, '删除失败！');
        }
        return $res;
    }


    public function searchArticle(Request $request)
    {
        if ($request->typeid == 0) {
            $articles = Article::where('title', 'like', '%' . $request->keyword . '%')->orderBy('etime', 'desc')->paginate(10);
        } else {
            $articles = Article::where('title', 'like', '%' . $request->keyword . '%')->where('type', $request->typeid)->orderBy('etime', 'desc')->paginate(10);
        }
        return view('admin.article.article_list')->with('articles', $articles)->with('typeid', $request->typeid);
        return $request->all();

    }
    public function res($bool, $msg)
    {
        return $res = array(
            'status' => $bool,
            'msg' => $msg
        );
    }
}
