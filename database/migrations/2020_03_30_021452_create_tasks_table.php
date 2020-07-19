<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('content')->comment('任务的内容');
            $table->json('images')->nullable()->comment('任务的图片');// 多图怕长度过长
            $table->unsignedBigInteger('user_id')->comment('发布人');
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('close_date')->comment('截止日期');
            $table->string('task_flow')->comment('任务流程');
            $table->string('assignment_user_id')->comment('指派给某个人');
            $table->enum('status',['start','pending','end','stop','complete'])->comment('start(开始)|end(结束)|stop(停止)|pending(进行中)|complete(完成)');
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
        Schema::dropIfExists('tasks');
    }
}
