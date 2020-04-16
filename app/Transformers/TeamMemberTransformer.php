<?php
namespace App\Transformers;
use App\Models\Team;
use App\Models\TeamMember;
use League\Fractal\TransformerAbstract;

class TeamMemberTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['user'];

    public function transform(TeamMember $teamMember)
    {
        return [
            'id' => $teamMember->id,
            'created_at' => $teamMember->created_at->toDateTimeString(),
            'updated_at' => $teamMember->updated_at->toDateTimeString(),
        ];
    }

    public function includeUser(TeamMember $teamMember)
    {
        return $this->item($teamMember->user,new UserTransformer());
    }

}