<?php
/**
 * @author: hemengze@cmstop.com
 * Date: 2017/9/23 22:35
 */

Route::group(['namespace' => 'Home','prefix'=>'relay','as'=>'relay.'],function (){
    Route::any('/','RelayController@index')->name('index');//讲师中心页面
    Route::get('/detail','RelayController@detail')->name('detail');//讲师中心页面
    Route::post('/amount', 'RelayController@amount')->name('amount');
    Route::post('/relay', 'RelayController@relay')->name('relay');
    Route::post('/cancel', 'RelayController@cancel')->name('cancel');
});