<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamMembersTable extends Migration
{
    /**
     * Run the migrations.
     * 用户与团队关联关系
     * @return void
     */
    public function up()
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->unique()->comment('指派某人');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('team_id')->comment('团队id');
            $table->foreign('team_id')->references('id')->on('teams');
//            $table->unique('user_id','team_id');
            // 这里应该还有一个操作日志才对
//            $table->enum('status',['administrator','admin','member','freeze','wait'])
//                ->comment('超级管理员(administrator)|管理员(admin)|成员(member)|冻结账号(freeze)|等待审核(wait)');

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
        Schema::dropIfExists('team_members');
    }
}
