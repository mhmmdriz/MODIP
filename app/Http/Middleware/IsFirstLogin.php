<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsFirstLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if ($user->level == "mahasiswa") {
            $mahasiswa = $user->mahasiswa;
            if (collect([$mahasiswa->jalur_masuk, $mahasiswa->no_telp, $mahasiswa->email_sso, $mahasiswa->alamat, $mahasiswa->kabupaten_kota, $mahasiswa->provinsi])->contains(null)) {
                return redirect("/firstLogin");
            }            
        }

        return $next($request);
    }
}
