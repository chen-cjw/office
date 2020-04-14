<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscussesTable extends Migration
{
    /**
     * Run the migrations.
     * 评论
     * @return void
     */
    public function up()
    {
        Schema::create('discusses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('content')->comment('回复的内容');
            $table->json('images')->comment('回复的图片');
            $table->unsignedBigInteger('task_id')->comment('那个任务下发表的');
            $table->unsignedBigInteger('comment_user_id')->comment('发表评论人');
            $table->unsignedBigInteger('reply_user_id')->comment('回复人');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('reply_user_id')->references('id')->on('users');
            $table->foreign('comment_user_id')->references('id')->on('users');
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
        Schema::dropIfExists('discusses');
    }
}
