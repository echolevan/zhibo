<?php
Route::get('/','IndexController@index')->name('mobile');
Route::get('/customer','CustomerController@index')->name('mobile.customer');
Route::get('/state','IndexController@state')->name('mobile.state');