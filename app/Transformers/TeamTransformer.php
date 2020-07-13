<?php
namespace App\Transformers;
use App\Models\Team;
use App\Models\TeamMember;
use League\Fractal\TransformerAbstract;

class TeamTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['user','members'];

    public function transform(Team $team)
    {
        $closeTime = strtotime(auth('api')->user()->teams[0]->close_time);
        $createTime = strtotime(auth('api')->user()->teams[0]->created_at);
        $teamCloseTime = date('Y-m-d',$closeTime);// 2020-10-10
        $bccomp = bccomp(strtotime($teamCloseTime),strtotime(date('Y-m-d',$createTime).' + 30 day'));
        return [
            'id' => $team->id,
            'name' => $team->name,
            'number_count' => $bccomp == 0? '无限' : $team->number_count,
            'close_time' => $team->close_time,
            'is_team_version' => $bccomp == 0 ? false : true,
            'created_at' => $team->created_at->toDateTimeString(),
            'updated_at' => $team->updated_at->toDateTimeString(),
        ];
    }

    public function includeUser(Team $team)
    {
        return $this->item($team->user,new UserTransformer());
    }

    public function includeMembers(Team $team)
    {
        return $this->collection($team->members,new TeamMemberTransformer());
    }



}