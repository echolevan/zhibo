<?php
Route::group(['namespace' => 'Home', 'prefix' => 'lecturer/live_message'], function () {//直播通知
    Route::get('/','LiveMessageController@index')->name('live.message');
    Route::get('/create','LiveMessageController@create')->name('live.message.create');//添加直播通知
    Route::post('/store','LiveMessageController@store')->name('live.message.store');//添加预播
    Route::get('/edit/{id}','LiveMessageController@edit')->name('live.message.edit');//预播详情
    Route::put('/update/{id}','LiveMessageController@update')->name('live.message.update');//编辑详情
    Route::delete('/delete','LiveMessageController@delete')->name('live.message.delete');//删除直播通知
});