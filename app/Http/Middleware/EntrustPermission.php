<?php

namespace App\Http\Middleware;

use App\Admin_user;
use App\Role;
use Illuminate\Contracts\Auth\Guard;
use Zizaco\Entrust\EntrustFacade as Entrust;
use Closure;
use Route, URL, Auth;

class EntrustPermission
{
    protected $auth;

    /**
     * Creates a new instance of the middleware.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {

        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure $next
     * @param  $permissions
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $adminuser = Admin_user::find(Auth::guard('admin')->user()->id);
        if($adminuser->hasRole('super')){
            return $next($request);
        }
        if (!$adminuser->can(Route::currentRouteName())) {
            return response()->view('admin.errors.403');
        }
        return $next($request);
    }
}
