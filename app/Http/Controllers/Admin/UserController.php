<?php

namespace App\Http\Controllers\Admin;

use App\Models\Consume;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //

    public function index()//注册用户列表
    {
        $users = User::with('oauth')->get();
        return view('admin.user.index')->with('users', $users);
    }

    public function create()//新增用户页面
    {
        return view('admin.user.create');
    }

    public function store(Request $request)//新增用户提交
    {
        if (empty($request->name)) {
            return back()->with('error', '昵称用于登录，不能为空！')->withInput();
        }
        if (empty($request->password)) {
            return back()->with('error', '密码不能为空！')->withInput();
        }
        $v_name = User::where('name', $request->name)->first();
        if ($v_name) {
            return back()->with('error', '该昵称已经存在，请换一个！')->withInput();
        }
        $v_phone = User::where('phone', $request->phone)->where('phone', '!=', '')->first();
        if ($v_phone) {
            return back()->with('error', '手机号已经存在！')->withInput();
        }
        if ($request->gold < 0) return back()->with('error', '初始金币不能小于0！')->withInput();
        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'thumb' => '/homestyle/images/admin.png',
            'gold' => $request->gold,
            'Level' => $request->Level,
            'sex' => $request->sex,
            'created_at' => Carbon::now(),
        ]);
        return redirect(route('admin.user'))->with('msg', '用户增加成功');
    }

    public function update(Request $request)//修改用户信息页面
    {
        $user = User::find($request->id);
        if (empty($user)) return back()->with('error', '用户不存在');
        return view('admin.user.update')->with('user', $user);
    }

    public function edit(Request $request)
    {
        $user = User::find($request->id);
        if (empty($user)) return back()->with('error', '用户不存在')->withInput();
        if (empty($request->name)) {
            return back()->with('error', '昵称用于登录，不能为空！')->withInput();
        }
        $v_name = User::where('name', $request->name)->where('name','!=', $user->name)->first();
        if ($v_name && $user->name != $request->name) {
            return back()->with('error', '该昵称已经存在，请换一个！')->withInput();
        }
        $v_phone = User::where('phone', $request->phone)->where('phone', '!=', '')->first();
        if ($v_phone && $user->phone != $request->phone) {
            return back()->with('error', '手机号已经存在！')->withInput();
        }
        if ($request->gold < 0) return back()->with('error', '初始金币不能小于0！')->withInput();
        $info = array(
            'name' => $request->name,
            'phone' => $request->phone,
            'gold' => $request->gold,
            'Level' => $request->Level,
            'sex' => $request->sex,
        );
        if ($request->password != '') $info['password'] = bcrypt($request->password);
        $user->update($info);
        return redirect(route('admin.user'))->with('msg', '用户修改成功');
    }

    public function delete(Request $request)//更改会员状态永久冻结
    {
        $user = User::find($request->id);
        if (empty($user)) return back()->with('error', '用户不存在');
        if ($user->status == 3) $user->status = 1;
        if ($user->status == 1) $user->status = 3;
        $user->save();
        return back()->with('msg', '操作成功');
    }

    public function add_gold(Request $request)//增加金币
    {
        $user = User::find($request->id);
        if (empty($user)) return back()->with('error', '用户不存在');
        if (!is_numeric($request->gold) || $request->gold <= 0) return $this->return_api(false, '请填写正确金额');
        $user->gold = $user->gold + $request->gold;
        $user->save();
        return $this->return_api(true, '成功增加成功' . $request->gold . '个金币');
    }

    public function addFake($id)
    {
        $user = User::find($id);
        if(empty($user)){
            return redirect(route('admin.user'));
        }
        if($user->type != 2){
            return redirect(route('admin.user'));
        }
        return view('admin.user.fake')->with('user',$user);
    }

    public function createFake(Request $request,$id)
    {
        if (empty($request->name)) {
            return back()->with('error', '昵称用于登录，不能为空！')->withInput();
        }
        if (empty($request->password)) {
            return back()->with('error', '密码不能为空！')->withInput();
        }
        $v_name = User::where('name', $request->name)->first();
        if ($v_name) {
            return back()->with('error', '该昵称已经存在，请换一个！')->withInput();
        }
        User::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'thumb' => '/homestyle/images/admin.png',
            'pid' => $id,
            'fake' => 2,
            'created_at' => Carbon::now(),
        ]);
        return redirect(route('admin.user'))->with('msg', '增加成功');
    }

    public function consumes($id)
    {
        $consumes = Consume::with('toUser')->where('user_id',$id)->orderBy('id','desc')->get();
        return view('admin.user.consumes')->with('consumes',$consumes);
    }
}
