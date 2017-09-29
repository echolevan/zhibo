<?php
Route::group(['prefix' => 'config'], function () {//系统设置
    Route::get('/site_info','ConfigController@siteInfo')->name('config.site_info');//站点信息
    Route::put('/update/site_info','ConfigController@updateSiteInfo')->name('config.update.site_info');//更新站点信息
    Route::get('/clear_cache','ConfigController@clearCache')->name('clear_cache');//清除缓存
    Route::get('/focus','ConfigController@focus')->name('config.focus');//焦点图
    Route::get('/edit_focus/{id}','ConfigController@editFocus')->name('config.edit.focus');//编辑焦点图
    Route::put('/update_focus/{id}','ConfigController@updateFocus')->name('config.update.focus');//更新焦点图
});