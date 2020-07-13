<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\TeamRequest;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use App\Transformers\TeamMemberTransformer;
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
            return $this->response->item(Team::findOrFail($teamId), new TeamTransformer());
        }
        return ['data'=>[]];
    }

    // 搜索成员名字
    public function search($nickname)
    {
        $teamId = $this->user()->team()->value('id');
        $userIds = User::where('nickname','like','%'.$nickname.'%')->pluck('id');

        $teamMembers = TeamMember::where('team_id',$teamId)->whereIn('user_id',$userIds)->get();

        return $this->response->collection($teamMembers, new TeamMemberTransformer());
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
            throw new \Exception($ex); // 报错原因大多是因为taskFlowCollections表，name和user_id一致
            DB::rollback();
        }
        return $this->response->created();
    }

    public function update(TeamRequest $request)
    {
        $this->user()->team->update(['name'=>$request->name]);
        return $this->response->created();
    }

    public function delete($user_id,$team_id)
    {
        $team = $this->user()->team->where('id',$team_id)->first();
        if($team) {
            TeamMember::where('user_id',$user_id)->where('team_id',$team_id)->delete();
        }
        return $this->response->noContent();
    }

}
