<?php

namespace App\Http\Middleware;

use App\Events\LastActivityEvent;
use App\Models\UserAuthorzIationAgreement;
use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class StudentMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role_id == 3) {

            $user = UserAuthorzIationAgreement::where('user_id', $request->user()->id)->first();

            if ($user->user_agreement_form == null || $user->status == null) {
                Toastr::error('Please Upload Your Agreement Form', 'Error');
            }

            if ($user->status == 2) {
                Toastr::error('Your Form was Not Correct, Please Upload Correct Form Again', 'Error');
            }

            if (
                !$request->user() ||
                ($request->user() instanceof MustVerifyEmail &&
                    !$request->user()->hasVerifiedEmail())
            ) {
                return $request->expectsJson()
                    ? abort(403, 'Your email address is not verified.')
                    : Redirect::route('verification.notice');
            }
            return $next($request);
        } elseif (Auth::check() && (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)) {

            if (Auth::user()->role_id == 1) {
                return $next($request);
            } else {
                return redirect()->to(route('dashboard'));
            }
        } else {
            return redirect()->to('/login');
        }
    }
}
