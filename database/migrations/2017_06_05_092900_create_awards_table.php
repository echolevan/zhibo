<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_id')->unsigned()->comment('提供者');
            $table->integer('user_id');
            $table->tinyInteger('type')->comment('1 注册 2消费');
            $table->string('price')->comment('奖励金额');
            $table->foreign('from_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->comment('接收者');
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
        Schema::drop('awards');
    }
}
