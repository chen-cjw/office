<?php
namespace App\Transformers;
use App\Models\TaskFlowCollection;
use League\Fractal\TransformerAbstract;

class TaskFlowCollectionTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['taskFlows'];
    public function transform(TaskFlowCollection $taskFlowCollection)
    {
        return [
            'id' => $taskFlowCollection->id,
            'name' => $taskFlowCollection->name,
            'created_at' => $taskFlowCollection->created_at->toDateTimeString(),
            'updated_at' => $taskFlowCollection->updated_at->toDateTimeString(),
        ];
    }

    public function includeTaskFlows(TaskFlowCollection $taskFlowCollection)
    {
        return $this->collection($taskFlowCollection->taskFlows,new TaskFlowTransformer());
    }

}