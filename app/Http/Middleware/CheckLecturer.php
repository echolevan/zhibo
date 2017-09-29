<?php

namespace App\Http\Middleware;

use Closure;

class CheckLecturer
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
        if (\Auth::check()) {
            $auth = \Auth::user();
            if($auth->type != 2){
                return redirect(route('user'));
            }
        }
        return $next($request);
    }
}
