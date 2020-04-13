<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\TeamRequest;
use App\Models\Team;
use App\Transformers\TeamTransformer;
use Dingo\Api\Auth\Auth;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // 我的团队
    public function index()
    {
        $team = $this->user()->team;
        return $this->response->item($team,new TeamTransformer());
    }
    // todo 目前可以创建多个团队
    public function store(TeamRequest $request)
    {
        // todo 要符合某个条件，成员可以创建团队
        // 创建团队
        $team = new Team(['name'=>$request->name]);
        $team->user()->associate($this->user());
        $team->save();
        $this->user()->update(['task_id'=>$team->id]);

        return $this->response->created();
    }

    // 修改团队名 对于申请的用户进行 允许|拒绝 | 设置管理员|取消管理员|删除团队组员
    public function update(TeamRequest $request)
    {
        $this->user()->team->update(['name'=>$request->name]);
        return $this->response->created();
    }

}
