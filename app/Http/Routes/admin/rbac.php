<?php
Route::group(['namespace'=>'Rbac','prefix' => 'rbac'],function(){
    //角色
    Route::get('/create_role','RoleController@createRole')->name('createRole');//增加角色页面postRole
    Route::post('/postRole','RoleController@postRole')->name('postRole');//增加角色
    Route::get('/rolelist','RoleController@roleList')->name('rolelist');//角色列表
    Route::get('/roleinfoupdate/{role_id}','RoleController@updateRole')->name('role_info_update');//修改角色页面editRole
    Route::post('/roleinfoedit','RoleController@editRole')->name('editRole');//修改角色信息
    Route::get('/updateRole_permission/{role_id}','RoleController@updateRole_permission')->name('updateRole_permission');//修改角色权限页面
    Route::post('/editRole_permission','RoleController@editRole_permission')->name('editRole_permission');;//修改角色权限
    Route::get('/delete_role/{role_id}','RoleController@delete_role')->name('delete_role');//删除角色
    //-管理员
    Route::get('/adminlist','AdminUserController@adminlist')->name('adminlist');//管理员列表
    Route::get('/giverole/{admin_id}','AdminUserController@giveRole')->name('giverole');//为管理员分配角色页面createAdminrole
    Route::get('/create_admin','AdminUserController@createAdmin')->name('create_admin');//新增管理员页面
    Route::post('/addAdmin','AdminUserController@addAdmin')->name('addAdmin');//新增管理员
    Route::post('/createAdminrole','AdminUserController@editAdmin')->name('createAdminrole');//修改管理员信息
    Route::get('/delete_admin/{admin_id}','AdminUserController@delete_admin')->name('delete_admin');//删除管理员
    // Route::get('/reset_password','AdminUserController@resetPassword')->name('resetpassword');//后台密码重置页面
    Route::get('/reset_password',function(){
        return view('admin.rbac.resetpassword');
    })->name('resetpassword');//后台密码重置页面
    Route::post('postreset_password','AdminUserController@reset')->name('postreset');//后台密码重置


    //-权限
    Route::get('/permissionList','PermissionController@PermissionList')->name('Permissionlist');//权限列表
    Route::get('/createPermission','PermissionController@createPermission')->name('createPermission');//增加权限页面
    Route::post('/addPermission','PermissionController@addPermission')->name('addPermission');//增加权限
    Route::get('/updatePermission/{permission_id}','PermissionController@updatePermission')->name('updatePermission');//修改权限页面
    Route::post('/editPermission','PermissionController@editPermission')->name('editPermission');//修改权限
    Route::get('/deletePermission/{permission_id}','PermissionController@deletePermission')->name('deletePermission');//删除权限
});