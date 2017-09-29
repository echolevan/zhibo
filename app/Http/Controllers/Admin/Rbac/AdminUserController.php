<?php

namespace App\Http\Controllers\Admin\Rbac;

use App\Admin_user;
use App\Http\Controllers\Admin\CommonController;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminUserController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
           '_admin_user' => 'am-in'
        ]);
    }

    public function adminlist()//管理员列表
    {
        $admins = Admin_user::paginate(15);
        return view('admin.rbac.adminlist')->with('users',$admins);
    }

    public function createAdmin()//新增管理员页面
    {
        $roles = Role::all();
        return view('admin.rbac.createadmin')->with('roles',$roles)->with('createadmin','active');
    }

    public function addAdmin(Request $request)
    {
        $validator = Validator::make($request->all(),$this->editrule,$this->editmsg);
        if($validator->fails()){
            return back()->with('errors',$validator->errors()->first());
        }
        if ($request->password != $request->password_confirmation) {
            return back()->with('error','请重新输入密码');
        }
        $email_user = Admin_user::where('email',$request->email)->first();
        if(!empty($email_user)){
            return back()->with('error','该邮箱已重复');
        }
        $admin = Admin_user::create(
            [
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
            ]
        );
        if(array_key_exists('roles',$request->all())){
            DB::table('role_user')->where("user_id",$admin->id)->delete();
            foreach ($request->all()['roles'] as $v){
                $admin->roles()->attach($v);
            }
        }
        return back()->with('msg','新增管理员成功');

    }

    public function giveRole(Request $request)//分配管理员到角色页面
    {
        $admin = Admin_user::find($request->admin_id);
        if (empty($admin)) {
            return back();
        }
        $roles = Role::all();
        return view('admin.rbac.giverole')->with('admin', $admin)->with('roles', $roles);
    }

    public function editAdmin(Request $request)//修改管理员信息
    {
        $validator = Validator::make($request->all(), $this->editrule, $this->editmsg);
        if ($validator->fails()) {
            return $this->return_api(false, $validator->errors()->first());
        }
        $user = Admin_user::find($request->admin_id);
        if (empty($user)) {
            return $this->return_api(false, '用户不存在');
        }
        if ($request->email != $user->email) {
            $email_user = Admin_user::where('email', $request->email)->first();
            if (!empty($email_user)) {
                return $this->return_api(false, '该邮箱已重复');
            }
        }
        if ($request->name != $user->name || $request->password != '') {
            $user->update([
                'name' => $request->name,
                'password' => bcrypt($request->password),
            ]);
        }
        if (array_key_exists('roles', $request->all())) {
            DB::table('role_user')->where("user_id", $request->admin_id)->delete();
            foreach ($request->all()['roles'] as $v) {
                $user->roles()->attach($v);
            }
        }
        return $this->return_api(true, '修改成功');
    }

    public function delete_admin(Request $request)
    {
        Admin_user::where('id', $request->admin_id)->delete();
        DB::table('role_user')->where('user_id', $request->admin_id)->delete();
        return back()->with('msg', '删除成功');
    }

    public function resetPassword()//重置密码页面
    {
        return view('admin.rbac.resetpassword');
    }

    public function reset(Request $request)//重置密码
    {
        if (empty($request->password) || strlen($request->password) < 6) {
            return $this->return_api(false, '密码长度太短');
        }
        $user = Auth::guard('admin')->user();
        $user->update(['password' => bcrypt($request->password)]);
        return back()->with('msg','修改成功');

    }

    public $editrule = array(
        'name' => 'required|max:255',
        'email' => 'required|email|max:255',
        'password' => 'sometimes|min:6',
    );

    public $editmsg = array(
        'name.required' => '请管理员用户名',
        'name.max' => '管理员用户名太长',
        'password.min' => '密码太短',
        'email.required' => '请填写管理员邮箱',
        'email.email' => '请填写正确的邮箱地址',
        'email.max' => '邮箱地址太长'
    );
}
