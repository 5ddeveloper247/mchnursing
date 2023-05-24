<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\SystemSetting\Entities\TutorHiring;


class TutorController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenanceMode');
    }

    public function myTutors(Request $request)
    {
        try {
            $tutors = TutorHiring::where('user_id',Auth::id())->orderBy('assign_date','DESC')->with('instructor','course')->paginate(9);

            return view(theme('pages.myTutors'), compact('tutors'));

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

}
