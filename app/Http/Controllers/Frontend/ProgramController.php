<?php


namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\StudentSetting\Entities\Program;
use Modules\FrontendManage\Entities\HomePageFaq;
use Modules\CourseSetting\Entities\Course;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenanceMode');
    }

    public function programs(Request $request)
    {
        $recent_program = Program::where('status', 1)->has('currentProgramPlan')->with('currentProgramPlan')->inRandomOrder()->take(3)->get();
        $programs = Program::where('status', 1)->has('currentProgramPlan')->with('currentProgramPlan')->paginate(9);

        return view(theme('pages.programs'), get_defined_vars());
    }
    public function programsDetail(Request $request,$id)
    {

        $program_detail = Program::where('id',$id)->with(['programPlans.programPalnDetail','currentProgramPlan' => function($q){
           $q->with(['initialProgramPalnDetail','programPalnDetail']);
        }])->first();


//        program enroll check
        $is_allow = false;
        $course_count = 2;
        $isEnrolled = false;
        if (isset($program_detail->currentProgramPlan[0])){
            if (Auth::check() && $program_detail->isLoginUserEnrolled) {
                $is_allow = true;
                $course_count = 6;
                $isEnrolled = true;
            }
        }


//        program faqs
        $faqs = HomePageFaq::whereIn('id',json_decode($program_detail->faqs) ?? [])->orderBy('order', 'asc')->get();

//        program course
        $courses = Course::whereIn('id',json_decode($program_detail->allcourses) ?? [])->with('enrollUsers', 'user', 'user.courses', 'user.courses.enrollUsers', 'user.courses.lessons', 'chapters.lessons', 'enrolls', 'lessons', 'reviews', 'chapters', 'activeReviews')->orderBy('created_at', 'DESC')->paginate($course_count);
//      resent progrm
        $recent_program = Program::where('status', 1)->has('currentProgramPlan')->with('currentProgramPlan')->inRandomOrder()->take(3)->get();

        return view(theme('pages.programs-detail'), get_defined_vars());
    }

}
