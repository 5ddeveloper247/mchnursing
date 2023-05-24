<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class MaintenanceModeMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() && Settings('maintenance_status') == 1) {
            $maintain = collect();
            $maintain->maintenance_title = HomeContents('maintenance_title');
            $maintain->maintenance_sub_title = HomeContents('maintenance_sub_title');
            $maintain->maintenance_banner = HomeContents('maintenance_banner');
            return new response(view(theme('pages.maintenance'), compact('maintain')));
        }
        return $next($request);
    }
}
