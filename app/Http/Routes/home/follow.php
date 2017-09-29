<?php
//我的关注
Route::group(['namespace' => 'Home', 'prefix' => 'follow'], function () {//我的关注
    Route::get('/','FollowController@index')->name('follow');//我的关注
    Route::post('/lecturer','FollowController@follow')->name('follow.lecturer');//关注讲师
    Route::delete('/delete','FollowController@unFollow')->name('unfollow');//取消关注
    Route::delete('/live/delete','FollowController@unFollowLive')->name('live.unfollow');//取消关注
});
//我的粉丝
Route::group(['namespace' => 'Home', 'prefix' => 'fans'], function () {
    Route::get('/','FansController@index')->name('fans');
});