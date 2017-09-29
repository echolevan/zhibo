<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Notice;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class NoticeController extends CommonController
{

    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_notice' => 'am-in'
        ]);
    }
    ///文章列表
    public function index()
    {
        $notices = Notice::orderBy('etime','desc')->paginate(10);//1为显示
        return view('admin.notice.notice_list')->with('notices', $notices);
    }
    ///跳转至文章新增页面
    public function createNotice()
    {
        return view('admin.notice.notice_create');
    }
     ///单条文章详细
    public function editNotice(Request $request)
    {
        $notice = Notice::find($request->id);
        if (empty($notice)){
            return back()->with('error', '该公告不存在');
        }
        return view('admin.notice.notice_edit')->with('notice', $notice);
    }
    ///新增文章
    public function addNotice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content'=>'required'
        ]);
        if ($validator->fails()) {
            $res=self::res(false,'请按要求填写字段！');
            return $res;
        }
        $all = $request->all();
        $all['ctime']=time();
        $all['etime']=time();

        $result=Notice::create($all);
        if(!empty($result['id'])) {
            $res=self::res(true,'添加成功！');
        }
        else {
            $res=self::res(false,'添加失败！');
        }
        return $res;
    }
    ///编辑文章
    public function updateNotice(Request $request)
    {
        $notice = Notice::find($request->id);
        if (empty($notice)){
            $res=self::res(false,'该公告不存在！');
            return $res;
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content'=>'required'
        ]);
        if ($validator->fails()) {
            $res=self::res(false,'请按要求填写字段！');
            return $res;
        }
        $all = $request->all();
        $all['etime']=time();
        $notice->update($all);
        $res=self::res(true,'修改成功！');
        return $res;
    }


    ///删除文章
    public function delNotice(Request $request)
    {
        $notice = Notice::find($request->id);
        if (empty($notice)) {
            $res=self::res(false,'该公告不存在！');
            return $res;
        }
        $result=Notice::where('id', $request->id)->delete();
        if ($result==1) {
            $res=self::res(true,'删除成功！');
        }
        else{
            $res=self::res(false,'删除失败！');
        }
        return $res;
    }



    public function searchNotice(Request $request)
    {

        $notices = Notice::where('title','like','%'.$request->keyword.'%')->orderBy('etime','desc')->paginate(10);
        return view('admin.notice.notice_list')->with('notices', $notices);

    }

    public function res($bool,$msg)
    {
         return $res=array(
             'status'=>$bool,
             'msg'=>$msg
         );
    }
}
