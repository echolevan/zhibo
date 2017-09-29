<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 10:40
 */
Route::group(['prefix' => 'withdrawals'], function () {//提现管理
    Route::get('/examine_index', 'WithdrawalsController@examine')->name('examine_index');//待审核列表
    Route::get('/wait_pay', 'WithdrawalsController@wait_pay')->name('wait_pay');//提现待打款列表
    Route::get('/success_pay', 'WithdrawalsController@success_pay')->name('success_pay');//提现成功列表
    Route::get('/fail_examine', 'WithdrawalsController@fail_examine')->name('fail_examine');//审核失败列表
    Route::get('/return_examine/{id}', 'WithdrawalsController@return_examine')->name('return_examine');//审核失败转到正在审核列表

    Route::get('/edit_examine/{id}', 'WithdrawalsController@edit_examine')->name('edit_examine');//审核成功提交
    Route::post('/fail_examine_store', 'WithdrawalsController@fail_examine_store')->name('fail_examine_store');//审核失败提交
    Route::post('/edit_wait_pay/{id}', 'WithdrawalsController@edit_wait_pay')->name('edit_wait_pay');//提现提交

    Route::get('/examine_role','WithdrawalsController@examine_role')->name('examine_role');//讲师提现规则设置页面
    Route::get('/user_examine_role','WithdrawalsController@user_examine_role')->name('user_examine_role');//用户提现规则设置页面
    Route::post('/examine_role_store','WithdrawalsController@examine_role_store')->name('examine_role_store');//提现规则设置提交
});