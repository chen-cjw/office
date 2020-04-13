<?php
namespace App\Transformers;
use App\Models\Task;
use League\Fractal\TransformerAbstract;

class TaskTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user'];
    public function transform(Task $task)
    {
        return [
            'id' => $task->id,
            'content' => $task->content,
            'images' => $task->images,
            'close_date' => $task->close_date,
            'task_flow' => $task->task_flow,
            'status' => $task->status,
            'created_at' => $task->created_at->toDateTimeString(),
            'updated_at' => $task->updated_at->toDateTimeString(),
        ];
    }

    public function includeUser(Task $task)
    {
        return $this->item($task->user,new UserTransformer());
    }
}