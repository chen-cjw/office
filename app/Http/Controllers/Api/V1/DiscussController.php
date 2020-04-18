<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\DiscussRequest;
use App\Models\Discuss;
use App\Models\Task;

class DiscussController extends Controller
{
    /***
     * 分开可能评论过多，任务详情下的评论
     **/
    public function index()
    {
        
    }

    // todo 回复评论，要看看我分任务给他没有/我是不是发任务的人
    // 自己不能给自己回复
    public function store(DiscussRequest $request)
    {
        // 判断两个人是否是一个团队的
        $data = $request->only('content','task_id','comment_user_id');
        $data['reply_user_id'] = $this->user->id;
        $discuss = new Discuss($data);

        return $this->storeSave($discuss);
    }
}
