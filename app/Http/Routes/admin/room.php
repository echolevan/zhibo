<?php
Route::group(['prefix' => 'room'],function(){
    Route::get('/','RoomController@index')->name('room');//房间首页
    Route::get('/video/model','RoomController@videoList')->name('room.video.model');//房间首页相册模式
    Route::get('/create','RoomController@create')->name('room.create');//新建房间页面
    Route::post('/store','RoomController@store')->name('room.store');//创建房间
    Route::get('/edit/{id}','RoomController@edit')->name('room.edit');//房间详情
    Route::post('/update','RoomController@update')->name('room.update');//修改房间信息
    Route::post('/stream_status','RoomController@changeStreamStatus')->name('room.stream_status');//启用禁用流
    Route::post('/close','RoomController@close')->name('room.close');//关闭房间
});
