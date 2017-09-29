<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Word;
use Validator;

class WordController extends CommonController
{

    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_word' => 'am-in'
        ]);
    }
    ///敏感词列表
    public function index()
    {
        $words = Word::orderBy('etime','desc')->paginate(10);//1为显示
        return view('admin.word.word_list')->with('words', $words);
    }
    ///跳转至敏感词新增页面
    public function createWord()
    {
        return view('admin.word.word_create');
    }
     ///单条敏感词详细
    public function editWord(Request $request)
    {
        $word = Word::find($request->id);
        if (empty($word)){
            return back()->with('error', '该敏感词不存在');
        }
        return view('admin.word.word_edit')->with('word', $word);
    }
    ///新增敏感词
    public function addWord(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'word' => 'required',
        ]);
        if ($validator->fails()) {
            $res=self::res(false,'请按要求填写字段！');
            return $res;
        }
        $words = Word::where('word',$request->word)->count();
        if($words>0)
        {
            $res=self::res(false,'该敏感词已存在！');
            return $res;
        }
        $all = $request->all();
        $all['ctime']=time();
        $all['etime']=time();
        $result=Word::create($all);
        if(!empty($result['id'])) {
            $res=self::res(true,'添加成功！');
        }
        else {
            $res=self::res(false,'添加失败！');
        }
        return $res;
    }

    ///删除敏感词
    public function delWord(Request $request)
    {
        $word = word::find($request->id);
        if (empty($word)) {
            $res=self::res(false,'该敏感词不存在！');
            return $res;
        }
        $result=Word::where('id', $request->id)->delete();
        if ($result==1) {
            $res=self::res(true,'删除成功！');
        }
        else{
            $res=self::res(false,'删除失败！');
        }
        return $res;
    }


    public function searchWord(Request $request)
    {
        $words = Word::where('word','like','%'.$request->keyword.'%')->orderBy('etime','desc')->paginate(10);
        return view('admin.word.word_list')->with('words', $words);

    }
    public function updateWord(Request $request)
    {
        $word = Word::find($request->id);
        if (empty($word)){
            return back()->with('error', '该敏感词不存在');
        }
        $words = Word::where('word',$request->word)->where('id','!=',$request->id)->count();
        if($words>0)
        {
            $res=self::res(false,'敏感词已存在！');
            return $res;
        }
        $word->update(['word'=>$request->word,'etime'=>time()]);
        $res=self::res(true,'修改成功！');
        return $res;
    }
    public function res($bool,$msg)
    {
         return $res=array(
             'status'=>$bool,
             'msg'=>$msg
         );
    }
}
