<?php

namespace App\Http\Controllers\Home;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArticleController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_article' => 'on'
        ]);
    }

    public function index()
    {
        $articles = Article::with('user','comments')->where('user_id',$this->user->id)->where('type',2)->where('is_delete','!=',2)->orderBy('id','desc')->paginate(10);
        return view('home.lecturer.article.index')->with('articles',$articles);
    }

    public function create()
    {
        return view('home.lecturer.article.create');
    }

    public function store(Request $request)
    {
        if(empty($request->title)){
            return back()->with('error','标题不能为空！')->withInput();
        }
        if(empty($request->img)){
            return back()->with('error','封面图不能为空！')->withInput();
        }
        if(empty($request->contents)){
            return back()->with('error','内容不能为空！')->withInput();
        }
        Article::create([
            'user_id' => $this->user->id,
            'title' => $request->title,
            'img' => $request->img,
            'description' => $request->desc,
            'contents' => $request->contents,
            'type' => 2,
            'ctime' => Carbon::now()
        ]);
        return redirect(route('lecturer.article'));
    }

    public function show($id)
    {
        $articles = Article::with('user')->find($id);
        if(empty($articles)){
            return redirect(route('lecturer.article'))->with('error','内容不存在！');
        }
        if($articles->user->id != $this->user->id){
            return redirect(route('lecturer.article'))->with('error','非法操作！');
        }
        return view('home.lecturer.article.show')->with('articles',$articles);
    }

    public function updateArticle(Request $request,$id)
    {
        if(empty($request->title)){
            return back()->with('error','标题不能为空！')->withInput();
        }
        if(empty($request->img)){
            return back()->with('error','封面图不能为空！')->withInput();
        }
        if(empty($request->contents)){
            return back()->with('error','内容不能为空！')->withInput();
        }
        $views = Article::with('user')->find($id);
        if(empty($views)){
            return redirect(route('lecturer.article'))->with('error','内容不存在！');
        }
        if($views->user->id != $this->user->id){
            return redirect(route('lecturer.article'))->with('error','非法操作！');
        }
        $views->update($request->all());
        $views->update(['etime' => Carbon::now()]);
        return redirect(route('lecturer.article'))->with('msg','编辑成功！');
    }

}
