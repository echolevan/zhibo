<?php
Route::group(['namespace' => 'Home','prefix'=>'lecturer','as'=>'lecturer_'],function (){
    Route::get('/','LecturerController@index')->name('index');//讲师中心页面
    Route::get('/room','LecturerController@info')->name('room');//直播室信息
    Route::post('/room/update','LecturerController@updateRoomInfo')->name('update_room');
    Route::post('/room/upload','LecturerController@img_upload');//观点封面图
});

//直播历史
Route::group(['namespace' => 'Home','prefix'=>'history','as'=>'history.'],function (){
    Route::get('/live','LiveHistoryListController@index')->name('live');
    Route::put('/delete','LiveHistoryListController@delete')->name('live.delete');
});