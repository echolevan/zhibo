<?php
Route::get('/back_live','BackLiveController@index')->name('mobile.back_live');
Route::get('/back_live/details/{id}','BackLiveController@details')->name('mobile.back_live.details');