<?php
namespace App\Transformers;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['team'];

    public function transform(User $user)
    {
        // 'wx_openid','ml_openid','phone','unionid','avatar','nickname','sex','team_id','parent_id','is_open','send_invite_set_id','status',
        return [
            'id' => $user->id,
            'wx_openid' => $user->wx_openid,
            'ml_openid' => $user->ml_openid,
            'phone' => $user->phone,
            'nickname' => $user->nickname,
            'sex' => $user->sex,
            'avatar' => $user->avatar,
            'parent_id' => $user->parent_id,
            'openid' => auth('api')->user() ? auth('api')->user()->openid : null,
            'status'=> User::$status[$user->status],
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString(),
        ];
    }

    public function includeTeam(User $user)
    {
        return $this->item($user->team,new TeamTransformer());
    }

    public function includeSendInviteSet(User $user)
    {
        return $this->item($user->sendInviteSet,new SendIn);
    }

    public function includeTasks()
    {
        
    }

}