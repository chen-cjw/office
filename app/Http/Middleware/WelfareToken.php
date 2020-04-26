<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;

class WelfareToken
{
    /**
     * Handle an incoming request.
     * 是否符合福利的条件，送免费天数
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 此用户是否开启了送的模式
        $thisUser = auth('api')->user();
        if($thisUser->is_open == true) {
            if($thisUser->tasks()->where('status',Task::REFUND_END)->count() == $thisUser->sendInviteSet->requirement) {
                $thisUser->team->close_time->modify('+'.$thisUser->sendInviteSet->day.' days');
            }
        }
        // 是否符合三次标准了
        return $next($request);
    }
}
