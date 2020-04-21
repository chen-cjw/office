<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 用户登陆 自己登陆$sendInviteSetId 默认是老板,超级管理员权限
    public function store(Request $request,User $user)
    {

        // 推送消息
//        $app = app('wechat.official_account');
//        $app->template_message->send([
//            'touser' => 'osQAa4x84mf-ly54cjdxMDNfNRRc',
//            'template_id' => 'OPENTM414446600',
//            //'url' => 'https://easywechat.org',
//            'data' => [
//                'key1' => '1',
//                'key2' => '2',
//                'key3' => '3',
//                'key4' => '4',
//                'key5' => '5',
//                'key6' => '6',
//                'key7' => '7',
//            ],
//        ]);
//
//        return 1111;

        $user = $user->createUser(null,1,false,User::REFUND_STATUS_ADMINISTRATOR);
        $token = \Auth::guard('api')->fromUser($user);
        return $this->respondWithToken($token,$user->openid)->setStatusCode(201);
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
