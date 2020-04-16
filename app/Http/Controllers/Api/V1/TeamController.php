<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\TeamRequest;
use App\Models\Team;
use App\Models\TeamMember;
use App\Transformers\TeamTransformer;
use Illuminate\Support\Facades\DB;
class TeamController extends Controller
{
    // 我的团队成员
    public function index()
    {
        $teamId = TeamMember::where('user_id',$this->user->id)->value('team_id');
        if ($teamId) {
            return $this->response->item(Team::findOrFail($teamId),new TeamTransformer());
        }
        return ['data'=>[]];
    }
    // 创建团队
    public function store(TeamRequest $request)
    {
        DB::beginTransaction();
        try {
            $team = new Team(['name'=>$request->name]);
            $team->user()->associate($this->user());
            $team->save();

            $teamMember = new TeamMember();
            $teamMember->user()->associate($this->user());
            $teamMember->team()->associate($team);
            $teamMember->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
        }
        return $this->response->created();
    }

    // 修改团队名 对于申请的用户进行 允许|拒绝 | 设置管理员|取消管理员|删除团队组员
    public function update(TeamRequest $request)
    {
        $this->user()->team->update(['name'=>$request->name]);
        return $this->response->created();
    }

}
