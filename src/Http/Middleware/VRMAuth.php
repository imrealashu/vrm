<?php namespace Listbees\VRM\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VRMAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->path() == "vrm/login") {
            if (session()->has('vrm-admin')) return redirect()->route('vrm-home');
        } else {
            if (session()->has('vrm-admin') == false) return redirect()->route('vrm-login');
        }

        return $next($request);
    }
}
