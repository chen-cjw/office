<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\SubTaskRequest;
use App\Models\Subtask;
use App\Models\TaskFlow;
use App\Models\User;
use App\Transformers\SubTaskTransformer;
use App\Transformers\TaskTransformer;
use Illuminate\Http\Request;

class SubTaskController extends Controller
{
    // 默认是分配的
    public function index()
    {
        if($close_date = \request()->close_date) {
            $subTasks = $this->user->subTasks()->orderBy('close_date',$close_date)->paginate();
        }elseif ($created_at = \request()->created_at) {
            $subTasks = $this->user->subTasks()->orderBy('created_at',$created_at)->paginate();
        }else {
            $subTasks = $this->user->subTasks()->orderBy('created_at','desc')->paginate();
        }

        return $this->response->paginator($subTasks, new SubTaskTransformer());
    }
    // 查看已完成的(分配给我的)
    public function status(Request $request)
    {
//        $status = $request->input('status','complete');
        $subTasks = $this->user->subTasks()->where('status','complete')->paginate();
        return $this->response->paginator($subTasks, new SubTaskTransformer());
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
            event(new TaskFlow($this->user->username.'指派给了'.$user->username,$request->user_id,$request->task_id));
            DB::commit();
            return $this->response->created();
        } catch (\Exception $ex) {
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
