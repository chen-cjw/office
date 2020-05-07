<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWechatPaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_pays', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('number')->comment('人数');
            $table->unsignedInteger('day')->comment('天数');
            $table->string('body')->comment('描述==通知标题');
            $table->string('detail')->nullable()->comment('详细描述');
            $table->string('out_trade_no')->comment('商户订单号');
            $table->unsignedBigInteger('user_id')->comment('用户ID');
            $table->foreign('user_id')->references('id')->on('users');
            //$table->string('ml_openid')->comment('小程序唯一标识');
            $table->decimal('total_fee',10)->comment('支付金额/分');
            $table->enum('status',['unpaid','paid','close','delete','paid_fail'])->default('unpaid')->comment('支付状态[unpaid未支付,paid已支付,close关闭,delete删除,paid_fail支付失败]');
            $table->dateTime('paid_at')->comment('支付时间');

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
        Schema::dropIfExists('wechat_pays');
    }
}
