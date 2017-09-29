<?php

namespace App\Http\Controllers\Admin\Rbac;

use App\Http\Controllers\Admin\CommonController;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Validator;

class RoleController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_role' => 'am-in'
        ]);
    }

    public function roleList()//显示角色列表
    {
        $roles = Role::paginate(15);
        return view('admin.rbac.rolelist')->with('roles', $roles);
    }

    public function createRole()//显示添加角色页面
    {
        return view('admin.rbac.createrole');
    }

    public function postRole(Request $request)//添加角色
    {
        $validator = Validator::make($request->all(), $this->role_role, $this->role_msg);
        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }
        $owner = new Role();
        $owner->name = $request->name;
        $owner->display_name = $request->display_name;
        $owner->description = $request->description;
        if ($owner->save()) {
            return back()->with('msg', '添加成功');
        } else {
            return back()->with('error', '添加失败');
        }
    }

    public function updateRole(Request $request)//修改角色信息页面
    {
        $role = Role::find($request->role_id);
        if (empty($role)) {
            return back();
        }
        return view('admin.rbac.updaterole')->with('role', $role);
    }

    public function editRole(Request $request)//修改角色信息
    {
        unset($this->role_role['name']);
        $validator = Validator::make($request->all(), $this->role_role, $this->role_msg);
        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }
        $role = Role::find($request->role_id);
        if (empty($role) || empty($request->name) || strlen($request->name) > 20) {
            return back()->with('error', '修改失败');
        }

        $info = array(
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description
        );
        $role->update($info);
        return back()->with('msg', '修改成功');
    }

    public function delete_role(Request $request)
    {
        Role::where('id', $request->role_id)->delete();
        DB::table('role_user')->where('role_id', $request->role_id)->delete();;
        return back()->with('status', '删除成功');
    }

    public function updateRole_permission(Request $request)//修改角色权限页面
    {
        $role = Role::find($request->role_id);
        if (empty($role)) {
            return back()->with('error', '该角色不存在');
        }
        $permissions = Permission::all();
        return view('admin.rbac.updaterole_permission')->with('role', $role)->with('permissions', $permissions);
    }

    public function editRole_permission(Request $request)//修改角色权限
    {

        $role = Role::find($request->role_id);
        if (empty($role)) {
            return $this->return_api(false, '该角色不存在');
        }
        DB::table('permission_role')->where('role_id', $role->id)->delete();
        if (array_key_exists('permission', $request->all())) {
            $role->perms()->sync($request->permission);
        }
        return $this->return_api(true, '权限修改成功');
    }

    public $role_msg = array(
        'name.required' => '角色名称必须',
        'name.alpha_dash' => '该字段可以包含字母和数字，以及破折号和下划线!不能为中文。',
        'name.max' => '角色名称最多100个字符',
        'name.unique' => '该角色名称已存在',
        'display_name.max' => '角色显示名称最多100个字符',
        'description.max' => '角色说明最多100字符'
    );

    public $role_role = array(
        'name' => 'required|max:100|unique:roles,name|alpha_dash',
        'display_name' => 'sometimes|max:100',
        'description' => 'sometimes|max:100',
    );
}
