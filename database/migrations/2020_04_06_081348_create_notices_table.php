<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     * 我的通知| 同事邀请某人，拒绝某人的申请
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('content')->comment('通知的内容');
            $table->boolean('is_read')->comment('是否已读');
            $table->unsignedBigInteger('send_user_id')->comment('发送人');
            $table->unsignedBigInteger('to_user_id')->comment('接收人');
            $table->foreign('send_user_id')->references('id')->on('users');
            $table->foreign('to_user_id')->references('id')->on('users');

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
        Schema::dropIfExists('notices');
    }
}
