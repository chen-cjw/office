<?php

namespace App\Http\Middleware;

use Closure;
use Dingo\Api\Exception\ResourceException;

class UserAuthorization
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
        if(!auth('api')->user()->phone) {
            throw new ResourceException('此用户授权未成功，请先去授权');
        }
        return $next($request);
    }
}
