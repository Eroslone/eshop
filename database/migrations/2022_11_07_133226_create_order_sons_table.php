<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_sons', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->default('0')->comment('订单id');
            $table->integer('product_id')->default('0')->comment('产品id');
            $table->integer('size_id')->default('0')->comment('型号id');
            $table->integer('type_id')->default('0')->comment('类型id');
            $table->decimal('price', 16, 2)->default(0.00)->comment('价格');
            $table->integer('quantity')->default('0')->comment('数量');
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
        Schema::dropIfExists('order_sons');
    }
};
