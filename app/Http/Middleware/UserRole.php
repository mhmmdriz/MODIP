<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role1, $role2="", $role3=""): Response
    {
        if (auth()->user()->level == $role1 || auth()->user()->level == $role2 || auth()->user()->level == $role3) {
            return $next($request);
        }
        return redirect("/");
    }
}
