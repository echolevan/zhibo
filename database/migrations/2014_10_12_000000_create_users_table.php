<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone');
            $table->string('password');
            $table->string('thumb')->comment('头像');
            $table->integer('gold')->comment('金币');
            $table->tinyInteger('type')->default('1')->comment('1 会员 2 讲师');
            $table->tinyInteger('status')->default('1')->comment('1 正常 2 禁言 3冻结');
            $table->tinyInteger('sex')->comment('1 男 2 女');
            $table->dateTime('created_at')->comment('注册日期');
            $table->dateTime('login_time')->comment('上次登陆日期');
            $table->string('ip');
            $table->integer('login_number')->comment('登陆次数');
            $table->tinyInteger('Level')->default('1')->comment('会员等级');
            $table->integer('online_time')->comment('累计在线时长');
            $table->text('sign')->comment('会员签名');
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
