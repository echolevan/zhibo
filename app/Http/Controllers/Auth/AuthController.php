<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Verify;
use App\Models\Award;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
//    protected function validator(array $data)
//    {
//        return Validator::make($data, [
//            'name' => 'required|max:255',
//            'email' => 'required|email|max:255|unique:users',
//            'password' => 'required|min:6|confirmed',
//        ]);
//    }

//登陆
    public function postLogin(Request $request)
    {
        $name = $request->name;
        if(empty($name)){
            return ['status' => false,'msg' => '登陆名不能为空！'];
        }
        $password = $request->password;
        if(empty($password)){
            return ['status' => false,'msg' => '密码不能为空！'];
        }
        if( empty($remember)) {  //remember表示是否记住密码
            $remember = 0;
        } else {
            $remember = $request->remember;
        }
        //验证账号状态
        $user = User::where('name',$request->name)->first();
        if(empty($user)){
            $user = User::where('phone',$request->name)->first();
        }
        if(empty($user)){
            return ['status' => false,'msg' => '账号不存在！'];
        }
        if($user->status != 1){
            return ['status' => false,'msg' => '您的账号已被冻结！'];

        }

        //如果要使用记住密码的话，需要在数据表里有remember_token字段
        if (Auth::attempt(['name' => $name, 'password' => $password], $remember)) {
            $user->update(['login_time' => Carbon::now()]);
            return ['status' => true,'msg' => '登陆成功，等待跳转！'];
        }
        if (Auth::attempt(['phone' => $name, 'password' => $password], $remember)) {
            $user->update(['login_time' => Carbon::now()]);
            return ['status' => true,'msg' => '登陆成功，等待跳转！'];
        }
        return ['status' => false,'msg' => '用户名或密码错误!'];
    }


    //注册
    public function register(Request $request)
    {
        //验证字段
        if(empty($request->name)){
            return ['status' => false,'msg' => '昵称可用于登陆，不能为空'];
        }
        $check_name = User::where('name',$request->name)->first();
        if(!empty($check_name)){
            return ['status' => false,'msg' => '昵称已存在！'];
        }
        if(empty($request->phone)){
            return ['status' => false,'msg' => '电话号码不能为空'];
        }
        if (preg_match("/\s/", $request->password)) {
            return ['status' => false,'msg' => '密码中包含非法字符，请重新输入~'];
        }
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return ['status' => false,'msg' => '请按要求填写密码！'];
        }
        //验证短信验证码
        $res = new Verify();
        $status = $res->verifyMobileCode($request->phone,$request->code);
        if($status['status'] == false){
            return $status;
        }
        if(session()->has('promotion')){
            $pid = session()->get('promotion');
            $parent = User::find($pid);
            $parent->update(['gold' => ($parent->gold)+config('promotion.register_award')]);

        }else{
            $pid = '';
        }
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
            'login_time' => Carbon::now(),
            'thumb' => '/homestyle/images/admin.png',
            'ip' => $request->ip(),
            'pid' => $pid
        ]);
        if(session()->has('promotion')){
            Award::create([
                'from_id' => $user->id,
                'user_id' => $pid,
                'type' => 1,
                'price'=> config('promotion.register_award'),
                'created_time' => Carbon::now()
            ]);
        }
        Auth::guard($this->getGuard())->login($user);
        session()->forget('promotion');
        return ['status' => true,'msg' => '注册成功，等待跳转！'];
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
//    protected function create(array $data)
//    {
//        return User::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => bcrypt($data['password']),
//        ]);
//    }
}
