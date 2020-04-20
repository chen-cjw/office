<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;

class TaskLogTransformer extends TransformerAbstract
{
    public function transform(\App\Models\TaskLog $task)
    {
        return [
            'id' => $task->id,
            'content' => $task->content,
            'task_id' => $task->task_id,
            'user_id' => $task->user_id,
            'created_at' => $task->created_at->toDateTimeString(),
            'updated_at' => $task->updated_at->toDateTimeString(),
        ];
    }

}