<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Home\CommonController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Verify;
use Captcha;
use Cookie;
use Validator;
use App\User;

class PasswordController extends CommonController
{
    //图形验证码
    public function mews()
    {
        return Captcha::create('default');
    }


    public function index()
    {
        return view('home.auth.passwords.forget');
    }

    //发送短信验证码
    public function forgetSendPassword(Request $request)
    {
        $user_check = User::where('phone',$request->phone)->first();
        if(empty($user_check)){
            return ['status' => false,'msg' => '你还没有注册，请先注册！'];
        }
        $res = new Verify();
        return $res->sendMobileCode($request->phone);
    }

    //检查身份
    public function checkForgetUser(Request $request)
    {
        if(empty($request->phone)){
            return ['status' => false,'msg' => '手机号码不能为空！'];
        }
        if(empty($request->img_code)){
            return ['status' => false,'msg' => '图形验证码不能为空！'];
        }
        if(empty($request->mobile_code)){
            return ['status' => false,'msg' => '短信验证码不能为空！'];
        }
        //检车图形验证码是否正确
        $validator = Validator::make(['code' => $request->img_code], [
            'code' => 'captcha',
        ]);
        if ($validator->fails()) {
            return ['status' => false,'msg' => '图形验证码验证码错误！'];
        }
        $res = new Verify();
        $verify = $res->verifyMobileCode($request->phone,$request->mobile_code);
        if($verify['status'] == false){
            return $verify;
        }
        $cookie = Cookie::make('forget','reset.password',30);
        session()->put('reset_phone',$request->phone);
        $token = md5(env('APP_KEY')).md5($request->phone);
        $url = url('forget/reset').'?token='.$token;
        $status = ['status' => true,'msg' => '操作成功，等待跳转！','info' => $url];
        return response($status)->withCookie($cookie);
    }

    //验证身份成功，跳转到重置密码页面
    public function resetPassword(Request $request)
    {
        $token =  $request->token;
        if(empty($token)){
            return redirect(route('forget.password'));
        }
        $cookie = Cookie::get('forget');
        if(empty($cookie)){
            return redirect(route('forget.password'));
        }
        $t = md5(env('APP_KEY')).md5(session()->get('reset_phone'));
        if($token != $t){
            return redirect(route('forget.password'));
        }
        return view('home.auth.passwords.reset');
    }

    //重置密码
    public function updatePassword(Request $request)
    {
        if(empty(session()->get('reset_phone'))){
            return redirect(route('forget.password'));
        }
        if(empty($request->reset_password)){
            return back()->with('msg','密码不能为空');
        }
        $validator = Validator::make(['password' => $request->reset_password], [
            'password' => 'min:6',
        ]);
        if ($validator->fails()) {
            return back()->with('msg','密码不能少于6位~');
        }
        if (preg_match("/\s/", $request->reset_password)) {
            return back()->with('msg','密码中包含非法字符，请重新输入~');
        }
        if($request->reset_password != $request->reset_password_confirmation){
            return back()->with('different','两次密码不一致！');
        }
        $cookie = Cookie::get('forget');
        if(empty($cookie)){
            return redirect(route('forget.password'));
        }
        $user = User::where('phone',session()->get('reset_phone'))->first();
        $user->update(['password' => bcrypt($request->reset_password)]);
        $token = md5(env('APP_KEY')).md5(session()->get('reset_phone'));
        return redirect(url('reset/success').'?token='.$token);
    }

    public function resetSuccess(Request $request)
    {
        if(empty(session()->get('reset_phone'))){
            return redirect(route('forget.password'));
        }
        $token =  $request->token;
        if(empty($token)){
            return redirect(route('forget.password'));
        }
        session()->forget('reset_phone');
        return view('home.auth.passwords.success');
    }
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    //use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware($this->guestMiddleware());
//    }

}
