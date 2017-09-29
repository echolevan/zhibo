<?php
Route::group(['namespace' => 'Home', 'prefix' => 'play'], function () {//开播
    Route::get('/','PlayController@index')->name('play');//开播停播
    Route::post('/stop','PlayController@stopLive')->name('live.history');//停止 直播并保存直播回放
    Route::post('/play/stream_status','PlayController@changeStreamStatus')->name('play.stream_status');//启用禁用流
});