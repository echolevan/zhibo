<?php
Route::post('login', 'Auth\AuthController@postLogin');
Route::post('register', 'Auth\AuthController@register');
Route::get('logout', 'Auth\AuthController@getLogout');
Route::post('send_code','HomeController@sendMobileCode')->name('send.mobileCode');

//忘记密码
Route::get('forget/password','Auth\PasswordController@index')->name('forget.password');
Route::get('captcha','Auth\PasswordController@mews')->name('forget.mews');//图形验证码
Route::post('forget/send','Auth\PasswordController@forgetSendPassword')->name('forget.send');//发送验证码
Route::post('forget/check','Auth\PasswordController@checkForgetUser')->name('forget.check');//验证身份
Route::get('forget/reset','Auth\PasswordController@resetPassword')->name('forget.reset');//重置密码页面
Route::put('update_password','Auth\PasswordController@updatePassword')->name('update.password');//重置密码
Route::get('reset/success','Auth\PasswordController@resetSuccess')->name('reset.success');//重置密码页成功
