<?php
Route::get('/weibo','Auth\OauthController@weibo')->name("weibo");
Route::get('/weibo/login','Auth\OauthController@weiboLogin');
Route::get('/qq','Auth\OauthController@qq')->name("qq");
Route::get('/qq/login','Auth\OauthController@qqLogin');