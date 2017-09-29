<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->comment('文章id');
            $table->integer('user_id')->unsigned()->comment('评论者');
            $table->integer('parent_id')->comment('回复评论者');
            $table->tinyInteger('status')->comment('评论状态1 可见 2不可见');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->comment('评论者');
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
        Schema::drop('comments');
    }
}
