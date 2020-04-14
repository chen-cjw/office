<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubtasksTable extends Migration
{
    /**
     * Run the migrations.
     * 子任务
     * @return void
     */
    public function up()
    {
        Schema::create('subtasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('content')->comment('任务流程');
            $table->json('images')->nullable()->comment('任务的图片');// 多图怕长度过长
            $table->unsignedBigInteger('task_id')->comment('父任务');
            $table->unsignedBigInteger('user_id')->comment('指派某人');
            $table->foreign('task_id')->references('id')->on('tasks');// 可以知道谁发送给我的
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('close_date')->comment('截止日期');
            $table->string('task_flow')->comment('任务流程');
            $table->enum('status',['pending','complete','overdue','stop'])->comment('进行中(pending)|完成(complete)|逾期(overdue)|停止(stop)');
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
        Schema::dropIfExists('subtasks');
    }
}
