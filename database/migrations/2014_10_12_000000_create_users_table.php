<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('openid')->unique();
            $table->string('avatar')->nullable();
            $table->string('nickname')->nullable();
            $table->boolean('sex')->nullable();
            $table->string('language')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->unsignedBigInteger('team_id')->nullable()->comment('所属团队'); // 每个用户只可以有一个团队
            $table->bigInteger('parent_id')->nullable()->comment('邀请人');
            $table->bigInteger('day')->default(0)->comment('送的天数');
            $table->bigInteger('is_open')->default(0)->comment('是否开启送的天数');
            // 这里应该还有一个操作日志才对
            $table->enum('status',['administrator','admin','member','freeze','wait'])
                ->default(\App\Models\User::REFUND_STATUS_WAIT)->comment('超级管理员(administrator)|管理员(admin)|成员(member)|冻结账号(freeze)|等待审核(wait)');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
