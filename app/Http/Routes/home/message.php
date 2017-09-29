<?php
Route::group(['namespace' => 'Home', 'prefix' => 'message'], function () {//我的消息 问题处理
    Route::get('/','MessageController@index')->name('user.message');//我的消息首页
    Route::get('/show/{id}','MessageController@show')->name('message.show');//消息详情
    Route::get('/lecturer','MessageController@reply')->name('lecturer.message');//问题处理首页
    Route::get('/reply_show/{id}','MessageController@replyShow')->name('lecturer.reply.show');//提问详情
    Route::post('/question','MessageController@question')->name('user.question');//提问
    Route::post('/reply_question','MessageController@replyQuestion')->name('lecturer.reply.question');//回复提问
    Route::put('/remove_reply','MessageController@removeReply')->name('lecturer.remove.reply');//撤销回复
});