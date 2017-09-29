<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lecturer_id')->unsigned();
            $table->string('streams_name')->unique('streams_name')->comment('视频流名称');
            $table->tinyInteger('status')->default('1')->comment('房间状态 1未分配  2已分配 3关闭');
            $table->string('room_name')->comment('直播室名称');
            $table->string('desc')->comment('简介');
            $table->text('notice')->comment('公告');
            $table->string('thumb')->comment('图片');
            $table->string('number')->comment('直播室人数');
            $table->tinyInteger('barrage')->comment('弹幕开关 1开 2关');
            $table->tinyInteger('speak')->comment('发言开关 1开 2关');
            $table->tinyInteger('luck')->comment('抽奖开关 1开 2关');
            $table->dateTime('created_time')->comment('添加时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rooms');
    }
}
