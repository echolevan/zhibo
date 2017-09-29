<?php
Route::get('/view','ArticleController@index')->name('mobile.view');
Route::get('/view/{id}','ArticleController@details')->name('mobile.view.details');