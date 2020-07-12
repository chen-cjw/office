<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
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
        'wx_openid','ml_openid','phone','unionid','avatar','nickname','sex','team_id','parent_id','is_open','send_invite_set_id','status',
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
//    public function team()
//    {
//        return $this->hasOne(Team::class);
//    }
    public function teams()
    {
        return $this->belongsToMany(Team::class,'team_members','team_id','user_id');
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function taskFlows()
    {
        return $this->hasMany(TaskFlow::class);
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
        return $this->belongsTo(SendInviteSet::class);
    }

    public function wechatPays()
    {
        return $this->hasMany(WechatPay::class);
    }
    // todo 测试用
    public function createUser($phone,$parent,$sendInviteSetId,$isOpen,$status,$code)
    {
        return User::findOrFail(1);
    }

}
