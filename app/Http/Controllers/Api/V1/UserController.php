<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->user_model = new User();
    }
    // 邀请同事
    public function storeFellow(UserRequest $request,$userId,$teamId)
    {
        // todo 邀请一个成员，审核通过 teams 表中的人数就会增加,
        // todo 目前没有控制一个用户只能参加一个团队
        $this->user_model->createUser($userId,20,true,$teamId,User::REFUND_STATUS_WAIT);
        return $this->response->created();
    }

    // 邀请老板
    public function storeBoss(UserRequest $request,$userId)
    {
        $this->user_model->createUser($userId,30,true,null,User::REFUND_STATUS_ADMINISTRATOR);
        return $this->response->created();
    }
}
