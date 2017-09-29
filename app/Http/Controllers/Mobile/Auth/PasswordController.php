<?php

namespace App\Http\Controllers\Mobile\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Verify;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
class PasswordController extends Controller
{
    public function index()
    {
        return view('mobile.auth.password.forget');
    }

    public function resetPassword(Request $request)
    {
        if(empty($request->phone)){
            return ['status' => false,'msg' => '电话号码不能为空'];
        }
        if(empty($request->password)){
            return ['status' => false,'msg' => '密码不能为空'];
        }
        $validator = Validator::make(['password' => $request->password], [
            'password' => 'min:6',
        ]);
        if ($validator->fails()) {
            return ['status' => false,'msg' => '密码不能少于6位~'];
        }
        if (preg_match("/\s/", $request->password)) {
            return ['status' => false,'msg' => '密码中包含非法字符，请重新输入~'];
        }
        if(empty($request->code)){
            return ['status' => false,'msg' => '验证码不能为空'];
        }
        //检查用户是否存在
        $user = User::where('phone',$request->phone)->first();
        if(empty($user)){
            return ['status' => false,'msg' => '您还没有注册！'];
        }
        $res = new Verify();
        $verify = $res->verifyMobileCode($request->phone,$request->code);
        if($verify['status'] == false){
            return $verify;
        }
        $user->update(['password' => bcrypt($request->password)]);
        return ['status' => true,'msg' => '修改成功！'];
    }
}
