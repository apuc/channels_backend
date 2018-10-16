<?php

namespace App\Http\Middleware;

use Closure;

class LocaleMiddleware
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
        if (!is_null($request->cookie('language'))) {
            app()->setLocale(\Crypt::decryptString($request->cookie('language')));
        }

        return $next($request);
    }
}
