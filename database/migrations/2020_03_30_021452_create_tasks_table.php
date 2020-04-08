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
            $table->text('content')->comment('任务流程');
            $table->text('images')->nullable()->comment('上传的图片');// 多图怕长度过长
            $table->unsignedBigInteger('user_id')->comment('指派某人');
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('close_date')->comment('截止日期');
            $table->string('task_flow')->comment('任务流程');
            $table->enum('status',['start','end','stop'])->comment('任务是可以暂停的');
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
