<?php
Route::group(['prefix' => 'article'],function(){
    //文章管理
    Route::get('/articleList','ArticleController@index')->name('articleList');//文章列表
    Route::get('/createArticle','ArticleController@createArticle')->name('createArticle');
    Route::get('/delArticle','ArticleController@delArticle')->name('delArticle');
    Route::post('/updateArticle','ArticleController@updateArticle')->name('updateArticle');
    Route::post('/addArticle','ArticleController@addArticle')->name('addArticle');
    Route::get('/searchArticle','ArticleController@searchArticle')->name('searchArticle');//文章搜索
    Route::get('/editArticle/{id}','ArticleController@editArticle')->name('editArticle');
    Route::get('/articleComment/{id}','ArticleController@articleComment')->name('articleComment');
    Route::get('/delComment/{id}','ArticleController@delComment')->name('delComment');

});
