<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\SubTaskRequest;
use App\Models\Subtask;
use App\Models\User;

class SubTaskController extends Controller
{
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
