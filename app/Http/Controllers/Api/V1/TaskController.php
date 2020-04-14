<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Transformers\TaskTransformer;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * 我的任务(首页)
     * 条件（按截止时间排序 | 创建时间排序 | 查看已完成任务 | 查看我创建的任务）
     **/

    public function index()
    {

    }

    // 创建子任务(发布任务) 无父任务(创建给你让你，去完成的)
    public function store(TaskRequest $request)
    {
        // todo 谁可以创建任务
        $task = new Task($request->only('content','close_date','task_flow','status'));
        $task->user()->associate($this->user);

        return $this->storeSave($task);
    }

    //
    public function show($id)
    {
        return $this->response->item($this->user->tasks()->findOrFail($id),new TaskTransformer());
    }

//    public function storeSave($task)
//    {
//        $imageBool = request()->hasFile('images');
//        $images = request()->file('images');
//        $uploadImage = $task->uploadImages($imageBool,$images);
//        $task->user()->associate($this->user);
//        $task->images = json_encode($uploadImage);
//        $task->save();
//
//        return $this->response->created();
//    }
}
