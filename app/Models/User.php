<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{

    const REFUND_STATUS_ADMINISTRATOR = 'administrator';
    const REFUND_STATUS_ADMIN = 'admin';
    const REFUND_STATUS_MEMBER = 'member';
    const REFUND_STATUS_FREEZE = 'freeze';
    const REFUND_STATUS_WAIT = 'wait';
    const REFUND_STATUS_DEL = 'del';
    // comment('超级管理员(administrator)|管理员(admin)|成员(member)|冻结账号(freeze)|等待审核(wait)');
    public static $status = [
        self::REFUND_STATUS_ADMINISTRATOR    => '超级管理员',
        self::REFUND_STATUS_ADMIN    => '管理员',
        self::REFUND_STATUS_MEMBER    => '成员',
        self::REFUND_STATUS_FREEZE    => '冻结账号',
        self::REFUND_STATUS_WAIT    => '等待审核',
        self::REFUND_STATUS_DEL    => '未加团队',

    ];

    use Notifiable;
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'openid', 'avatar','nickname','sex','team_id','parent_id','is_open','send_invite_set_id','status',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_open' => 'boolean',
    ];
    // 每个人只能有一个团队
    public function team()
    {
        return $this->hasOne(Team::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function subTasks()
    {
        return $this->hasMany(Subtask::class);
    }

    public function taskFlowCollections()
    {
        return $this->hasMany(TaskFlowCollection::class);
    }
    public function sendInviteSet()
    {
        return $this->hasOne(SendInviteSet::class);
    }
    // 创建一个用户
    public function createUser($parent,$sendInviteSetId,$isOpen,$status)
    {
//        return User::find(2);
         return User::create([
            'openid' => mt_rand(10000000000,9999999990000),
            'parent_id'=>$parent,
            'is_open' => $isOpen,
            'send_invite_set_id' => $sendInviteSetId,
            'status'=>$status
        ]);

        // 等下封装起来
        $code = $request->code;
        // 小程序
        try {
            $app = app('wechat.mini_program');
            $sessionUser = $app->auth->session($code);
            $openid = $sessionUser['openid'];
            $user = User::where('openid', $openid)->first();
            if (!$user) {
                // 分享的时候带了一个邀请码，不要用左右二叉树了，做一个简单的邀请进团队
                return User::create([
                    'openid' => mt_rand(10000000000,9999999990000),
                    'parent_id'=>$parent,
                    'is_open' => $isOpen,
                    'send_invite_set_id' => $sendInviteSetId,
                    'status'=>$status
                ]);
            }
            return $user;
        } catch (\Exception $e) {
            throw new \Exception('授权失败,请重新授权!');
        }
    }
}
