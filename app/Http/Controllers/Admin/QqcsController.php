<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Qqcs;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class QqcsController extends CommonController
{

    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_qqcs' => 'am-in'
        ]);
    }
    ///文章列表
    public function index()
    {
        $qqcss = Qqcs::orderBy('etime','desc')->paginate(10);//1为显示
        return view('admin.qqcs.qqcs_list')->with('qqcss', $qqcss);
    }
    ///跳转至文章新增页面
    public function createqqcs()
    {
        return view('admin.qqcs.qqcs_create');
    }
     ///单条文章详细
    public function editQqcs(Request $request)
    {
        $qqcs = Qqcs::find($request->id);
        if (empty($qqcs)){
            return back()->with('error', '该客服不存在');
        }
        return view('admin.qqcs.qqcs_edit')->with('qqcs', $qqcs);
    }
    ///新增文章
    public function addQqcs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qq' => 'required',
            'name'=>'required'
        ]);
        if ($validator->fails()) {
            $res=self::res(false,'请按要求填写字段！');
            return $res;
        }
        $all = $request->all();
        $all['ctime']=time();
        $all['etime']=time();

        $result=Qqcs::create($all);
        if(!empty($result['id'])) {
            $res=self::res(true,'添加成功！');
        }
        else {
            $res=self::res(false,'添加失败！');
        }
        return $res;
    }
    ///编辑文章
    public function updateQqcs(Request $request)
    {
        $qqcs = Qqcs::find($request->id);
        if (empty($qqcs)){
            $res=self::res(false,'该客服不存在！');
            return $res;
        }
        $validator = Validator::make($request->all(), [
            'qq' => 'required',
            'name'=>'required'
        ]);
        if ($validator->fails()) {
            $res=self::res(false,'请按要求填写字段！');
            return $res;
        }
        $all = $request->all();
        $all['etime']=time();
        $qqcs->update($all);
        $res=self::res(true,'修改成功！');
        return $res;
    }


    ///删除文章
    public function delQqcs(Request $request)
    {
        $qqcs = Qqcs::find($request->id);
        if (empty($qqcs)) {
            $res=self::res(false,'该客服不存在！');
            return $res;
        }
        $result=Qqcs::where('id', $request->id)->delete();
        if ($result==1) {
            $res=self::res(true,'删除成功！');
        }
        else{
            $res=self::res(false,'删除失败！');
        }
        return $res;
    }



    public function searchQqcs(Request $request)
    {

        $qqcss = Qqcs::where('qq','like','%'.$request->keyword.'%')->orderBy('etime','desc')->paginate(10);
        return view('admin.qqcs.qqcs_list')->with('qqcss', $qqcss);

    }

    public function res($bool,$msg)
    {
         return $res=array(
             'status'=>$bool,
             'msg'=>$msg
         );
    }
}
