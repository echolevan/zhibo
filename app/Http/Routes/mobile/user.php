<?php
Route::get('/user/info','CustomerController@userInfo')->name('mobile.user.info');//我的资料
Route::put('/change/username','CustomerController@changeUserName')->name('mobile.change.username');//我的资料 修改昵称
Route::put('/change/sign','CustomerController@changeSign')->name('mobile.change.sign');//我的资料 修改签名
Route::post('/upload/imgs','CustomerController@upload');//圖象上傳
Route::get('/fans','CustomerController@fans')->name('mobile.fans');