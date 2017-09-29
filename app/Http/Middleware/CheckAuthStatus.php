<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CheckAuthStatus
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
        $user = User::find(\Auth::user()->id);
        if($user->status != 1){
            \Auth::logout();
            return redirect(route('home'));
        }
        return $next($request);
    }
}
