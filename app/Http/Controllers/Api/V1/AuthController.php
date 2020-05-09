<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\AuthMlOpenidStoreRequest;
use App\Http\Requests\AuthPhoneStoreRequest;
use App\Http\Requests\AuthRequest;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Dingo\Api\Exception\StoreResourceFailedException;

class AuthController extends Controller
{
    
    // 用户登陆 自己登陆$sendInviteSetId 默认是老板,超级管理员权限
    public function store(AuthRequest $request,User $user)
    {
        $parent = $request->parent_id;
        $sendInviteSetId = $request->send_invite_set_id;
        $isOpen = $parent ? true : false;
        $status = $sendInviteSetId == 1 ? User::REFUND_STATUS_MEMBER : User::REFUND_STATUS_ADMINISTRATOR;
        DB::beginTransaction();
        try {
            $user = $user->createUser($request->phone, $request->parent_id, $request->send_invite_set_id, $isOpen, $status, $request->code);
            if ($teamMember = TeamMember::where('user_id', $parent)->firstOrFail()) {
                $this->teamMember($user, $teamMember->team_id);
            }
            DB::commit();
            $token = \Auth::guard('api')->fromUser($user);
            return $this->respondWithToken($token)->setStatusCode(201);
        } catch (\Exception $ex) {
            DB::rollback();
            \Log::warning('AuthController/store', ['message' => $ex]);
            throw new StoreResourceFailedException('登陆失败，请重试!'.$ex);
        }
    }
    // 获取用户的openid
    public function mlOpenidStore(AuthMlOpenidStoreRequest $request)
    {
        $app = app('wechat.mini_program');
        $sessionUser = $app->auth->session($request->code);
        if (!empty($response['errcode'])) {
            throw new \Exception('获取用户的openid操作失败!');
        }
        $user = User::where('ml_openid', $sessionUser['openid'])->first();
        if($user) {
            if (TeamMember::where('user_id', $user->id)->exists()) {
                $token = \Auth::guard('api')->fromUser($user);
                return $this->respondWithToken($token,null);
            }
        }
        return $this->mlOpenid($sessionUser['openid']);
    }
    public function phoneStore(AuthPhoneStoreRequest $request)
    {
        $app = app('wechat.mini_program');
        $response = $app->auth->session($request->code);
return $response;
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

    protected function respondWithToken($token,$mlOpenid)
    {
        return $this->response->array([
            'ml_openid' => $mlOpenid,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 120
        ]);
    }

    protected function mlOpenid($mlOpenid)
    {
        return $this->response->array([
            'ml_openid' => $mlOpenid,
        ]);
    }
}
