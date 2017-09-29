<?php
Route::group(['namespace' => 'Home', 'prefix' => 'promotion'], function () {//推广中心
    Route::get('/','PromotionController@index')->name('promotion');//推广中心首页
});