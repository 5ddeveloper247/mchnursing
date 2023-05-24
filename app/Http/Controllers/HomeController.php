<?php

namespace App\Http\Controllers;

use App\UserLogin;
use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonPeriod;
use Modules\Setting\Entities\Badge;
use Modules\Setting\Http\Controllers\BadgeController;
use Modules\StudentSetting\Entities\Program;
use Omnipay\MobilPay\Api\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\Payment\Entities\Withdraw;
use Illuminate\Support\Facades\Response;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;

class HomeController extends Controller
{

    public function __construct()
    {

        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        if (Auth::user()->role_id == 1) {
            return redirect()->route('dashboard');
        } else if (Auth::user()->role_id == 2) {
            return redirect()->route('dashboard');
        } else if (Auth::user()->role_id == 3) {
            return redirect()->route('studentDashboard');
        } else {
            return redirect('/');
        }
    }

    //dashboard
    public function dashboard()
    {
        //        dd(Auth::user()->unreadNotifications[0]->data['actionURL'] ?? '');

        try {
            if (Auth::user()->role_id == 3) {
                return redirect()->route('studentDashboard');
            }
            if (isModuleActive('Affiliate') && Auth::user()->role->name == 'Affiliate') {
                return redirect()->route('affiliate.my_affiliate.index');
            }

            $user = Auth::user();
            if ($user->role_id == 1) {


                $recentEnroll = CourseEnrolled::latest()->take(4)->select(
                    'reveune',
                    'course_id',
                    'user_id',
                    'purchase_price'
                )->with('course', 'course.user', 'user')->get();

                $coursesEarnings = CourseEnrolled::select(
                    DB::raw('Month(created_at) as month_number'),
                    DB::raw('DATE_FORMAT(created_at , "%b") as month'),
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('ROUND(sum(purchase_price - reveune),2) as earning')
                )
                    ->groupBy('month_number', 'year', 'month')
                    ->whereYear('created_at', Carbon::now()->year)
                    ->get();

                $courses_enrolle = CourseEnrolled::select(
                    DB::raw('MONTHNAME(created_at) as month'),
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('DAY(created_at) as day'),
                    DB::raw('count(*) as count')
                )->groupBy('year', 'month', 'day')->get();
            } else {
                $recentEnroll = CourseEnrolled::latest()->take(4)->select(
                    'reveune',
                    'course_id',
                    'user_id',
                    'purchase_price'
                )->whereHas('course', function ($query) use ($user) {
                    $query->where('user_id', '=', $user->id);
                })->with('course', 'course.user', 'user')->get();

                $coursesEarnings = CourseEnrolled::select(
                    DB::raw('Month(created_at) as month_number'),
                    DB::raw('DATE_FORMAT(created_at , "%b") as month'),
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('ROUND(sum(purchase_price - reveune),2) as earning')
                )
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->groupBy('month_number', 'year', 'month')
                    ->whereYear('created_at', Carbon::now()->year)
                    ->get();

                $courses_enrolle = CourseEnrolled::select(
                    DB::raw('MONTHNAME(created_at) as month'),
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('DAY(created_at) as day'),
                    DB::raw('count(*) as count')
                )
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->groupBy('year', 'month', 'day')->get();
            }

            $courshEarningM_onth_name = [];
            foreach ($coursesEarnings as $key => $earning) {
                $courshEarningM_onth_name[] = $earning->month;
            }
            $courshEarningMonthly = [];
            foreach ($coursesEarnings as $key => $earn) {
                $courshEarningMonthly[] = $earn->earning;
            }
            // return $coursesEarnings;
            //====================================Payment Statistics====================================


            $withdraws_query = Withdraw::selectRaw('monthname(issueDate) as month')
                ->selectRaw('YEAR(issueDate) as year')
                ->select('status')
                ->whereYear('issueDate', '=', date('Y'))
                ->whereMonth('issueDate', '=', date('m'));


            if ($user->role_id != 1) {
                $withdraws_query->where('instructor_id', $user->id);
            }
            $withdraws = $withdraws_query->get();
            $withdraws_paid = $withdraws->where('status', '=', 1);
            $withdraws_unpaid = $withdraws->where('status', '=', 0);


            $payment_statistics['paid'] = $withdraws_paid;
            $payment_statistics['unpaid'] = $withdraws_unpaid;
            $payment_statistics['month'] = Carbon::now()->format('F');

            //============================Course Overview===============================
            $allCourses = Course::with('user', 'enrolls')->get();
            $allProgram = Program::with('user')->get();
            $enable_courses = $allProgram->where('status', 1)->count();
            $disable_courses = $allProgram->where('status', 0)->count();

            $courses = $allCourses->where('type', 1)->count();
            $quizzes = $allCourses->where('type', 2)->count();
            $classes = $allCourses->where('type', 3)->count();

            $course_overview['active'] = $enable_courses;
            $course_overview['pending'] = $disable_courses;
            $course_overview['programs'] = $allProgram->count();
            $course_overview['courses'] = $courses;
            $course_overview['quizzes'] = $quizzes;
            $course_overview['classes'] = $classes;

            //====================================Course Enroll===================================
            $enrolls = [];

            foreach ($courses_enrolle as $course) {
                if (date('Y') == $course->year && date('F') == $course->month)
                    $enrolls[] = $course;
            }
            $enroll_day = [];
            foreach ($enrolls as $key => $enroll) {
                $enroll_day[] = $enroll->day;
            }
            $enroll_count = [];
            foreach ($enrolls as $key => $enroll) {
                $enroll_count[] = $enroll->count;
            }

            $students = null;
            if (isModuleActive('CPD')) {
                $students = User::with('cpds')->where('role_id', 3)->get();
            }

            ///test start


            //test end
            $badges = [];

            if (Settings('gamification_status') && Settings('gamification_leaderboard_show_badges_status')) {
                $badgeController = new BadgeController();
                $types = array_keys($badgeController->badgesTypes());
                $myBadgesIds = Auth::user()->userLatestBadges->pluck('badge_id')->toArray();
                $notForStudent = [
                    'blogs',
                    'sales',
                    'rating',
                    'registration'
                ];
                $reg_badges = Badge::select('id', 'point')->where('type', 'registration')->where(function ($query) {
                    $totalDay = 0;
                    if (Auth::check()) {
                        $created = new \Illuminate\Support\Carbon(Auth::user()->created_at);
                        $now = Carbon::now();
                        $totalDay = $now->diffInDays($created);
                    }
                    $query->where('point', '<=', $totalDay);
                })->orderBy('point', 'asc')->get()->pluck('id')->toArray();
                $myBadgesIds = array_merge($myBadgesIds, $reg_badges);
                $badges = Badge::select('title', 'image', 'type', 'point')
                    ->where('status', 1)
                    ->whereIn('type', $types)->where('status', 1)
                    ->whereNotIn('id', $myBadgesIds)
                    ->orderBy('point', 'asc')
                    ->whereIn('type', $notForStudent)
                    ->groupBy('type')
                    ->get();
            }


            return view('dashboard', compact('badges', 'recentEnroll', 'courshEarningM_onth_name', 'courshEarningMonthly', 'payment_statistics', 'enroll_day', 'enroll_count', 'course_overview', 'allCourses', 'students'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function userLoginChartByDays(\Illuminate\Http\Request $request)
    {
        $userLoginChartByDays = [];
        $type = $request->type;
        $days = $request->days;

        if ($type == "days") {

            $from = Carbon::now()->subDays($days - 1);
            $to = Carbon::now();
        } else {
            $allDays = explode(' - ', $days);
            $from = Carbon::parse($allDays[0]);
            $to = Carbon::parse($allDays[1]);
        }


        $period = CarbonPeriod::create($from, $to);
        $dates = [];
        $data = [];

        foreach ($period as $key => $value) {
            $day = $value->format('Y-m-d');
            $dates[] = $day;
            $data[] = UserLogin::whereDate('login_at', $day)->count();
        }
        $userLoginChartByDays['date'] = $dates;
        $userLoginChartByDays['data'] = $data;

        return $userLoginChartByDays;
    }

    public function userLoginChartByTime(\Illuminate\Http\Request $request)
    {
        $userLoginChartByDays = [];
        $type = $request->type;
        $days = $request->days;

        if ($type == "days") {

            $from = Carbon::now()->subDays($days - 1);
            $to = Carbon::now();
        } else {
            $allDays = explode(' - ', $days);
            $from = Carbon::parse($allDays[0]);
            $to = Carbon::parse($allDays[1]);
        }


        $period = CarbonPeriod::create($from, $to);
        $hours = [];

        foreach ($period as $key => $value) {
            $day = $value->format('Y-m-d');


            $loginData = UserLogin::whereDate('login_at', $day)->get(['id', 'login_at'])->groupBy(function ($date) {
                return Carbon::parse($date->login_at)->format('H');
            });

            for ($i = 0; $i <= 23; $i++) {
                if (!isset($hours[$i])) {
                    $hours[$i] = 0;
                }
                if (!isset($loginData[$i])) {
                    $loginData[$i] = [];
                }
                $hours[$i] = count($loginData[$i]) + $hours[$i];
            }
        }
        return $hours;
    }

    public function getDashboardData()
    {
        try {
            $user = Auth::user();

            if ($user->role_id == 2) {
                //                $allCourseEnrolled = CourseEnrolled::with('user', 'course')
                //                    ->whereHas('course', function ($query) use ($user) {
                //                        $query->where('user_id', '=', $user->id);
                //                    })->get();
                $query = CourseEnrolled::where('course_id', null)->with('user')
                    ->whereHas('program', function ($query) {
                    });
                $courses = Course::where('user_id', Auth::id())->where('type', 1)->pluck('id');
                $programs = Program::query();
                foreach ($courses as $course) {
                    $programs =  $programs->orWhere('allcourses', 'like', '%,"' . $course . '",%');
                }
                $programs =  $programs->pluck('id');
                $query = $query->whereIn('program_id', $programs->unique())->groupBy('program_id')->groupBy('user_id')->pluck('user_id')->toArray();

                $allCourseEnrolled = User::with('sender')->where('id', '!=', Auth::id())->whereIn('id', $query)->get();


                $allCourses = Course::where('user_id', $user->id)->whereIn('type', [1, 2])->get();

                $thisMonthEnroll = CourseEnrolled::where('course_id', null)
                    ->whereHas('user', function ($q) use ($query) {
                        $q->where('id', '!=', Auth::id())->whereIn('id', $query);
                    })->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->format('m'))->groupBy('program_id')->groupBy('user_id')->get();

                //                $thisMonthEnroll = CourseEnrolled::whereYear('created_at', Carbon::now()->year)
                //                    ->whereMonth('created_at', Carbon::now()->format('m'))
                //                    ->whereHas('course', function ($query) use ($user) {
                //                        $query->where('user_id', '=', $user->id);
                //                    })->sum('purchase_price');

                $today = CourseEnrolled::where('course_id', null)
                    ->whereHas('user', function ($q) use ($query) {
                        $q->where('id', '!=', Auth::id())->whereIn('id', $query);
                    })->whereDate('created_at', Carbon::today())->groupBy('program_id')->groupBy('user_id')->get();
                //                $today = CourseEnrolled::whereDate('created_at', Carbon::today())
                //                    ->whereHas('course', function ($query) use ($user) {
                //                        $query->where('user_id', '=', $user->id);
                //                    })->sum('purchase_price');

                $month = CourseEnrolled::select(
                    DB::raw('sum(purchase_price) as totalSell'),
                    DB::raw("DATE_FORMAT(created_at,'%m') as months")
                )->whereHas('course', function ($query) use ($user) {
                    $query->where('user_id', '=', $user->id);
                })->groupBy('months')->get();
                $rev = $allCourseEnrolled->sum('reveune');


                $info['today'] = $today->count();

                $info['thisMonthEnroll'] = $thisMonthEnroll->count();
            } else {
                $allCourseEnrolled = CourseEnrolled::all();
                $allCourses = Course::where('type',1);
                $thisMonthEnroll = CourseEnrolled::whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->format('m'))
                    ->sum('purchase_price');
                $today = CourseEnrolled::whereDate('created_at', Carbon::today())->sum('purchase_price');
                $month = CourseEnrolled::select(
                    DB::raw('sum(purchase_price) as totalSell'),
                    DB::raw("DATE_FORMAT(created_at,'%m') as months")
                )->groupBy('months')->get();
                $rev = $allCourseEnrolled->sum('purchase_price') - $allCourseEnrolled->sum('reveune');

                $info['today'] = $today;
                $info['today'] = number_format($info['today'], 2, '.', '');
                $info['thisMonthEnroll'] = $thisMonthEnroll;
                $info['thisMonthEnroll'] = number_format($info['thisMonthEnroll'], 2, '.', '');
            }

            $info['allCourse'] = $allCourses->count();
            $info['totalEnroll'] = $allCourseEnrolled->count();



            $info['student'] = User::where('role_id', 3)->count();
            $info['instructor'] = User::where('role_id', 2)->count();
            $info['totalSell'] = $allCourseEnrolled->sum('purchase_price');
            $info['totalSell'] = number_format($info['totalSell'], 2, '.', '');

            $info['adminRev'] = number_format($rev, 2, '.', '');


            $info['month'] = $month;
            return Response::json($info);
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function validateGenerate()
    {
        return view('validate_generate');
    }


    public function validateGenerateSubmit()
    {
        $field = request()->field;
        $rules = request()->rules;
        $arr = [];


        $single_rule = explode('|', $rules);


        foreach ($single_rule as $rule) {
            $string = explode(':', $rule);
            $rule_name = $rule_message_key = $string[0];

            if (in_array($rule_name, ['max', 'min'])) {
                $rule_message_key = $rule_message_key . '.string';
            }

            $message = __('validation.' . $rule_message_key);

            $field_string = str_replace('_', ' ', $field);

            $message = str_replace(
                [':attribute', ':ATTRIBUTE', ':Attribute'],
                [$field_string, \Illuminate\Support\Str::upper($field_string), \Illuminate\Support\Str::ucfirst($field_string)],
                $message
            );
            if (in_array($rule_name, ['max', 'min'])) {
                $message = str_replace(
                    [':' . $rule_name],
                    [$string[1]],
                    $message
                );
            }

            if ($rule_name == 'required_if') {
                $ex = explode(',', $string[1]);
                $message = str_replace(
                    [':other'],
                    [str_replace('_', ' ', $ex[0])],
                    $message
                );
                if (isset($ex[2])) {
                    $message = str_replace(
                        [':value', "'"],
                        [str_replace('_', ' ', $ex[2]), ''],
                        $message
                    );
                } else {
                    $message = str_replace(
                        [':value', "'"],
                        [str_replace('_', ' ', $ex[1]), ''],
                        $message
                    );
                }
            }

            if ($rule_name == 'mimes') {

                $message = str_replace(
                    [':values'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }
            if ($rule_name == 'same') {

                $message = str_replace(
                    [':other'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }
            if ($rule_name == 'required_with') {

                $message = str_replace(
                    [':values'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }

            if ($rule_name == 'after_or_equal') {

                $message = str_replace(
                    [':date'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }
            if ($rule_name == 'after') {

                $message = str_replace(
                    [':date'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }


            $arr[$field . '.' . $rule_name] = $message;
        }

        $defaultFile = public_path('/../resources/lang/default/validation.php');
        $languages = include "{$defaultFile}";
        $languages = array_merge($languages, $arr);
        file_put_contents($defaultFile, '');
        file_put_contents($defaultFile, '<?php return ' . var_export($languages, true) . ';');

        return view('validate_generate', compact('field', 'rules', 'arr'));
    }
}
