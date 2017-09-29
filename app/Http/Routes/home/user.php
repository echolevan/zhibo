<?php

Route::group(['namespace' => 'Home', 'prefix' => 'user'], function () {//用户中心路由
    Route::get('/', 'UserInfoController@index')->name('user');//用户中心页面
    Route::get('/info', 'UserInfoController@userinfo')->name('userinfo');//用户资料
    Route::post('/store_info', 'UserInfoController@store_info')->name('store_info');//修改用戶信息提交
    Route::post('/imgs','UserInfoController@upload')->name('imgs');//圖象上傳

    //绑定手机号
    Route::get('/bind_phone','UserInfoController@bindPhone')->name('user.bind_phone');//手机认证
    Route::post('/auth/phone','UserInfoController@authPhone')->name('user.auth.phone');//认证
    Route::get('/bind_success','UserInfoController@bindSuccess')->name('user.bind.success');//绑定成功

    //修改密码
    Route::get('/change/password','UserInfoController@changePassword')->name('user.change.password');//修改密码页面
    Route::put('/update/password','UserInfoController@updatePassword')->name('user.update.password');//修改密码

    Route::get('/apply_lecturer','UserInfoController@apply_lecturer_get')->name('apply_lecturer_get');//申请讲师提交页面
    Route::post('/apply_store','UserInfoController@apply_lecturer_store')->name('apply_lecturer_store');//申请讲师提交
    Route::get('/apply_wait','UserInfoController@apply_lecturer_wait')->name('apply_wait');//等待审核页面
    Route::post('/common_upload','UserInfoController@common_upload')->name('common_upload');//公共上传
    Route::get('apply_lecturer/edit','UserInfoController@applyLecturerEdit')->name('apply_lecturer_edit');//讲师申请重新提交审核
    Route::put('/apply_update','UserInfoController@applyLecturerUpdate')->name('apply_lecturer_update');//重新提交申请
    Route::get('/lecturer/state','UserInfoController@state')->name('apply.lecturer.state');

    Route::get('withdrawals_index','WithDrawalsController@index')->name('withdrawals_index');//资产中心页面
    Route::get('withdrawals_get','WithDrawalsController@create')->name('withdrawals');//提现页面
    Route::post('withdrawals_store','WithDrawalsController@store')->name('withdrawals_store');//提现提交

});
