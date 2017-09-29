<?php

namespace App\Http\Controllers\Admin\Rbac;

use App\Http\Controllers\Admin\CommonController;
use App\Permission;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;

class PermissionController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_permission' => 'am-in'
        ]);
    }

    public function permissionList()//权限列表
    {
        $permissions = Permission::get_permissions();
        return view('admin.rbac.permissionlist')->with('permissions', $permissions);
    }

    public function createPermission()//显示增加权限的页面
    {
        $per = Permission::where('level', '=', 1)->get();
        return view('admin.rbac.create_permission')->with('per', $per);
    }

    public function addPermission(Request $request)//增加权限
    {
        $validator = Validator::make($request->all(), $this->createrole, $this->createmsg);
        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }
        $info = $request->all();
        $level = 1;
        if ($info['pid'] != 0) {
            $per = Permission::find($info['pid']);
            $level = empty($per) ? $level : $per->level+1;
        }
        $info['level'] = $level;
        Permission::create($info);
        return back()->with('msg', '添加成功');

    }

    public function deletePermission(Request $request)//删除权限
    {
        Permission::where('id', $request->permission_id)->delete();
        DB::table('permission_role')->where('permission_id', $request->permission_id)->delete();;
        return back()->with('status', '删除成功');
    }

    public function updatePermission(Request $request)//修改权限页面
    {
        $permission = Permission::find($request->permission_id);
        if (empty($permission)) {
            return back()->with('error', '不存在');
        }
        $per_zero = Permission::where('level', '=', 1)->get();
        return view('admin.rbac.updatepermission')->with('per', $permission)->with('per_zero', $per_zero);
    }

    public function editPermission(Request $request)//修改权限
    {
        $permission = Permission::find($request->permission_id);
        if (empty($permission)) {
            return back()->with('error', '不存在');
        }
        if ($permission->name != $request->name) {
            $create_name = Permission::where('name', $request->name)->first();
            if (!empty($create_name)) {
                return back()->with('error', '唯一标识有重复');
            }
            $permission->update(['name' => $request->name]);
        }
        $permission->update(
            [
                'pid' => $request->pid,
                'display_name' => $request->display_name,
                'description' => $request->description
            ]
        );
        return back()->with('msg', '修改成功');
    }


    public $createrole = array(
        'name' => 'required|max:100|unique:permissions,name',
        'display_name' => 'sometimes|max:100',
        'description' => 'sometimes|max:100',
    );

    public $createmsg = array(
        'name.required' => '权限名称不能为空',
        'name.alpha_dash' => '权限名称可以包含字母和数字，以及破折号和下划线!不能为中文。',
        'name.max' => '权限名称最多100个字符',
        'name.unique' => '该权限名称已存在',
        'display_name.max' => '权限名称太长',
        'description.max' => '权限说明太长'
    );

}
