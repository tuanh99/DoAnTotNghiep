<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class RedirectIfNotUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
//     public function handle(Request $request, Closure $next): Response
// {
//     if (!auth('user')->check() || !auth('user')->user()->isUser()) {
//         // abort(403, 'Bạn phải đăng nhập user!');
//         return redirect('/user/login');
//         // return redirect()->guest(route('user.login'))->with('url.intended', $request->url());
//     }
//     return $next($request);
// }

public function handle(Request $request, Closure $next): Response
{
    if (!Auth('user')->check() || !Auth('user')->user()->isUser()) {
        // abort(403, 'Unauthorized action.');
        return redirect('/user/login');

    }
    return $next($request);
}
}