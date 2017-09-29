<?php
Route::group(['namespace' => 'Home', 'prefix' => 'lecturer/view'], function () {//我的观点
    Route::get('/','ViewController@index')->name('lecturer.view');//我的观点
    Route::get('/create','ViewController@create')->name('lecturer.view.create');//添加观点
    Route::post('/store','ViewController@store')->name('lecturer.view.store');//发布观点
    Route::get('/{id}','ViewController@show')->name('lecturer.view.show');//观点详情
    Route::post('/upload','ViewController@img_upload');//观点封面图
    Route::put('/update/{id}','ViewController@updateView')->name('lecturer.view.update');
    Route::put('/delete','ViewController@delete')->name('lecturer.view.delete');
});

Route::group(['namespace' => 'Home', 'prefix' => 'lecturer/article'], function () {//我的文章
    Route::get('/','ArticleController@index')->name('lecturer.article');//我的文章
    Route::get('/create','ArticleController@create')->name('lecturer.article.create');//添加文章
    Route::post('/store','ArticleController@store')->name('lecturer.article.store');//发布文章
    Route::get('/{id}','ArticleController@show')->name('lecturer.article.show');//文章详情
    Route::put('/update/{id}','ArticleController@updateArticle')->name('lecturer.article.update');
});