<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Verify;
use App\Models\Lecturer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Image;
use Hash;
class UserInfoController extends CommonController//用户中心控制器
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_user' => 'on'
        ]);
    }

    public function index()//用户中心页面
    {
        return view('home.user.index');
    }

    public function userinfo()//用户详情页面
    {
        $user = $this->user;
        return view('home.user.info.info')->with(compact('user'));
    }

    public function store_info(Request $request)
    {
        $user = Auth::user();
        $res = User::where('name','!=',$user->name)->where('name',$request->name)->first();
        if(!empty($res)){
            return back()->with('error','该昵称已存在！');
        }
        $info = array(
            'name'=>$request->name,
            'sign'=>$request->sign,
            'thumb'=>$request->img
        );
        $user->update($info);
        return back()->with('msg','修改成功');
    }

    //绑定手机号码
    public function bindPhone()
    {
        $user = Auth::user();
        if(!empty($user->phone)){
            return redirect(route('home'));
        }
        return view('home.user.auth_phone.bind_phone');
    }
    //手机认证 验证身份
    public function authPhone(Request $request)
    {
        $user = Auth::user();
        if(empty($request->phone)){
            return ['status' => false,'msg' => '手机号码不能为空！'];
        }
        if(empty($request->code)){
            return ['status' => false,'msg' => '验证码不能为空！'];
        }
        if(!empty($user->phone)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        $res = User::where('phone',$request->phone)->first();
        if(!empty($res)){
            return ['status' => false,'msg' => '手机号码已绑定！'];
        }
        //验证短信验证码
        $res = new Verify();
        $status = $res->verifyMobileCode($request->phone,$request->code);
        if($status['status'] == false){
            return $status;
        }
        $user->update(['phone' => $request->phone]);
        return ['status' => true,'msg' => '认证成功，等待跳转！'];
    }

    //绑定手机成功跳转页面
    public function bindSuccess()
    {
        return view('home.user.auth_phone.bind_success');
    }

    //修改密码
    public function changePassword()
    {
        return view('home.user.passwords.change_password');
    }
    //更新
    public function updatePassword(Request $request)
    {
        if(empty($request->old_password)){
            return back()->with('error','原始密码不能为空~');
        }
        if(empty($request->password)){
            return back()->with('error','新密码不能为空~');
        }
        $user = Auth::user();
        if(!Hash::check($request->old_password,$user->password)){
            return back()->with('different','原密码错误')->with('error','原始密码错误~');
        }
        if($request->password != $request->confirmation_password){
            return back()->with('confirm','两次密码不一致')->with('error','两次密码不一致~');
        }
        $user->fill(['password' => bcrypt($request->password)])->save();
        Auth::logout();
        return redirect(route('user.change_password.success'));
    }
    //修改成功
    public function changeSuccess()
    {
        return view('home.user.passwords.change_password_success');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('Filedata') and $request->file('Filedata')->isValid()) {

            //数据验证
            $allow = array('image/jpeg', 'image/png', 'image/gif');

            $mine = $request->file('Filedata')->getMimeType();
            if (!in_array($mine, $allow)) {
                return ['status' => 0, 'msg' => '文件类型错误，只能上传图片'];
            }

            //文件大小判断$filePath
            $max_size = 1024 * 1024 * 3;
            $size = $request->file('Filedata')->getClientSize();
            if ($size > $max_size) {
                return ['status' => 0, 'msg' => '文件大小不能超过3M'];
            }

            $date = date("Y_m");
            $path = getcwd() . '/images/users/' . $date;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            //生成新文件名
            $extension = $request->file('Filedata')->getClientOriginalExtension();      //取得之前文件的扩展名

            $file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $extension;
            $request->file('Filedata')->move($path, $file_name);
            $file_path = $path.'/'.$file_name;
            //生成缩略图
            $this->clip($file_path,$path);
            qiniu_upload($file_path);
            $file_name = basename($file_path);
            return ['status' => 1, 'medium' => '/images/users/'.$date.'/thumb_' . $file_name,'thumb' => '/images/users/'.$date.'/' . $file_name];
        }
    }


    public function apply_lecturer_get()//申请讲师页面
    {
        $lec = Lecturer::where('user_id',$this->user->id)->where('status',1)->first();
        if (!empty($lec)){
            return redirect(route('apply_wait'));
        }
        return view('home.user.apply_lecturer.apply_lecturer');
    }

    public function apply_lecturer_wait()//等待申请
    {
        $lecturer = Lecturer::where('user_id',$this->user->id)->where('status',1)->first();
        if(empty($lecturer)){
            return redirect(route('user'));
        }
        return view('home.user.apply_lecturer.apply_wait');
    }

    public function apply_lecturer_store(Request $request)//申请讲师提交
    {
        $user = $this->user;
        if(empty($request->auth_id_number)||empty($request->front_picture)||empty($request->back_picture)){
            return back()->with('error','请将信息补全')->withInput();
        }
        $info = array(
            'user_id'=>$user->id,
            'username'=>$request->username,
            'status'=>1,
            'lecturer_type'=>implode(',',$request->lecturer_type),
            'auth_id_number'=>$request->auth_id_number,
            'created_time'=>Carbon::now(),
            'front_picture'=>$request->front_picture,
            'back_picture'=>$request->back_picture,
            'hand_picture'=>$request->hand_picture,
        );
        Lecturer::create($info);
        return redirect(route('apply_wait'));
    }

    public function applyLecturerEdit()
    {
        $lecturer = Lecturer::where('user_id',$this->user->id)->where('status',3)->first();
        if(empty($lecturer)){
            return redirect(route('user'));
        }
        return view('home.user.apply_lecturer.apply_lecturer_edit')->with('lecturer',$lecturer);
    }

    public function applyLecturerUpdate(Request $request)//重新提交审核
    {
        $user = $this->user;
        if(empty($request->auth_id_number)||empty($request->front_picture)||empty($request->back_picture)){
            return back()->with('error','请将信息补全');
        }
        $lecturer = Lecturer::where('user_id',$user->id)->first();
        $lecturer->update([
            'username'=>$request->username,
            'status'=>1,
            'lecturer_type'=>implode(',',$request->lecturer_type),
            'auth_id_number'=>$request->auth_id_number,
            'created_time'=>Carbon::now(),
            'front_picture'=>$request->front_picture,
            'back_picture'=>$request->back_picture,
            'hand_picture'=>$request->hand_picture,
        ]);
        return redirect(route('apply_wait'));
    }

    //讲师协议
    public function state()
    {
        return view('home.user.apply_lecturer.state');
    }
    
    /**
     * 生成缩略图 thumb medium
     * @param $file_path
     */
    
    private function clip($file_path,$path)
    {
        /**
         * thumb
         */
        $thumb_name = $path. '/thumb_'  . basename($file_path);
        $thumb = Image::make($file_path);
        $thumb->resize(config('images.image.thumb.width'), config('images.image.thumb.height'));
        $thumb->save($thumb_name);
        qiniu_upload($thumb_name);

        /**
         * medium
         */
//        $medium_name = $path . '/medium_' . basename($file_path);
//        $medium = Image::make($file_path);
//        $medium->resize(config('admin.image.medium.width'), config('admin.image.medium.height'));
//        $medium->save($medium_name);
//        qiniu_upload($medium_name);
    }

    public function common_upload(Request $request, $name = 'Filedata', $depath = '/finder/images/')//公共上传图片，非七牛
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
            $thumb->resize(700, 400);
            $thumb->save($thumb_name);
            //返回新文件名
            $result['status'] = 1;
            $result['info'] = $depath . $date . '/' . $file_name;
            return $result;
        }
    }
    
    
}
