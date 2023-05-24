<?php

namespace App\Http\Middleware;

use Closure;

class RoutePermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $route_name)
    {
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->role_id == 1) {
                return $next($request);
            } else {
                if (isModuleActive('OrgInstructorPolicy') && $user->role_id != 3) {
                    $roles = app('policy_permission_list');
                    $role = $roles->where('id', $user->policy_id)->first();
                } else {
                    $roles = app('permission_list');
                    $role = $roles->where('id', $user->role_id)->first();
                }

                if ($role != null && $role->permissions->contains('route', $route_name)) {
                    return $next($request);
                } else {
                    abort('403');
                }
            }
        } else {
            return redirect(route('login'));
        }
        abort('403');
    }
}
