<?php
Route::get('login', 'Auth\AuthController@getLogin');
//Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('register', 'Auth\AuthController@getRegister');
//Route::post('/register', 'Auth\AuthController@register');
Route::get('/logout', 'Auth\AuthController@logout');
Route::get('/forget', 'Auth\PasswordController@index')->name('mobile.forget.password');
Route::post('/reset', 'Auth\PasswordController@resetPassword')->name('mobile.reset.password');