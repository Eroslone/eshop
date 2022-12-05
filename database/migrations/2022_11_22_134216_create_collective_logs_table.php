<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectiveLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collective_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('collective_id')->default('0')->comment('团id');
            $table->integer('user_id')->default('0')->comment('用户id');
            $table->integer('store_id')->default('0')->comment('店铺id');
            $table->integer('goods_id')->default('0')->comment('商品id');
            $table->decimal('discount')->default('0.00')->comment('折扣');
            $table->integer('need')->default('5')->comment('需要人数');
            $table->string('status')->default('2')->comment('状态 0取消 1完成 2拼团中');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collective_logs');
    }
}
