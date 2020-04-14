<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\TaskFlowRequest;
use App\Models\Task;
use App\Models\TaskFlow;
use Illuminate\Http\Request;

class TaskFlowController extends Controller
{
    /***
     * 任务流程（子流程）
     **/
    public function index()
    {

    }

    // 任务 详情
    public function show($id)
    {
        
    }

    // 创建子任务 有父任务(任务已经建好，只是做的分发)
    public function store(TaskFlowRequest $request,Task $task)
    {
        // todo 创建人可以分配任务
        $taskFlow = new TaskFlow($request->only('content','close_date','task_flow','status'));

        $taskFlow->task()->associate($task);
        $taskFlow;
        return $this->storeSave($taskFlow);
    }



}
