<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\UserRequest;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        // 先授权登陆然后到这里来
        DB::beginTransaction();
        try {
            $user = $this->user_model->createUser($userId,1,true,User::REFUND_STATUS_WAIT);
            if(TeamMember::where('user_id',$user->id)->exists()) {
                throw new StoreResourceFailedException('已有团队不可重复添加!');
            }
            $this->teamMember($user,$team);// 用户和团队建立关系
            DB::commit();
            $token = \Auth::guard('api')->fromUser($user);
            return $this->respondWithToken($token,$user->openid)->setStatusCode(201);
        } catch (\Exception $ex) {
            DB::rollback();
            \Log::warning('UserController/storeFellow-------邀请同事失败', ['message' => $ex]);
            throw new StoreResourceFailedException('邀请同事失败!'.$ex);
        }
    }

    // todo 这个可能不需要了邀请老板
    public function storeBoss($userId)
    {
        // todo 判断用户是否存在,等下封装
        User::findOrFail($userId);
        $user = $this->user_model->createUser($userId,2,true,User::REFUND_STATUS_ADMINISTRATOR);
        $token = \Auth::guard('api')->fromUser($user);
        return $this->respondWithToken($token,$user->openid)->setStatusCode(201);
    }

    protected function respondWithToken($token,$openid)
    {
        return $this->response->array([
            'access_token' => $token,
            'openid' => $openid,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 120
        ]);
    }
}
