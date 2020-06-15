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
            $taskFlowCollectionName = $request->name;
            $stepName = $request->step_name;
            if ($taskFlowCollectionName==null) {
                // 创建
                $taskFlowCollection = new TaskFlowCollection(['name'=>$stepName]);
                $taskFlowCollection->user()->associate($this->user);
                $taskFlowCollection->save();
            }else {
                // 修改
                $taskFlowCollection= $this->user->taskFlowCollections()->where('name',$taskFlowCollectionName)->first();//
                $taskFlowCollection->update(['name'=>$taskFlowCollectionName.'-'.$stepName]);;
            }
            // task_flows 表         'step_name','status'
            $taskFlow = new TaskFlow($request->only('step_name','status'));
            // user_id 要控制在自己的团队之内
            $taskFlow->user()->associate(User::findOrFail($request->user_id));
            $taskFlow->taskFlowCollection()->associate($taskFlowCollection);
            $taskFlow->save();
            DB::commit();
            return $this->response->created();
        } catch (\Exception $ex) {
            Log::error($ex);
            throw new ResourceException($ex); // 报错原因大多是因为taskFlowCollections表，name和user_id一致
            DB::rollback();

        }
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
