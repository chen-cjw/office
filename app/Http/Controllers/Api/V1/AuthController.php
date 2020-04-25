<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 用户登陆 自己登陆$sendInviteSetId 默认是老板,超级管理员权限
    public function store(AuthRequest $request,User $user)
    {
        $user = $user->createUser($request->phone,0,1,false,User::REFUND_STATUS_ADMINISTRATOR,$request->code);
        $token = \Auth::guard('api')->fromUser($user);
        return $this->respondWithToken($token)->setStatusCode(201);
    }

    // 个人中心
    public function meShow()
    {
        return $this->response->item($this->user(),new UserTransformer());
    }
    public function destroy()
    {
        Auth::guard('api')->logout();
        return $this->response->noContent();
    }
    protected function respondWithToken($token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 120
        ]);
    }
}
