<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\DiscussRequest;
use App\Models\Discuss;
use App\Models\Task;
use App\Models\User;

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
        $data = $request->only('content','task_id');
        $data['comment_user_id'] = $request->comment_user_id; // Task::findOrFail($request->task_id)->value('user_id'); // 发表人
        $data['reply_user_id'] = $this->user->id; // 回复人(登陆者)
        $discuss = new Discuss($data);
        $this->storeSave($discuss);
        if($request->comment_user_id) {
            $user = User::find($request->comment_user_id);
            // todo 新评论回复通知
            new_comment_reply($user->ml_openid,$user->nickname,$user->content,'');
        }
        return $this->response->created();

    }
}
