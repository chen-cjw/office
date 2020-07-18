<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\TaskLog;
use App\Http\Requests\SubTaskRequest;
use App\Models\Subtask;
use App\Models\Task;
use App\Models\TaskFlow;
use App\Models\User;
use App\Transformers\SubTaskTransformer;
use App\Transformers\TaskTransformer;
use Dingo\Api\Exception\ResourceException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubTaskController extends Controller
{
    // 默认是分配的
    public function index()
    {
        $close_date = \request()->close_date;
        $created_at = \request()->created_at;
        $status = \request()->status;
//        $status = \request()->input('status','complete');
        $query = $this->user->subTasks();
        if ($status) {
            $query = $query->where('status',$status);
        }
        if ($close_date) {
            $query = $query->orderBy('close_date',$close_date);
        }
        if ($created_at) {
            $query = $query->orderBy('created_at',$created_at);
        }

        return $this->response->paginator($query->paginate(), new TaskTransformer());
    }

    public function show($id)
    {
        return $this->response->item($this->user->tasks()->where('id',$id)->findOrFail(),new SubTaskTransformer());
    }
    // todo 判断user_id 是不是我们团队的，必须有团队才可以
    public function store(SubTaskRequest $request)
    {
        DB::beginTransaction();
        try {
            $subtask = new Task($request->only('content','close_date','task_flow','status','task_id'));
            $user = User::findOrFail($request->user_id);
            $subtask->user()->associate($this->user);
            $subtask->assignmentUser()->associate($user);
            $this->storeSave($subtask);

            event(new TaskLog($this->user->username.'指派给了'.$user->username, $request->user_id, $request->task_id, Task::class));
            DB::commit();
            return $this->response->created();
        } catch (\Exception $ex) {
            DB::rollback();
            throw new \Exception($ex);
        }
    }
    // 只有本人/指定任务给我那个人可以修改任务状态
    public function update(SubTaskRequest $request,$id)
    {
        $user = $this->user();
        //
        DB::beginTransaction();
        try {
            $user->subTasks()->where('id', $id)->firstOrFail()->update(['status' => $request->status]);
            event(new TaskLog($user->username . '任务已' . Task::$status[$request->status], $user->id, $id, Task::class));
            DB::commit();
            return $this->response->created();
        }catch (\Exception $ex) {
            DB::rollback();
            throw new ResourceException('只有负责人可以修改！');
            //throw new \Exception($ex);
        }

    }
}
