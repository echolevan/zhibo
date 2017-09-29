<?php


Route::group(['prefix' => 'user','as'=>'admin.'], function () {//前台用户管理
    Route::get('/', 'UserController@index')->name('user');//用户管理
    Route::get('/create','UserController@create')->name('user_create');//增加用户页面
    Route::post('/store','UserController@store')->name('user_store');//增加用户提交
    Route::get('/update/{id}', 'UserController@update')->name('user_update');//修改用户信息页面
    Route::post('/edit', 'UserController@edit')->name('user_edit');//修改用户信息
    Route::post('/add_gold', 'UserController@add_gold')->name('user_add_gold');//增加用户金币
    Route::get('/delete/{id}','UserController@delete')->name('user_delete');
    Route::get('/add/fake/{id}','UserController@addFake')->name('add.fake');//添加送礼会员
    Route::post('/create/fake/{id}','UserController@createFake')->name('create.fake');//添加
    Route::get('/consumes/{id}','UserController@consumes')->name('consumes');//消费详情
});