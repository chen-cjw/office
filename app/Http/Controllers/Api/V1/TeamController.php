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
        if (Team::where('user_id',$this->user->id)->exists()) {
            return $this->response->collection(Team::where('user_id',$this->user->id)->get(),new TeamTransformer());
        }
        return ['data'=>[]];
    }
    // 创建团队
    public function store(TeamRequest $request)
    {
        $team = new Team(['name'=>$request->name]);
        $team->user()->associate($this->user());
        $team->save();
        $this->user()->update(['team'=>$team->id]);
        return $this->response->created();
    }

    // 修改团队名 对于申请的用户进行 允许|拒绝 | 设置管理员|取消管理员|删除团队组员
    public function update(TeamRequest $request)
    {
        $this->user()->team->update(['name'=>$request->name]);
        return $this->response->created();
    }

}
