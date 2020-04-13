<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     * 团队名
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique()->comment('团队名'); // 团队名不能重复
            $table->unsignedBigInteger('user_id')->unique()->comment('创建人'); // 每个用户只可以有一个团队
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('number_count')->nullable()->comment('支持人数');// 支付的时候使用
            $table->dateTime('close_time')->nullable()->comment('截止时间');// 支付的时候使用
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
        Schema::dropIfExists('teams');
    }
}
