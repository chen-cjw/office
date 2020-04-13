<?php
namespace App\Transformers;
use App\Models\Team;
use League\Fractal\TransformerAbstract;

class TeamTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['users'];

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

    public function includeUsers(Team $team)
    {
        return $this->collection($team->users,new UserTransformer());
    }
}