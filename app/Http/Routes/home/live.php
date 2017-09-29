<?php
Route::group(['namespace' => 'Home', 'prefix' => 'live'], function () {//直播室
    Route::get('/{user_id}/{streams}','LiveController@index')->name('live');
	Route::post('/vipRoomCheck','LiveController@vipRoomCheck')->name('vip_check');
    Route::get('/ban','LiveController@ban');//禁言
    Route::post('/present','LiveController@giveGift')->name('give.gift');//送礼物
});