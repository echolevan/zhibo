<?php
Route::group(['prefix' => 'promotion'],function(){//推广管理
    Route::get('/','PromotionController@index')->name('admin.promotion');
    Route::get('/config','PromotionController@promotionConfig')->name('promotion.config');//推广奖励规则
    Route::put('/update/config','PromotionController@updatePromotionConfig')->name('update.promotion.config');//更新推广规则
});