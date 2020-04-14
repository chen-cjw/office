<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendInviteSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_invite_sets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('所邀请的人是老板/同事');
            $table->bigInteger('day')->comment('所送天数');
            $table->bigInteger('requirement')->comment('需老板/同事完成任务数量');
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
        Schema::dropIfExists('send_invite_sets');
    }
}
