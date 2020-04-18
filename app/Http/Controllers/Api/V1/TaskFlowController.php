<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\TaskFlowRequest;
use App\Models\Task;
use App\Models\TaskFlow;
use App\Models\TaskFlowCollection;
use App\Models\User;
use Illuminate\Http\Request;

class TaskFlowController extends Controller
{
    // 创建子任务 有父任务(任务已经建好，只是做的分发)
    public function store(Request $request)
    {

        $taskFlowCollectionName = $request->name;
        $stepName = $request->step_name;
        if ($taskFlowCollectionName==null) {
            // 创建
            $taskFlowCollection = new TaskFlowCollection(['name'=>$stepName]);
            $taskFlowCollection->user()->associate($this->user);
            $taskFlowCollection->save();
        }else {
            // 修改
            $taskFlowCollectionId = $this->user->taskFlowCollections()->where('name',$taskFlowCollectionName)->update(['name'=>$taskFlowCollectionName.'-'.$stepName]);
            $taskFlowCollection = TaskFlowCollection::find($taskFlowCollectionId);
        }
        // task_flows 表         'step_name','status'
        $taskFlow = new TaskFlow($request->only('step_name','status'));
        // user_id 要控制在自己的团队之内
        $taskFlow->user()->associate(User::findOrFail($request->user_id));
        $taskFlow->taskFlowCollection()->associate($taskFlowCollection);
        $taskFlow->save();
        return $this->response->created();
    }

    // todo 这里需要看是否是某个团队成员
    public function update(Request $request,$task_flow_collection_id,$task_flow_id)
    {
        $this->user->taskFlowCollections()->findOrFail($task_flow_collection_id)->taskFlows()->where('id',$task_flow_id)->update(['user_id'=>$request->user_id]);
        return $this->response->created();
    }
}
