<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSiswa
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isSiswa()) {
            return $next($request);
        }

        abort(403, 'Akses khusus Warga Belajar.');
    }
}
