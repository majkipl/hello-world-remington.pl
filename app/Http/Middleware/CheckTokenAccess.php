<?php

namespace App\Http\Middleware;

use Closure;

class CheckTokenAccess
{
    public function handle($request, Closure $next)
    {
        $jwtToken = session('token_access');

        if (!$jwtToken) {
            auth()->logout();
            return redirect('/login')->with('error', 'Twoja sesja wygasła. Zaloguj się ponownie.');
        }

        return $next($request);
    }
}
