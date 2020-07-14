<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserStoreBossRequest;
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
            $user = $this->user_model->createUser(\request()->phone,$userId,1,true,User::REFUND_STATUS_MEMBER,\request()->code);
            if(TeamMember::where('user_id',$user->id)->exists()) {
                throw new StoreResourceFailedException('已有团队不可重复添加!');
            }
            $this->teamMember($user,$team);// 用户和团队建立关系
            DB::commit();
            $token = \Auth::guard('api')->fromUser($user);
            return $this->respondWithToken($token,$user->openid)->setStatusCode(201);
        } catch (\Exception $ex) {
            DB::rollback();
            throw new \Exception($ex); // 报错原因大多是因为taskFlowCollections表，name和user_id一致
//            \Log::warning('UserController/storeFellow-------邀请同事失败', ['message' => $ex]);
//            throw new StoreResourceFailedException('邀请同事失败!'.$ex);
        }
    }

    // todo 这里的邀请有一个问题，同事邀请了，但是并没有团队，所以没有办法创建团队。没有添加免费适用的权利
    public function storeBoss(UserStoreBossRequest $request,$userId)
    {

        $user = $this->user_model->createUser($request->phone,$userId,2,true,User::REFUND_STATUS_ADMINISTRATOR,$request->code);
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
