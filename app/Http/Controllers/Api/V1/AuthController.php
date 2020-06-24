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
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    // 用户登陆 自己登陆$sendInviteSetId 默认是老板,超级管理员权限
    public function store(AuthRequest $request,User $user)
    {
        $user = User::findOrFail(1);
        $token = \Auth::guard('api')->fromUser($user);
        return $this->respondWithToken($token,$user->ml_openid,$user)->setStatusCode(201);
    }

    // 获取用户的openid
    public function mlOpenidStore(AuthMlOpenidStoreRequest $request)
    {
        $app = app('wechat.mini_program');
        $code = $request->code;
        $sessionUser = $app->auth->session($code);
        if (!empty($sessionUser['errcode'])) {
            throw new \Exception('获取用户的openid操作失败!');
        }
        $openid = $sessionUser['openid'];//$request->openid;//
        $session_key = $sessionUser['session_key'];//$request->openid;//
        $user = User::where('ml_openid', $openid)->first();
        Cache::put($code, ['session_key'=>$session_key,'ml_openid'=>$openid], 300);
        if($user) {
            $user->update(['avatar'=>$request->avatarUrl]);
            if ($user->phone&&TeamMember::where('user_id', $user->id)->exists()) { // 用户手机号存在并且团队存在
                $token = \Auth::guard('api')->fromUser($user);
                return $this->respondWithToken($token,$openid,$user);
            }
            if ($team_id = $request->team_id) {// 已存在，只是不在某个团队，让他重新进团队就可以了
                $this->teamMember($user, $team = Team::findOrFail($team_id));// 用户和团队建立关系
            }
            if  ($parent_id = $request->parent_id) { // 更换邀请人
                $user->update(['parent_id'=>$parent_id]);
            }
            if ($user->phone) {
                $token = \Auth::guard('api')->fromUser($user);
                return $this->respondWithToken($token,$openid,$user);
            }
            return $this->oauthNo();// 第二次去拿手机号码
        }
        User::create($this->createUser($sessionUser,$request));
        return $this->oauthNo();
    }

    public function phoneStore(AuthPhoneStoreRequest $request)
    {
        $session = Cache::get($request->code);// 解析的问题
        if(!$session) {
            throw new \Exception('code 和第一次的不一致');
        }
        $app = app('wechat.mini_program');
        $decryptedData = $app->encryptor->decryptData($session['session_key'], $request->iv, $request->encrypted_data);

        if (empty($decryptedData)) {
            throw new \Exception('操作失败!321');
        }

        $user = User::where('ml_openid',$session['ml_openid'])->firstOrFail();
        $phoneNumber = $decryptedData['phoneNumber'];
        $user->update(['phone'=>$phoneNumber]);

        $token = \Auth::guard('api')->fromUser($user);
        return $this->respondWithToken($token,$phoneNumber,$user)->setStatusCode(201);
    }


    protected function createUser($sessionUser,$request)
    {
        return [ // 不存在此用户添加
            'ml_openid' => $sessionUser['openid'],
            'nickname' => $request->nickName,
            'avatar' => $request->avatarUrl,
            'send_invite_set_id' => $request->send_invite_set_id,
            'status' => $request->send_invite_set_id == 1 ? User::REFUND_STATUS_WAIT : User::REFUND_STATUS_ADMINISTRATOR, // 成员是要审核的
            'is_open' => $request->send_invite_set_id ? true : false,
            'parent_id' => $request->parent_id ? $request->parent_id : null
        ];
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

    protected function respondWithToken($token,$mlOpenid,$user)
    {
        return $this->response->array([
            'ml_openid' => $mlOpenid,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user'=>$user,
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 120
        ]);
    }

    protected function oauthNo()
    {
        return $this->response->array([
            'oauth'=>'未授权手机号码'
        ]);
    }

    // 修改团队名 对于申请的用户进行 允许|拒绝 | 设置管理员|取消管理员|删除团队组员
    public function update(AuthRequest $request,$teamId,$userId)
    {
        // 当前用户的团队，| 自己不可以修改自己
        if ($this->user()->team->id === $teamId || $this->user()->id === $userId) {
            throw new StoreResourceFailedException('团队或者用户有问题!');
        }
        // 传入用户的团队 有则可以修改
        $teamMemerIsset = TeamMember::where(['user_id'=>$userId,'team_id'=>$teamId])->first();
        if(!$teamMemerIsset) {
            throw new StoreResourceFailedException('此用户不在我们团队!');
        }
        if($this->user->status=='administrator'||$this->user->status=='admin') {
            if ($request->status == 'delete' || $request->status == 'refuse') {// 修改状态为删除和拒绝的时候
                TeamMember::where(['user_id'=>$userId,'team_id'=>$teamId])->delete();
                return $this->response->noContent();
            }
            User::where('id',$userId)->update(['status'=>$request->status]);
            return $this->response->created();
        }

        throw new StoreResourceFailedException('没有权限修改!');
    }
}
