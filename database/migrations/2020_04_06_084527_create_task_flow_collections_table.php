<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskFlowCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     * 步骤名称的合集
     * @return void
     */
    public function up()
    {
        Schema::create('task_flow_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('总体名称');
            $table->unsignedBigInteger('user_id')->comment('流程添加人');
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
        Schema::dropIfExists('task_flow_collections');
    }
}
