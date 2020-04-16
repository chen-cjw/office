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
        return [
            'id' => $team->id,
            'name' => $team->name,
            'number_count' => $team->number_count,
            'close_time' => $team->close_time,
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