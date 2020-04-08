<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 用户登陆
    public function store(Request $request)
    {
        $code = $request->code;
        // 小程序
        try {
            $app = app('wechat.mini_program');
            $sessionUser = $app->auth->session($code);
            $openid = $sessionUser['openid'];
            $user = User::where('openid', $openid)->first();
            if (!$user) {
                // 分享的时候带了一个邀请码，不要用左右二叉树了，做一个简单的邀请进团队
                $user = User::create([
                    'openid' => $openid,
                ]);

            }
            $token = \Auth::guard('api')->fromUser($user);
        } catch (\Exception $e) {
            throw new \Exception('授权失败,请重新授权!');
        }
        return $this->respondWithToken($token,$openid)->setStatusCode(201);
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
