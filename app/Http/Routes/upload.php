<?php
// 上传
Route::group(['prefix' => 'image'], function () {
    Route::post('upload_icon', 'ImageController@upload_icon')->name('image.upload_icon');//上传网站图标

    Route::post('upload_logo', 'ImageController@upload_logo')->name('image.upload_logo');//上传网站logo

    Route::post('upload', 'ImageController@upload')->name('image.upload');//上传用户头像到七牛//后台

    Route::delete('delete','ImageController@delete')->name('image.delete');//删除云端图片

    Route::post('/upthumb','ImageController@gift')->name('upthumb');//上传礼物图片

    Route::post('/upload_focus','ImageController@uploadFocus')->name('upload.focus');//上传焦点图

});
