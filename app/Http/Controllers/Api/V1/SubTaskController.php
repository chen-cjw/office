<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\SubTaskRequest;
use App\Models\Subtask;
use App\Models\User;
use App\Transformers\TaskTransformer;

class SubTaskController extends Controller
{
    // 默认是分配的
    public function index()
    {
        return $this->response->collection($this->user->tasks,new TaskTransformer());
    }

    // todo 判断user_id 是不是我们团队的
    // todo 必须有团队才可以
    public function store(SubTaskRequest $request)
    {
        $subtask = new Subtask($request->only('content','close_date','task_flow','status'));
        $subtask->user()->associate(User::findOrFail($request->user_id));
        $subtask->task()->associate($this->user->tasks()->findOrFail($request->task_id));
        $this->storeSave($subtask);

        return $this->response->created();
    }
}
