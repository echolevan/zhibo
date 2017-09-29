<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Follow;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Image;
class CustomerController extends Controller
{
    public function __construct()
    {
        if (\Auth::check()) {
            $auth = \Auth::user();
            $userinfo = User::with('oauth')->find($auth->id);
            $this->user = $userinfo;
            view()->share([
                'userinfo' => $userinfo,
                '_mobile_customer' => 'curr'
            ]);
        } else {
            view()->share([
                '_mobile_customer' => 'curr'
            ]);
        }

    }

    public function index()
    {
        return view('mobile.user.index');
    }

    public function userInfo()
    {
        if (empty($this->user->name)) {
            $name = $this->user->oauth->nickname;
        } else {
            $name = $this->user->name;
        }
        return view('mobile.user.info')->with('name', $name);
    }

    public function changeUserName(Request $request)
    {
        if (empty($request->name)) {
            return ['status' => false, 'msg' => '昵称不能为空！'];
        }
        $user = User::find($this->user->id);
        //检查新昵称是否重复
        $checkUser = User::where('name', $request->name)->where('name', '!=', $user->name)->first();
        if (!empty($checkUser)) {
            return ['status' => false, 'msg' => '昵称已经存在！'];
        }
        $user->update(['name' => $request->name]);
    }

    public function changeSign(Request $request)
    {
        $user = User::find($this->user->id);
        $user->update(['sign' => $request->sign]);
    }

    public function fans()
    {
        $fans = Follow::with('fans')->where('user_id',$this->user->id)->paginate(12);
        return view('mobile.user.fans')->with('fans',$fans);
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
            $file_path = $path . '/' . $file_name;
            //生成缩略图
            $this->clip($file_path, $path);
            qiniu_upload($file_path);
            $file_name = basename($file_path);
            $user = User::find($this->user->id);
            $user->update(['thumb' => '/images/users/' . $date . '/thumb_' . $file_name]);
            return ['status' => 1, 'medium' => '/images/users/' . $date . '/thumb_' . $file_name, 'thumb' => '/images/users/' . $date . '/' . $file_name];
        }
    }

    private function clip($file_path, $path)
    {
        /**
         * thumb
         */
        $thumb_name = $path . '/thumb_' . basename($file_path);
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

    public function configSet()
    {
        return view('mobile.user.system');
    }

}
