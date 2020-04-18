<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content')->comment('操作内容');
            $table->unsignedBigInteger('task_id')->nullable()->comment('任务');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->unsignedBigInteger('user_id')->nullable()->comment('操作人');
            $table->foreign('user_id')->references('id')->on('users');
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
