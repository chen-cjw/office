<?php
namespace App\Transformers;
use App\Models\Subtask;
use League\Fractal\TransformerAbstract;

class SubTaskTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user'];
    public function transform(Subtask $subtask)
    {
        return [
            'id' => $subtask->id,
            'content' => $subtask->content,
            'images' => $subtask->images,
            'close_date' => $subtask->close_date,
            'task_flow' => $subtask->task_flow,
            'status' => Subtask::$status[$subtask->status],
            'created_at' => $subtask->created_at->toDateTimeString(),
            'updated_at' => $subtask->updated_at->toDateTimeString(),
        ];
    }
    public function includeUser(Subtask $subtask)
    {
        return $this->item($subtask->user,new UserTransformer());
    }


}