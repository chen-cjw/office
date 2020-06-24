<?php
namespace App\Transformers;
use App\Models\TaskFlow;
use League\Fractal\TransformerAbstract;

class TaskFlowTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user'];
    public function transform(TaskFlow $taskFlow)
    {
        return [
            'id' => $taskFlow->id,
            'step_name' => $taskFlow->step_name,
            'status' => $taskFlow->status == 'all' ? 'all' : TaskFlow::$status[$taskFlow->status],
            'created_at' => $taskFlow->created_at->toDateTimeString(),
            'updated_at' => $taskFlow->updated_at->toDateTimeString(),
        ];
    }

    public function includeUser(TaskFlow $taskFlow)
    {
        return $this->item($taskFlow->user,new UserTransformer());
    }
}