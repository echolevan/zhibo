<?php
Route::group(['namespace' => 'Home\Customer','prefix'=>'customer'],function (){
    Route::get('/article/{user_id}','IndexController@index')->name('customer.article');
    Route::get('/view/{user_id}','ViewController@index')->name('customer.view');
    Route::get('/live/{user_id}','LiveController@index')->name('customer.live');
});