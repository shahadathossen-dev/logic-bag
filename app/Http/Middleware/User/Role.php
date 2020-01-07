<?php

namespace App\Http\Middleware\User;

use Closure;
use App\Models\Backend\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    // protected $auth;

    public function __construct()
    // public function __construct(Guard $auth)
    {
        // $this->middleware('auth:admin');
        // $this->auth = $auth;
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function handle($request, Closure $next, $role)
    {

        if (!$this->guard()->user()->role->is($role)) {
            return $request->expectsJson()
                    ? abort(403, 'You are not authorized for the action.', ['url' => route('admin.status.notice')])
                    : Redirect::route('admin.status.notice');
        }
        return $next($request);
    }
}
