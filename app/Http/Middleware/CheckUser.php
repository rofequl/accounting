<?php

namespace App\Http\Middleware;

use Closure;
use Ixudra\Curl\Facades\Curl;

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
        $ip = \Request::ip();
        $browser = $_SERVER['HTTP_USER_AGENT'];

        $result = Curl::to("$url/login-check")
            ->withData(array('ip' => $ip, 'permission' => $permission, 'browser' => $browser))
            ->post();

        if (json_decode($result)->status == 'authorized') return $next($request);
        else {
            header("Location: $url");
            die();
        }

    }
}
