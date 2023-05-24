<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\LmsInstitute;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class SubdomainMiddleware
{
    public function handle($request, Closure $next)
    {

        if (config('app.short_url') == request()->getHost()) {
            $domain = null;
        } else {
            $domain = str_replace('.' . config('app.short_url'), '', request()->getHost());
        }

        if ($domain) {
            $institute = LmsInstitute::on('mysql')->where('domain', $domain)->firstOrFail();
        } else {
            $institute = LmsInstitute::on('mysql')->findOrFail(1);
        }
        Session::put('domain', $domain);
        $host = $request->getHttpHost();

        if (isModuleActive('LmsSaasMD')) {

            if ($institute->status == 0) {
                $maintain = collect();
                $maintain->maintenance_title = trans('saas.View Title');
                $maintain->maintenance_sub_title = trans('saas.View Sub Title');
                $maintain->maintenance_banner = HomeContents('maintenance_banner');
                return new response(view(theme('pages.maintenance'), compact('maintain')));
            }


            if (DB::connection()->getDatabaseName() != $institute->db_database) {
                DbConnect();
            }
        }

        app()->forgetInstance('institute');
        app()->instance('institute', $institute);
        return $next($request);
    }


}
