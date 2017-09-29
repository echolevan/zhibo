<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLecturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecturers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('username');
            $table->tinyInteger('grade')->comment('等级');
            $table->integer('income')->comment('收入');
            $table->tinyInteger('type')->comment('直播类型');
            $table->string('auth_id_number')->comment('验证身份证 不为空验证通过');
            $table->dateTime('created_time')->comment('申请时间');
            $table->dateTime('open_time')->comment('申请通过时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lecturers');
    }
}
