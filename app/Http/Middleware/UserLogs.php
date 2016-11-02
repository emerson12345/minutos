<?php

namespace Sicere\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Storage;

class UserLogs
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
        $filename = date('dmY').'.log';
        $content  = date('H:i:s')."    ";
        $content .= $request->user()->user_codigo."    ";
        $content .= $request->url()."    ";
        $content .= $request->ip();

        Storage::disk('log')->append($filename,$content);
        return $next($request);
    }
}
