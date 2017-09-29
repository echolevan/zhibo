<?php
/*
|--------------------------------------------------------------------------
|   *** 七牛配置 修改
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'qiniu'],function(){
    Route::get('/qiniu_config','SystemController@qiniuConfig')->name('qiniu.config');//七牛配置

    Route::put('/update/qiniu_config','SystemController@updateQiniuConfig')->name('qiniu.config.update');//更新七牛配置

    Route::get('/oauth_config','SystemController@oauthConfig')->name('oauth.config');//第三方登陆配置

    Route::put('/update/oauth_config','SystemController@updateOauthConfig')->name('oauth.config.update');//更新第三方配置


});

//-------------------------------------------------------------------------