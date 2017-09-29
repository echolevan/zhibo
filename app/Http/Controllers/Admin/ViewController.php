<?php

namespace App\Http\Controllers\Home;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Image;
use Validator;
class ViewController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_view' => 'on'
        ]);
    }

    public function index()
    {
        $view = Article::with('user','comments')->where('user_id',$this->user->id)->where('type',1)->where('is_delete','!=',2)->orderBy('id','desc')->paginate(10);
        return view('home.lecturer.view.index')->with('view',$view);
    }

    public function create()
    {
        return view('home.lecturer.view.create');
    }

    public function store(Request $request)
    {
        if(empty($request->description)){
            return back()->with('error','股票代码不能为空！')->withInput();
        }
        if(empty($request->img)){
            return back()->with('error','封面图不能为空！')->withInput();
        }
        if(empty($request->contents)){
            return back()->with('error','内容不能为空！')->withInput();
        }
        $validator = Validator::make(['contents' => $request->contents], [
            'contents' => 'max:150',
        ]);
        if ($validator->fails()) {
            return back()->with('error','内容不能超过150个字！')->withInput();
        }
        Article::create([
            'user_id' => $this->user->id,
            'title' => $request->title,
            'img' => $request->img,
            'description' => $request->description,
            'contents' => $request->contents,
            'type' => 1,
            'ctime' => Carbon::now()
        ]);
        return redirect(route('lecturer.view'));
    }

    public function show($id)
    {
        $views = Article::with('user')->find($id);
        if(empty($views)){
            return redirect(route('lecturer.view'))->with('error','内容不存在！');
        }
        if($views->user->id != $this->user->id){
            return redirect(route('lecturer.view'))->with('error','非法操作！');
        }
        return view('home.lecturer.view.show')->with('views',$views);
    }

    public function updateView(Request $request,$id)
    {
        if(empty($request->description)){
            return back()->with('error','股票代码不能为空！')->withInput();
        }
        if(empty($request->img)){
            return back()->with('error','封面图不能为空！')->withInput();
        }
        if(empty($request->contents)){
            return back()->with('error','内容不能为空！')->withInput();
        }
        $validator = Validator::make(['contents' => $request->contents], [
            'contents' => 'max:150',
        ]);
        if ($validator->fails()) {
            return back()->with('error','内容不能超过150个字！')->withInput();
        }
        $views = Article::with('user')->find($id);
        if(empty($views)){
            return redirect(route('lecturer.view'))->with('error','内容不存在！');
        }
        if($views->user->id != $this->user->id){
            return redirect(route('lecturer.view'))->with('error','非法操作！');
        }
        $views->update($request->all());
        $views->update(['etime' => Carbon::now()]);
        return redirect(route('lecturer.view'))->with('msg','编辑成功！');
    }

    public function delete(Request $request)
    {
        $check_view = Article::find($request->id);
        if($check_view->user_id != $this->user->id or empty($check_view)){
            return ['status' => false,'msg' => '非法操作'];
        }
        $check_view->update(['is_delete' => 2]);
        return ['status' => true,'msg' => '删除成功！'];
    }


    public function img_upload(Request $request, $name = 'Filedata', $depath = '/finder/view/')//上传观点图片，非七牛
    {
        if ($request->hasFile($name) and $request->file($name)->isValid()) {
            $result = array();

            //文件类型
            $allow = array('image/jpeg', 'image/png', 'image/gif');
            $mine = $request->file($name)->getMimeType();
            if (!in_array($mine, $allow)) {
                $result['status'] = 0;
                $result['info'] = '文件类型错误，只能上传图片';
                return $result;
            }

            //文件大小判断
            $max_size = 1024 * 1024;
            $size = $request->file($name)->getClientSize();
            if ($size > $max_size) {
                $result['status'] = 0;
                $result['info'] = '文件大小不能超过1M';
                return $result;
            }

            //上传文件夹，如果不存在，建立文件夹
            $date = date("Y_m");
            $path = getcwd() . $depath . $date;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            //生成新文件名
            $extension = $request->file($name)->getClientOriginalExtension();      //取得之前文件的扩展名

            $file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $extension;
            $request->file($name)->move($path, $file_name);
            $file_path = $path.'/'.$file_name;
            $thumb_name = $path.'/'. basename($file_path);
            $thumb = Image::make($file_path);
            $thumb->resize(400, 400);
            $thumb->save($thumb_name);
            //返回新文件名
            $result['status'] = 1;
            $result['info'] = $depath . $date . '/' . $file_name;
            return $result;
        }
    }
}
