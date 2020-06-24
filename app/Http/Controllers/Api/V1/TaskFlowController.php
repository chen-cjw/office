<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\TaskFlowRequest;
use App\Http\Requests\TaskFlowUpdateStatusRequest;
use App\Models\TaskFlow;
use App\Models\TaskFlowCollection;
use App\Models\User;
use Dingo\Api\Exception\ResourceException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskFlowController extends Controller
{
    // 任务流程
    public function store(TaskFlowRequest $request)
    {

        DB::beginTransaction();
        try {
            $taskFlowItems = $request->input('task_flows');
            $taskFlowCollection = new TaskFlowCollection([
                'name' => $request->name
            ]);
            $taskFlowCollection->user()->associate($this->user);
            $taskFlowCollection->save();
            foreach ($taskFlowItems as $data) {
                $taskFlowItem = new TaskFlow([
                    'step_name' => $data['step_name'],
                    'status' => 'all',// $data['status'] == 'all' ? 'all' : $data['status'],
                    'user_id' => $data['user_id'],
                    'task_flow_collection_id' => $taskFlowCollection->id,
                ]);
                $taskFlowItem->save();
            }
            DB::commit();
        } catch (\Exception $ex) {
            Log::error($ex);
            throw new ResourceException($ex); // 报错原因大多是因为taskFlowCollections表，name和user_id一致
            DB::rollback();
        }
        return $this->response->created();
    }

    // todo 这里需要看是否是某个团队成员
    public function update(TaskFlowRequest $request,$task_flow_collection_id,$task_flow_id)
    {
        $this->user->taskFlowCollections()->findOrFail($task_flow_collection_id)->taskFlows()->where('id',$task_flow_id)->update(['user_id'=>$request->user_id]);
        // 判断是否结束了任务，然后触发时间。给邀请人触发添加免费使用天数
        return $this->response->created();
    }
    
    // 我本人修改本人的任务流程状态
    public function updateStatus(TaskFlowUpdateStatusRequest $request,$id)
    {
        $this->user->taskFlows()->where('id',$id)->firstOrFail()->update(['status'=>$request->status]);
        // 判断是否结束了任务，然后触发时间。给邀请人触发添加免费使用天数
        return $this->response->created();
    }

}
