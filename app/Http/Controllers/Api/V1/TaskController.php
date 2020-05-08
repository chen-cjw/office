<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\TaskLog;
use App\Events\Welfare;
use App\Http\Requests\TaskRequest;
use App\Listeners\WelfareListener;
use App\Models\Task;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use App\Transformers\TaskTransformer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * 我的任务(首页)查看我创建的任务
     * 条件（按截止时间排序 | 创建时间排序 | 查看已完成任务 | 查看我创建的任务）
     **/
    public function index()
    {
        if($close_date = \request()->close_date) {
            $tasks = $this->user->tasks()->orderBy('close_date',$close_date)->paginate();
        }elseif ($created_at = \request()->created_at) {
            $tasks = $this->user->tasks()->orderBy('created_at',$created_at)->paginate();
        }else {
            $tasks = $this->user->tasks()->orderBy('created_at','desc')->paginate();
        }
        return $this->response->paginator($tasks,new TaskTransformer());
    }

    // todo 谁可以创建任务
    // 1、任务要有指派人
    // 2、指派人必须在我的团队
    public function store(TaskRequest $request)
    {
        DB::beginTransaction();
        try {
            $task = new Task($request->only('content','close_date','task_flow','status','assignment_user_id'));
            $task->user()->associate($this->user);
            // 创建日志
            $taskItem = $this->storeSave($task);
            event(new TaskLog($this->user->phone.'创建了任务',$this->user->id,$taskItem->id,Task::class));
            event(new TaskLog($this->user->phone.'指派给了'.User::findOrFail($request->assignment_user_id)->phone,$request->assignment_user_id,$taskItem->id,Task::class));
            DB::commit();
            return $this->response->created();
        } catch (\Exception $ex) {
            DB::rollback();
            throw new \Exception($ex);
        }
    }

    //
    public function show($id)
    {
        return $this->response->item($this->user->tasks()->findOrFail($id),new TaskTransformer());
    }

    // 只有本人才可以修改任务状态，任务完成。邀请我的人(有团队的人)，可使用天数就会增加
    public function update(TaskRequest $request,$id)
    {
        DB::beginTransaction();
        try {
            $this->user->tasks()->where('id',$id)->firstOrFail()->update(['status'=>$request->status]);
            // 判断是否结束了任务，然后触发时间。给邀请人触发添加免费使用天数
            event(new Welfare());
            DB::commit();
            return $this->response->created();
        } catch (\Exception $ex) {
            DB::rollback();
            throw new \Exception($ex);
        }

    }
}
