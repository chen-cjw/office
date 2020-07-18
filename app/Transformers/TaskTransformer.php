<?php
namespace App\Transformers;
use App\Models\Task;
use App\Models\TaskLog;
use League\Fractal\TransformerAbstract;

class TaskTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user','subtasks','discusses','taskLogs','assignmentUser'];
    public function transform(Task $task)
    {
        return [
            'id' => $task->id,
            'content' => $task->content,
            'images' => $task->images,
            'close_date' => $task->close_date,
            'task_flow' => $task->task_flow,
            'status' => strtotime($task->close_date) < strtotime(date('Y-m-d')) ? '逾期' : Task::$status[$task->status],//Task::$status[$task->status],
            'task_id' => $task->task_id,
            'is_subTask' => $task->task_id==null?false:true,
//            'task_logs' => TaskLog::where('model_id',$task->id)->get(),
            'created_at' => $task->created_at->toDateTimeString(),
            'updated_at' => $task->updated_at->toDateTimeString(),
        ];
    }

    public function includeAssignmentUser(Task $task)
    {
        return $this->item($task->assignmentUser,new UserTransformer());
    }
    public function includeUser(Task $task)
    {
        return $this->item($task->user,new UserTransformer());
    }

    public function includeSubtasks(Task $task)
    {
        return $this->collection($task->subtasks,new TaskTransformer());
        return $this->collection($task->subtasks,new SubTaskTransformer());
    }

    public function includeDiscusses(Task $task)
    {
        return $this->collection($task->discusses,new DiscussTransformer());
    }

    public function includeTaskLogs(Task $task)
    {
        return $this->collection($task->taskLogs,new TaskLogTransformer());
    }

}