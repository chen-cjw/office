<?php
namespace App\Transformers;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['team'];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'openid' => $user->openid,
            'nickname' => $user->nickname,
            'sex' => $user->sex,
            //'team_id' => $user->team_id?:$user->team,
            'avatar' => $user->avatar,
            'openid' => auth('api')->user() ? auth('api')->user()->openid : null,
            'status'=>User::$status[$user->status],
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString(),
        ];
    }

    public function includeTeam(User $user)
    {
        return $this->item($user->team,new TeamTransformer());
    }

}