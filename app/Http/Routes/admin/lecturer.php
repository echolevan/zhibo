<?php
Route::get('/lecturer/check/list','LecturerController@checkList')->name('lecturer.check.list');//讲师审核列表
Route::get('/lecturer/reject/list','LecturerController@rejectList')->name('lecturer.reject.list');//讲师申请驳回列表
Route::get('/lecturer/check/info/{id}','LecturerController@checkInfo')->name('lecturer.check.info');//审核详情
Route::post('/lecturer/check/reject','LecturerController@checkReject')->name('lecturer.check.reject');//驳回申请
Route::post('/lecturer/check/open','LecturerController@checkOpen')->name('lecturer.check.open');//通过申请
Route::post('/lecturer/status','LecturerController@changeStatus')->name('lecturer.changeStatus');//修改讲师状态
Route::resource('lecturer','LecturerController', [
    'only' => [
        'index', 'create','edit','store','update'
    ],
    'names' => [
        'index' => 'lecturer',
        'create' => 'lecturer.create',
        'edit' => 'lecturer.edit',
        'store' => 'lecturer.store',
        'update' => 'lecturer.update'
    ]
]);

