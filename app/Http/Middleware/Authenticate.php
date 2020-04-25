<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // UnauthorizedHttpException
            throw new UnauthorizedHttpException('请先去登陆');
            return $this->response->array(['error' => 'Unauthorized'])->setStatusCode(401);

            return route('login');
        }
    }
}
