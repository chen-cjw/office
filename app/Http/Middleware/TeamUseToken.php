<?php

namespace App\Http\Middleware;

use App\Models\Team;
use App\Models\TeamMember;
use Closure;
use Dingo\Api\Exception\ResourceException;

class TeamUseToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // 团队是否可用「到期时间/使用人数」
        $teamMember = TeamMember::where('user_id',auth('api')->id())->first();
        if($teamMember) {
            $team = Team::where('id',$teamMember->team_id)->where('close_time',date('Y-m-d'))->first();
            if(!$team) {
                throw new ResourceException('请超级管理员续费之后在使用！');
            }
            // 团队下有多少人
            $team = Team::where('id',$teamMember->team_id)->first();
            $teamMemberCount = $team->members()->count();
            if (bccomp($teamMemberCount, $team->number_count) == 1) { // bccomp('1', '2') . "\n";   // -1
                throw new ResourceException('团队超员，请先去关掉多余的成员！');
            }
        }

        return $next($request);
    }
}
