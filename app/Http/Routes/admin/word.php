
<?php
Route::group(['prefix' => 'word'],function(){
    Route::get('/createWord','WordController@createWord')->name('createWord');
    Route::get('/delWord','WordController@delWord')->name('delWord');
    Route::post('/updateWord','WordController@updateWord')->name('updateWord');
    Route::get('/editWord/{id}','WordController@editWord')->name('editWord');
    Route::post('/addWord','WordController@addWord')->name('addWord');
    Route::get('/searchWord','WordController@searchWord')->name('searchWord');
    Route::get('/wordList','WordController@index')->name('wordList');

});