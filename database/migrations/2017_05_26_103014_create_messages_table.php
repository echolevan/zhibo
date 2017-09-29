<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('提问者');
            $table->integer('to_user_id')->comment('被提问者');
            $table->string('title')->comment('标题');
            $table->text('reply')->comment('回复');
            $table->tinyInteger('status')->comment('问题状态 1待查看 2已解决');
            $table->tinyInteger('type')->comment('消息类型 1付费提问 2系统消息');
            $table->dateTime('created_time')->comment('添加时间');
            $table->dateTime('end_time')->comment('结束时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('messages');
    }
}
