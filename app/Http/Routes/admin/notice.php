<?php
Route::group(['prefix' => 'notice'],function(){
    Route::get('/createNotice','NoticeController@createNotice')->name('createNotice');
    Route::get('/delNotice','NoticeController@delNotice')->name('delNotice');
    Route::post('/updateNotice','NoticeController@updateNotice')->name('updateNotice');
    Route::get('/editNotice/{id}','NoticeController@editNotice')->name('editNotice');
    Route::post('/addNotice','NoticeController@addNotice')->name('addNotice');
    Route::get('/searchNotice','NoticeController@searchNotice')->name('searchNotice');
    Route::get('/noticeList','NoticeController@index')->name('noticeList');

});