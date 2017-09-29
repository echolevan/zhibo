<?php
Route::group(['prefix' => 'qqcs'],function(){
    Route::get('/createQqcs','QqcsController@createQqcs')->name('createQqcs');
    Route::get('/delQqcs','QqcsController@delQqcs')->name('delQqcs');
    Route::post('/updateQqcs','QqcsController@updateQqcs')->name('updateQqcs');
    Route::get('/editQqcs/{id}','QqcsController@editQqcs')->name('editQqcs');
    Route::post('/addQqcs','QqcsController@addQqcs')->name('addQqcs');
    Route::get('/searchQqcs','QqcsController@searchQqcs')->name('searchQqcs');
    Route::get('/qqcsList','QqcsController@index')->name('qqcsList');

});