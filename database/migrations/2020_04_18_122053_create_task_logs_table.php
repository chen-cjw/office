<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskLogsTable extends Migration
{
    /**
     * Run the migrations.
     * 这个数据库多态最合适，因为他有任务表和子任务表。不好区分
     * @return void
     */
    public function up()
    {
        Schema::create('task_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content')->comment('操作内容');
            $table->unsignedBigInteger('user_id')->nullable()->comment('操作人');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('model_id')->comment('那个模型下面id');
            $table->string('model_type')->comment('那个模型下面的');
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
        Schema::dropIfExists('task_logs');
    }
}
