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
use Dingo\Api\Exception\ResourceException;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * 我的任务(首页)查看我创建的任务
     * 条件（按截止时间排序 | 创建时间排序 | 查看已完成任务 | 查看我创建的任务）
     **/
    public function index()
    {
        $close_date = \request()->close_date;
        $created_at = \request()->created_at;
        $status = \request()->status;
        $query = $this->user;
        if($close_date) {
            $tasks = $query->tasks()->orderBy('close_date',$close_date)->where('status',$status)->paginate();
        }elseif ($created_at) {
            $tasks = $query->tasks()->orderBy('created_at',$created_at)->where('status',$status)->paginate();
        }elseif ($status) {
            $tasks = $query->tasks()->where('status',$status)->orderBy('created_at','desc')->paginate();
        }else {
            $tasks = $query->tasks()->orderBy('created_at','desc')->paginate();
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
            event(new TaskLog($this->user->nickname.'创建了任务',$this->user->id,$taskItem->id,Task::class));
            event(new TaskLog($this->user->nickname.'指派给了'.User::findOrFail($request->assignment_user_id)->nickname,$request->assignment_user_id,$taskItem->id,Task::class));
            // 消息推送模版
//            $this->notificationAdd();
//            $this->notificationAppoint($task);
            DB::commit();
            return $this->response->created();
        } catch (\Exception $ex) {
            DB::rollback();
            throw new \Exception($ex);
        }
    }

    // 指派任务
    protected function notificationAppoint($task) {
        $app = app('wechat.mini_program');

        $user = auth('api')->user();
        $data = [
            'template_id' => '5QHREHN9uRyW7_rH9ZQYtyF71DImcD3vY-AgQkJvOD0', // 所需下发的订阅模板id
            'touser' => $user->ml_openid,     // 接收者（用户）的 openid
            'page' => '',       // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
            'data' => [         // 模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
                'thing2' => [
                    'value' => $task['content'],
                ],
                'date3' => [
                    'value' => '结束时间'.$task['task_flow'],
                ],
                'thing4' => [
                    'value' => '任务状态'.Task::$status[$task['status']]
                ],
            ],
        ];

        $app->subscribe_message->send($data);
    }

    // 创建
    protected function notificationAdd() {
        $app = app('wechat.mini_program');

        $user = auth('api')->user();
        $data = [
            'template_id' => 'HUsu1tRWb4Czrcgs6ldCaKDnqXfH-DxhKytA2LOFk5k',  // 所需下发的订阅模板id
            'touser' => $user->ml_openid, // 接收者（用户）的 openid
            'page' => '', // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
            'data' => [         // 模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
                'thing1' => [
                    'value' => $user->nickname,
                ],
                'phone_number2' => [
                    'value' => $user->phone,
                ],
                'thing3' => [
                    'value' => '创建了任务',
                ],
                'time4' => [
                    'value' => date('Y-m-d H:i:s'),
                ],
            ],
        ];

        $app->subscribe_message->send($data);
    }

    //
    public function show($id)
    {
        $tasks = $this->user->tasks()->where('id',$id)->first()
        if ($tasks) {
            return $this->response->item($tasks,new TaskTransformer());
        }
        if ($tasks->assignment_user_id == $this->user()->id) {
            return $this->response->item($tasks,new TaskTransformer());
        }
        throw new ResourceException('暂无此任务！');
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
            throw new \Exception($ex);
            DB::rollback();
        }

    }
}
