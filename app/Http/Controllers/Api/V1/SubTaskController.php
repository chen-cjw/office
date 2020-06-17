<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\TaskLog;
use App\Http\Requests\SubTaskRequest;
use App\Models\Subtask;
use App\Models\TaskFlow;
use App\Models\User;
use App\Transformers\SubTaskTransformer;
use App\Transformers\TaskTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubTaskController extends Controller
{
    // 默认是分配的
    public function index()
    {
        $close_date = \request()->close_date;
        $created_at = \request()->created_at;
        $status = \request()->input('status','complete');
        $query = $this->user;
        if($close_date) {
            $query = $query->subTasks()->orderBy('close_date',$close_date)->where('status',$status)->paginate();
        }elseif ($created_at) {
            $query = $query->subTasks()->orderBy('created_at',$created_at)->where('status',$status)->paginate();
        }elseif($status = \request()->status) {
            $query = $query->subTasks()->where('status',$status)->paginate();
        }else {
            $query = $query->subTasks()->orderBy('created_at','desc')->paginate();
        }

        return $this->response->paginator($query, new SubTaskTransformer());
    }

    public function show($id)
    {
        return $this->response->item($this->user->subTasks()->findOrFail($id),new SubTaskTransformer());
    }
    // todo 判断user_id 是不是我们团队的，必须有团队才可以
    public function store(SubTaskRequest $request)
    {
        DB::beginTransaction();
        try {
            $subtask = new Subtask($request->only('content','close_date','task_flow','status'));
            $user = User::findOrFail($request->user_id);
            $subtask->user()->associate($user);
            $subtask->task()->associate($this->user->tasks()->findOrFail($request->task_id));
            $this->storeSave($subtask);

            event(new TaskLog($this->user->username.'指派给了'.$user->username, $request->user_id, $request->task_id, Subtask::class));
            DB::commit();
            return $this->response->created();
        } catch (\Exception $ex) {
            throw new \Exception($ex);
            DB::rollback();
        }
    }
    // 只有本人才可以修改任务状态
    public function update(SubTaskRequest $request,$id)
    {
        $this->user->subTasks()->where('id',$id)->firstOrFail()->update(['status'=>$request->status]);
        event(new TaskFlow($this->user->username.Subtask::$status[$request->status],$id));

        return $this->response->created();

    }
}
