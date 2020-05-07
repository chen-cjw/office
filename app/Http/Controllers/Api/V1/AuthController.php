<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\AuthMlOpenidStoreRequest;
use App\Http\Requests\AuthPhoneStoreRequest;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\MlOpenidAuthRequest;
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
    // 获取用户的openid
    public function mlOpenidStore(AuthMlOpenidStoreRequest $request)
    {
        $app = app('wechat.mini_program');
        $sessionUser = $app->auth->session($request->code);
        return ['ml_openid'=>$sessionUser['openid']];
    }
    public function phoneStore(AuthPhoneStoreRequest $request)
    {
        $app = app('wechat.mini_program');
        $response = $app->auth->session($request->code);

        if (!empty($response['errcode'])) {
            throw new \Exception('操作失败!123');
        }
        $sessionKey = $response['session_key'];
        $decryptedData = $app->encryptor->decryptData($sessionKey, $request->iv, $request->encrypted_data);

        if (empty($decryptedData)) {
            throw new \Exception('操作失败!321');
        }
        return $decryptedData;
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
