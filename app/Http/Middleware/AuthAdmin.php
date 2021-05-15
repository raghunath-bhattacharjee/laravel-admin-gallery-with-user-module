<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthAdmin
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
        //check if user is authenticated or not and user is active or not
        if (!Auth::user() || !Auth::user()->isAciveUser()) {
            Auth::logout();
            Session::flush();
            $request->session()->flash('alert-danger', 'These credentials do not match our records.');
            return redirect()->back();
        }
        return $next($request);
    }
}
