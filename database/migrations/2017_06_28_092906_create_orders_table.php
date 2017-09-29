<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('user_id');
            $table->tinyInteger('type')->comment('支付类型 1 支付宝 2微信');
            $table->tinyInteger('status')->comment('支付状态 1待支付 2 支付成功 3取消订单');
            $table->integer('amount')->comment('金额');
            $table->dateTime('created_time');
            $table->dateTime('updated_time')->nullable();
            $table->dateTime('delete_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
