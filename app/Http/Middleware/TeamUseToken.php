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
            //
            $team = Team::where('id',$teamMember->team_id)->where('close_time','>',date('Y-m-d H:i:s'))->first();
            if(!$team) {
                throw new ResourceException('请超级管理员续费之后在使用！');
            }
            // todo 是否在试用期间，试用期间不关心成员人数,
            // 1、关闭时间 == 创建时间+30 == 说明在试用期间
            // 2、当前时间>关闭时间===不在试用期间就需要续费了
            $thisDate = date("Y-m-d");// 当前时间 2020-11-9
            $closeTime = strtotime(auth('api')->user()->teams[0]->close_time);
            $createTime = strtotime(auth('api')->user()->teams[0]->created_at);
            $teamCloseTime = date('Y-m-d',$closeTime);// 2020-10-10
            if (bccomp(strtotime($thisDate),strtotime($teamCloseTime)) != -1) {
                throw new ResourceException('请先去续费！');
            }
//            dd($teamCloseTime,date('Y-m-d',strtotime(date('Y-m-d',$createTime).' + 30 day')));
            // date('Y-m-d',strtotime("2009-05-26 + 1 day"));
            if (bccomp(strtotime($teamCloseTime),strtotime(date('Y-m-d',$createTime).' + 30 day')) != 0) { // 时间到期没有付费，就去付费，付费完成以后关闭时间就会变长
                // 团队下有多少人任务流程创建失败
                $team = Team::where('id',$teamMember->team_id)->first();
                $teamMemberCount = $team->members()->count();
                if (bccomp($teamMemberCount, $team->number_count) == 1) { //bccomp('1', '2') . "\n";   // -1
                    throw new ResourceException('团队超员，请先去关掉多余的成员！');
                }
            }
        }else {
            throw new ResourceException('目前没有参加任何团队！');
        }

        return $next($request);
    }
}
