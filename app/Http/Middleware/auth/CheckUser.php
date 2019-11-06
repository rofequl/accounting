<?php

namespace App\Http\Middleware;

use Closure;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $url = 'http://nayem.kajerkhojay.com';
        $permission = 2;
        $ip = '103.135.211.130';

        $result = file_get_contents("$url/login-check", false, stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded",
                'content' => http_build_query([
                    'ip' => $ip, 'permission' => $permission
                ])
            ]
        ]));

        if (json_decode($result)->status == 'authorized') return $next($request);
        else {
            header("Location: $url");
            die();
        }

    }
}
