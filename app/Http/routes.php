<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| 后台路由
|--------------------------------------------------------------------------
*/

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {

    Route::auth();//用户登陆

    Route::group(['middleware' => ['auth:admin','permission']], function () {

        require 'Routes/admin/common.php';//后台公用

        require 'Routes/admin/lecturer.php';//讲师管理

        require 'Routes/admin/rbac.php';//权限管理

        require 'Routes/admin/gift.php';//礼物管理

        require 'Routes/admin/withdrawals.php';//提现

        require 'Routes/admin/room.php';//房间管理

        require 'Routes/admin/config.php';//系统设置

        require 'Routes/admin/system.php';//配置管理

        require 'Routes/admin/promotion.php';//推广管理

        require 'Routes/admin/user.php';//用户管理

        require 'Routes/admin/article.php'; //文章管理
    });
});

//-------------------------------------------------------------------------
/*
|--------------------------------------------------------------------------
| 图片上传处理 上传七牛云
|--------------------------------------------------------------------------
*/
require 'Routes/upload.php';
//-------------------------------------------------------------------------

require 'Routes/oauth.php';//第三方登陆
/*
|--------------------------------------------------------------------------
| 前台路由
|--------------------------------------------------------------------------
*/
require 'Routes/home/auth.php';//用户登陆
require 'Routes/home/common.php';//前台公用部分  首页 直播室
require 'Routes/home/live.php';//直播室
require 'Routes/home/pay.php';//支付 交易记录
require 'Routes/home/api.php';// API通知；送礼物以及提问等广播服务
require 'Routes/home/customer.php';//访问主播个人中心
Route::group(['middleware' => ['auth','user.status']], function () {
    require 'Routes/home/user.php';//用户中心

    require 'Routes/home/message.php';//我的消息

    require 'Routes/home/follow.php';//我的关注

    Route::group(['middleware' => 'check.lecturer'], function () {
        require 'Routes/home/view.php';//我的观点

        require 'Routes/home/promotion.php';//推广中心

        require 'Routes/home/lecturer.php';//讲师中心

        require 'Routes/home/relay.php';//转播

        require 'Routes/home/play.php';//直播

        require 'Routes/home/live_message.php';//直播通知

        Route::group(['namespace' => 'Home', 'prefix' => 'lecturer'], function () {
            Route::get('/add/stock','DeliveryController@addStock')->name('add.stock');
            Route::post('/excel/import','DeliveryController@import')->name('excel.import');
        });
    });
});
//-------------------------------------------------------------------------

/*
|--------------------------------------------------------------------------
| 手机版
|--------------------------------------------------------------------------
*/
Route::group(['namespace' => 'Home', 'prefix' => 'mobile/live'], function () {//直播室
    Route::get('/{user_id}/{streams}', 'LiveController@index')->name('mobile.live');
});
Route::group(['namespace' => 'Home', 'prefix' => 'mobile'], function () {//搜索
    Route::get('/search', 'SearchController@index')->name('mobile.search');
});
Route::group(['namespace' => 'Mobile', 'prefix' => 'mobile'], function () {
    require 'Routes/mobile/auth.php';//注册登录
    require 'Routes/mobile/common.php';//公共
    require 'Routes/mobile/article.php';//动态
    require 'Routes/mobile/back_live.php';//回看
    Route::group(['middleware' => ['auth','user.status']], function () {
        require 'Routes/mobile/user.php';//用户中心
        Route::get('/follow','FollowController@index')->name('mobile.follow');
        Route::get('/pay','PayController@index')->name('mobile.pay');
        Route::get('/system','CustomerController@configSet')->name('mobile.system');
        Route::get('/article/reply/{article_id}/{comment_id}','ArticleController@reply')->name('mobile.reply');//回复评论
        Route::get('/live_history/reply/{back_live_id}/{comment_id}','ArticleController@replyLive')->name('mobile.live.reply');//回复评论
    });
});