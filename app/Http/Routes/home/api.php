<?php
Route::group(['namespace'=>'Api','prefix' => 'api'],function(){
    // chatroom send request
    Route::group(['middleware'=>['authAPI']],function(){
//        Route::get('userList', 'IndexController@userList');              // 初始化本地配置
    });
    Route::get('testcall', 'IndexController@testcall');     
});
