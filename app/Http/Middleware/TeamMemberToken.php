<?php

namespace App\Http\Middleware;

use App\Models\TeamMember;
use Closure;
use Dingo\Api\Exception\ResourceException;

class TeamMemberToken
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
        // 团队成员是否存在团队中
        $isset = TeamMember::where('user_id',auth('api')->id())->first();
        if(!$isset) {
            throw new ResourceException('暂时没有团队！');
        }
        return $next($request);
    }
}
