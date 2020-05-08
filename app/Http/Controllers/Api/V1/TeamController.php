<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\TeamRequest;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use App\Transformers\TeamTransformer;
use Illuminate\Support\Facades\DB;
use Dingo\Api\Exception\StoreResourceFailedException;

class TeamController extends Controller
{
    // 我的团队成员
    public function index()
    {
        // comment('超级管理员(administrator)|管理员(admin)|成员(member)|冻结账号(freeze)|等待审核(wait)');
        if($this->user->status=='freeze'||$this->user->status=='wait') {
            return ['data'=>[]];
        }
        $teamId = TeamMember::where('user_id',$this->user->id)->value('team_id');
        if ($teamId) {
            return $this->response->item(Team::findOrFail($teamId),new TeamTransformer());
        }
        return ['data'=>[]];
    }
    // 创建团队
    public function store(TeamRequest $request)
    {
        // 判断是否属于某个团队，属于是不可以添加团队的
        DB::beginTransaction();
        try {
            $team = new Team(['name'=>$request->name,'number_count'=>config('app.number_count'),'close_time'=>date('Y-m-d H:i:s',strtotime('+'.config('app.close_time').' day'))]);
            $team->user()->associate($this->user());
            $team->save();

            $this->teamMember($this->user(),$team);// 用户和团队建立关系
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
        }
        return $this->response->created();
    }

    // 修改团队名 对于申请的用户进行 允许|拒绝 | 设置管理员|取消管理员|删除团队组员
    public function update(TeamRequest $request,$team,$user)
    {
        if($user = $request->name) {
            $this->user()->team->update(['name'=>$request->name]);
            return $this->response->created();
        }
        if($this->user->team->id == $team) {
            if($this->user->status=='administrator'||$this->user->status=='admin') {
                User::where('id',$user)->update(['status'=>$request->status]);
                return $this->response->created();
            }
        }
        throw new StoreResourceFailedException('没有权限修改!');
    }

}
