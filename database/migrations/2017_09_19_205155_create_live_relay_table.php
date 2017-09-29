<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiveRelayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_relay', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('from_room')->comment('转播房间id');;
            $table->unsignedInteger('to_room')->comment('转到房间id');
            $table->dateTime('expired_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('live_relay');
    }
}
