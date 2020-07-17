<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Dingo\Api\Exception\ResourceException;

class UserStatus
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

        if(User::where('id',auth('api')->id())->where('status','freeze')->exists() || User::where('id',auth('api')->id())->where('status','wait')->exists()) {
            throw new ResourceException('待审核');
        }
        return $next($request);
    }
}
