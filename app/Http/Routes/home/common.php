<?php
Route::get('/', 'HomeController@index')->name('home');
Route::get('/state','HomeController@state')->name('state');
Route::get('/search','Home\SearchController@index');
Route::get('/cut/live','HomeController@live')->name('cut.live');
Route::group(['namespace' => 'Home', 'prefix' => 'user'], function () {//用户中心路由
    Route::get('/change/success','UserInfoController@changeSuccess')->name('user.change_password.success');//绑定成功
});


//正在直播
Route::group(['namespace' => 'Home', 'prefix' => 'living'], function () {//正在直播
    Route::get('/','LivingController@index')->name('living');//正在直播
});
//直播回看
Route::group(['namespace' => 'Home', 'prefix' => 'back-live'], function () {//直播回看
    Route::get('/','BackLiveController@index')->name('back.live');//直播回看
    Route::get('/back/live/{id}','BackLiveController@backLive')->name('back.live.details');
    Route::post('add_comment','BackLiveController@addBackLiveComment')->name('add.back_live_comment');
    Route::post('reply_comment','BackLiveController@replyBackLiveComment')->name('reply.back_live_comment');
});

//高手观点
Route::group(['namespace' => 'Home','prefix' => 'master-view'], function () {
    Route::get('/','MasterViewController@index')->name('master.view');
    Route::get('/financeInfo','MasterViewController@financeInfo')->name('financeInfo');
});

//观点详情
Route::group(['namespace' => 'Home','prefix' => 'details'], function () {
    Route::get('/{id}','MasterViewController@details')->name('details');
    Route::post('create/comment','MasterViewController@addComment')->name('add.comment');//添加评论
    Route::post('reply/comment','MasterViewController@replyComment')->name('reply.comment');//回复评论
});

//交割单
Route::group(['namespace' => 'Home','prefix' => 'delivery'], function () {
    Route::get('/','DeliveryController@index')->name('delivery');
    Route::get('/list/{user_id}','DeliveryController@deliveryList')->name('delivery.list');
    Route::get('/details/{user_id}/{profits_id}','DeliveryController@details')->name('delivery.details');
    Route::group(['middleware' => ['auth','user.status']], function () {
        Route::post('/add/comment','DeliveryController@addComment')->name('delivery.add.comment');//添加评论
        Route::post('/comment/reply','DeliveryController@replyComment')->name('delivery.comment.reply');//回复评论
    });
});


