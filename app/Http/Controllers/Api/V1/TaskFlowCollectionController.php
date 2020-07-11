<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\TaskFlowCollection;
use App\Models\TeamMember;
use App\Transformers\TaskFlowCollectionTransformer;
use Illuminate\Http\Request;

class TaskFlowCollectionController extends Controller
{
    // todo 共享任务流程
    public function index()
    {
        // 成员-团队-成员
        $teamMembers = TeamMember::where('user_id',auth('api')->user()->id)->first();
        if($teamMembers) {
            $teamMemberUsers = TeamMember::where('team_id',$teamMembers->team_id)->pluck('user_id');
            $taskFlowCollections = TaskFlowCollection::whereIn('user_id',$teamMemberUsers)->paginate();
            return $this->response->paginator($taskFlowCollections,new TaskFlowCollectionTransformer());
        }

    }

    public function show($id)
    {
        return $this->response->item($this->user->taskFlowCollections()->where('id',$id)->firstOrFail(),new TaskFlowCollectionTransformer());
    }
}
