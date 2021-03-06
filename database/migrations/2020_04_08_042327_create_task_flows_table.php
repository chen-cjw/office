<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskFlowsTable extends Migration
{
    /**
     * Run the migrations.
     * 新增任务流程
     * @return void
     */
    public function up()
    {
        Schema::create('task_flows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('step_name')->comment('流程步骤名称');
            $table->unsignedBigInteger('user_id')->comment('步骤负责人');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('task_flow_collection_id')->comment('步骤负责人');
            $table->foreign('task_flow_collection_id')->references('id')->on('task_flow_collections');
            $table->enum('status',['all','start','pending','end','expired'])->comment('全部显示(all)|开始(start)|进行中(pending)|完成(end)|逾期(expired)');

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
        Schema::dropIfExists('task_flows');
    }
}
