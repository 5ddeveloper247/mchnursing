<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\CourseCanceled;
use Modules\CourseSetting\Entities\CourseEnrolled;

class EnrollmentCancellationPageSection extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        $records = CourseCanceled::where('user_id', auth()->id())->with('course')->paginate(10);
        $courses = CourseEnrolled::where('user_id', auth()->id())->with('course')->get();
 
        return view(theme('components.enrollment-cancellation-page-section'), compact('records', 'courses'));
    }
}
