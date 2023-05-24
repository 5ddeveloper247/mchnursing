<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\CPD\Repositories\Interfaces\CpdRepositoryInterface;
use Modules\VirtualClass\Entities\VirtualClass;

class MyCoursesPageSection extends Component
{
    public $request;
    private $cpdRepository;

    public function __construct(
        $request
    )
    {
        $this->request = $request;
    }


    public function render()
    {
        if (routeIs('myClasses')) {
            $type = 3;
        } elseif (routeIs('myQuizzes')) {
            $type = 2;
        } elseif (routeIs('myCourses')) {
            $type = 'program';
        } else {
            $type = 4;
        }
        $per_page = 15;
        if ($type == 'program') {
            $programs = CourseEnrolled::where('user_id', Auth::user()->id)
                ->has('program')->with('program', 'plan')->whereNotNull('plan_id')
                ->paginate($per_page);
        } else {

            $with = ['course', 'course.activeReviews', 'course.courseLevel', 'course.BookmarkUsers', 'course.user', 'course.reviews', 'course.enrollUsers'];

            if ($type == 1) {
                $with[] = 'course.completeLessons';
                $with[] = 'course.lessons';
            } elseif ($type == 2) {
                $with[] = 'course.quiz';
                $with[] = 'course.quiz.assign';
            } elseif ($type == 3) {
                $with[] = 'program.programPlans';
                $with[] = 'program.currentProgramPlan';
                if (isModuleActive('BBB')) {
                    $with[] = 'course.class.bbbMeetings';
                }
                if (isModuleActive('Jisti')) {
                    $with[] = 'course.class.jitsiMeetings';
                }
            }

            if ($this->request->category) {

                $category_id = $this->request->category;
                $courses = CourseEnrolled::where('user_id', Auth::user()->id);
                if ($type == 3) {
                    $courses = $courses->whereNotNull('program_id')->whereNull('course_id')->with($with)->get();
                } else {
                    $courses = $courses->whereHas('course', function ($query) use ($category_id, $type) {
                        if($type == 2){
                            $query->whereIn('type', [$type,1,7]);
                        }else{
                            $query->where('type', '=', $type);
                        }

                        $query->where('category_id', '=', $category_id);
                        $query->where('status', '=', 1);
                    })->with($with)->paginate($per_page);;
                }


            } else {
                $category_id = '';
                $courses = CourseEnrolled::where('user_id', Auth::user()->id);
                if ($type == 3) {
                    $courses = $courses->whereNotNull('program_id')->whereNull('course_id')->with($with)->get();
                } else {
                    $courses = $courses->whereHas('course', function ($query) use ($category_id, $type) {
                        if($type == 2){
                            $query->whereIn('type', [$type,1,7]);
                        }else{
                            $query->where('type', '=', $type);
                        }
                        $query->where('status', '=', 1);
                    })->with($with)->paginate($per_page);
                }

            }

            if ($this->request->search) {
                $search = $this->request->search;
                $courses = CourseEnrolled::where('user_id', Auth::user()->id);
                if ($type == 3) {
                    $courses = $courses->whereNotNull('program_id')->whereNull('course_id')->with($with)->get();
                } else {
                    $courses = $courses->whereHas('course', function ($query) use ($search, $type) {
                        if($type == 2){
                            $query->whereIn('type', [$type,1]);
                        }else{
                            $query->where('type', '=', $type);
                        }
                        $query->where('title', 'LIKE', '%' . $search . '%');
                        $query->where('status', '=', 1);
                    })->latest()->with($with)->paginate($per_page);
                }


            } else {
                $search = '';
            }

            $totalClasses = [];
            if($type == 3){
                foreach ($courses->unique('program_id') as $course) {
                    $program = $course->program->currentProgramPlan[0] ?? null;
                    foreach ($course->program->allCoursesData as $cours) {
                        $classes = Course::whereHas('class',function ($q) use($cours){
                            $q->where('course_id',$cours->id)->has('zoomMeetings');
                        })->with('class')->where('scope', 1)->get();

                        if (count($classes)) {

                            foreach ($classes as $class) {

                                $class->program_id = $course->program->id;
                                $date = strtotime('next '.strtolower(date('l', strtotime($class->class->start_date))));


                                if(isset($program) && ($program->cdate <= Carbon::now()->format('Y-m-d') && $program->edate >= Carbon::now()->format('Y-m-d'))){
                                    if($class->class->type == '0' && date('Y-m-d',strtotime($class->class->start_date)) >= Carbon::now()->format('Y-m-d')){
                                        $totalClasses[] = $class;

                                    }
                                    if($class->class->type == '1' && date('Y-m-d', $date) >= Carbon::now()->format('Y-m-d')){
                                        $totalClasses[] = $class;

                                    }
                                }
                            }
                        }
                    }
                }
            }

            $categories = Category::where('status', 1)->with('activeSubcategories')->get();
            $data = [];

            if (Settings('frontend_active_theme') == 'wetech') {
            }

            if (isModuleActive('CPD')) {
                $interface = App::make(CpdRepositoryInterface::class);
                $data['cpds'] = $interface->studentCpd(auth()->user()->id);
            }
        }

        return view(theme('components.my-courses-page-section'), get_defined_vars());
    }
}
