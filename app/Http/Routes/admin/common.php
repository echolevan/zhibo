<?php

Route::get('/','IndexController@index')->name('admin');//后台首页

Route::get('/order_list','PayInfoController@index')->name('pay.info');

Route::get('/delivery','DeliveryController@index')->name('admin.delivery');//交割单首页
Route::get('/delivery/list/{userid}','DeliveryController@dataList')->name('admin.delivery.list');//用户交割单列表
Route::get('/delivery/details/{userid}/{profit_id}','DeliveryController@details')->name('admin.delivery.details');//用户交割单详情
Route::delete('/delivery/delete','DeliveryController@delete')->name('admin.delivery.delete');//删除交割单