<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default('0')->comment('用户id');
            $table->string('no')->comment("订单编号");
            $table->integer('address_id')->default('0')->comment('地址id');
            $table->string('remark')->comment("备注");
            $table->decimal('price', 16, 2)->default(0.00)->comment('价格');
            $table->integer('state')->default('0')->comment('订单状态');
            $table->dateTime('paid_at')->comment('支付时间');
            $table->string('payment_method')->comment("支付方式");
            $table->integer('pay_status')->default('0')->comment('支付状态');
            $table->dateTime('over_time')->comment('订单过期时间');
            $table->string('express_company')->comment("物流公司");
            $table->string('express_no')->comment("物流单号");
            $table->integer('refund')->default('0')->comment('退款状态');
            $table->string('refund_reason')->comment("退款理由");
            $table->string('refund_no')->comment("退货单号");
            $table->string('refuse_reason')->comment("拒绝理由");
            $table->string('freight_state')->comment("货物状态");
            $table->string('return_way')->comment("返回方式");
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
        Schema::dropIfExists('orders');
    }
};
