<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\UserRequest;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->user_model = new User();
    }
    // 邀请同事
    public function storeFellow($teamId,$userId)
    {
        // todo 判断用户和团队是否存在,等下封装
        $team = Team::findOrFail($teamId);
        User::findOrFail($userId);
        if(TeamMember::where('user_id',$userId)->exists()) {
            throw new StoreResourceFailedException('已有团队不可重复添加!');
        }

        DB::beginTransaction();
        try {
            $this->user_model->createUser($userId,1,true,$teamId,User::REFUND_STATUS_WAIT);
            $this->teamMember($this->user(),$team);
            DB::commit();
            return $this->response->created();
        } catch (\Exception $ex) {
            DB::rollback();
            \Log::warning('UserController/storeFellow-------邀请同事失败', ['message' => $ex]);
            throw new StoreResourceFailedException('邀请同事失败!');
        }
    }

    // 邀请老板
    public function storeBoss($userId)
    {
        // todo 判断用户是否存在,等下封装
        User::findOrFail($userId);
        $this->user_model->createUser($userId,2,true,null,User::REFUND_STATUS_ADMINISTRATOR);
        return $this->response->created();
    }
}
