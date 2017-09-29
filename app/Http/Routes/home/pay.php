<?php
Route::group(['namespace' => 'Home'], function () {//支付
    Route::group(['middleware' => ['auth','user.status']], function () {
        Route::get('/pay/record','PayController@payRecord')->name('pay.record');//交易记录
        Route::get('/pay/type','PayController@payType')->name('pay.type');//选择支付方式
    });
    Route::post('/alipay/pay','PayController@alipay')->name('alipay');//发起请求
    Route::any('/pay/alipayNotify','PayNotifyController@alipayNotify');

    Route::post('/pay/wxpay','PayController@wxpay')->name('wxpay');
    Route::any('/pay/wxpng/{pngcode}','PayController@wxpng');
});