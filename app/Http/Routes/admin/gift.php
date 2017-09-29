<?php
Route::group(['prefix' => 'gift','as'=>'gift_'], function () {//礼物管理
    Route::get('/index','GiftController@index')->name('index');//礼物列表
    Route::get('/create','GiftController@create')->name('create');//添加礼物页面
    Route::post('/store','GiftController@store')->name('store');//添加礼物提交
    Route::get('/update/{id}','GiftController@update')->name('update');//修改礼物页面
    Route::post('/edit','GiftController@edit')->name('edit');//修改礼物提交
    Route::get('/delete/{id}','GiftController@delete')->name('delete');//删除礼物

    //送礼记录
    Route::get('/history','GiftController@history')->name('history');
});