<?php

namespace App\Listeners;

use App\Events\TaskLog;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class TaskLogListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TaskLog  $event
     * @return void
     */
    public function handle(TaskLog $event)
    {
        $content = $event->content;
        $user_id = $event->user_id;
        $model_id = $event->model_id;
        $model_type = $event->model_type;
        $data = \array_merge(['content'=>$content],['user_id'=>$user_id],['model_id'=>$model_id],['model_type'=>$model_type]);
        Log::info($data);
        \App\Models\TaskLog::create($data);
    }
}
