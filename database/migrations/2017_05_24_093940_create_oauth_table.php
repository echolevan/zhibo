<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauths', function (Blueprint $table) {
            $table->increments('id');
            $table->string('access_token');
            $table->string('nickname');
            $table->string('avatar_url');
            $table->string('email');
            $table->tinyInteger('type')->comment('1qq 2微信');
            $table->dateTime('created_time')->comment('注册时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('oauths');
    }
}
