<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\DB;

use Closure;

class ApiLogin
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
        $secret = DB::table('oauth_clients')
        ->where('id', 2)
        ->pluck('secret')
        ->first();

        $request->merge([
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => $secret,
        ]);

        return $next($request);
    }
}
