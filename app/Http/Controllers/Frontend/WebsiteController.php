<?php

namespace App\Http\Controllers\Frontend;

use App\AboutPage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Jobs\SendGeneralEmail;
use App\LessonComplete;
use App\Subscription;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use DrewM\MailChimp\MailChimp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Modules\BundleSubscription\Entities\BundleCoursePlan;
use Modules\Calendar\Entities\Calendar;
use Modules\Certificate\Entities\Certificate;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\Certificate\Http\Controllers\CertificateController;
use Modules\CourseSetting\Entities\Chapter;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\CourseSetting\Entities\CourseLevel;
use Modules\CourseSetting\Entities\Lesson;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\FrontendManage\Entities\PrivacyPolicy;
use Modules\Localization\Entities\Language;
use Modules\MyClass\Repositories\Interfaces\AddStudentToClassRepositoryInterface;
use Modules\Newsletter\Entities\NewsletterSetting;
use Modules\Newsletter\Http\Controllers\AcelleController;
use Modules\Payment\Entities\Cart;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\Quiz\Entities\QuestionBankMuOption;
use Modules\Quiz\Entities\QuizeSetup;
use Modules\Quiz\Entities\QuizTest;
use Modules\StudentSetting\Entities\Program;
use Modules\Subscription\Http\Controllers\CourseSubscriptionController;
use Modules\VirtualClass\Entities\VirtualClass;
use PDF;

class WebsiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenanceMode');
    }


    public function aboutData()
    {
        try {
            if (hasDynamicPage()) {
                $row = FrontPage::where('slug', '/about-us')->first();
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                $about = AboutPage::first();
                return view(theme('pages.about'), compact('about'));
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function ajaxCounterCity(Request $request)
    {
        try {
            $cities = DB::table('spn_cities')->select('id', 'name')->where('name', 'like', '%' . $request->search . '%')->where('state_id', '=', $request->id)->paginate(10);

            $response = [];
            foreach ($cities as $item) {
                $response[] = [
                    'id' => $item->id,
                    'text' => $item->name
                ];
            }
            if (count($response) == 0) {
                $data['pagination'] = ["more" => false];
            } else {
                $data['pagination'] = ["more" => true];
            }
            $data['results'] = $response;
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json("", 404);
        }
    }

    public function ajaxCounterState(Request $request)
    {
        try {
            $states = DB::table('states')->select('id', 'name')->where('name', 'like', '%' . $request->search . '%')->where('country_id', '=', $request->id)->paginate(10);

            $response = [];
            foreach ($states as $item) {
                $response[] = [
                    'id' => $item->id,
                    'text' => $item->name
                ];
            }
            $data['results'] = $response;
            if (count($response) == 0) {
                $data['pagination'] = ["more" => false];
            } else {
                $data['pagination'] = ["more" => true];
            }
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json("", 404);
        }
    }

    public function searchCertificate(Request $request)
    {

        try {
            if (hasDynamicPage()) {
                $row = FrontPage::where('slug', 'certificate-verification')->first();
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                return view(theme('pages.searchCertificate'));
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function showCertificate(Request $request)
    {
        try {
            $certificate_record = CertificateRecord::where('certificate_id', $request->certificate_number)->first();
            if ($certificate_record) {
                $course = Course::findOrFail($certificate_record->course_id);

                if ($course->certificate_id != null) {
                    $certificate = Certificate::findOrFail($course->certificate_id);
                } else {
                    if ($course->type == 1) {
                        $certificate = Certificate::where('for_course', 1)->first();
                    } else {
                        $certificate = Certificate::where('for_quiz', 1)->first();
                    }
                }

                if (!$certificate) {
                    Toastr::error(trans('certificate.Certificate Not Found'));
                    return back();
                }


                $title = $certificate_record->certificate_id . ".jpg";

                $downloadFile = new CertificateController();

                $request->certificate_id = $certificate_record->certificate_id;
                $request->course = $course;
                $request->user = User::find($certificate_record->student_id);
                $certificate = $downloadFile->makeCertificate($certificate->id, $request)['image'] ?? '';
                $certificate->encode('jpg');

                $type = 'png';
                $certificate = 'data:image/' . $type . ';base64,' . base64_encode($certificate);

                return view(theme('pages.searchCertificate'), compact('certificate'));
            } else {
                return Redirect::back()->withErrors(['msg', 'Invalid Certificate Number']);
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function generateUniqueCode()
    {
        do {
            $referal_code = random_int(100000, 999999);
        } while (CertificateRecord::where("certificate_id", "=", $referal_code)->first());

        return $referal_code;
    }

    public function certificateCheck($certificate_number, Request $request)
    {
        try {
            $certificate_record = CertificateRecord::where('certificate_id', $certificate_number)->first();
            $course = Course::findOrFail($certificate_record->course_id);
            if ($course->certificate_id != null) {
                $certificate = Certificate::findOrFail($course->certificate_id);
            } else {
                if ($course->type == 1) {
                    $certificate = Certificate::where('for_course', 1)->first();
                } else {
                    $certificate = Certificate::where('for_quiz', 1)->first();
                }
            }
            if (!$certificate) {
                Toastr::error(trans('certificate.Right Now You Cannot Download The Certificate'));
                return back();
            }


            $title = $certificate_number . ".jpg";

            $downloadFile = new CertificateController();

            $request->certificate_id = $certificate_record->certificate_id;
            $request->course = $course;
            $request->completed_at = $certificate_record->created_at;
            $request->user = User::find($certificate_record->student_id);
            $certificate = $downloadFile->makeCertificate($certificate->id, $request)['image'] ?? '';
            $certificate->encode('png');
            $type = 'png';
            $certificate = 'data:image/' . $type . ';base64,' . base64_encode($certificate);

            if ($certificate == null) {
                Toastr::error('Invalid Certificate Number !', 'Failed');
                return redirect()->back();
            }
            return view(theme('pages.searchCertificate'), compact('certificate'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function certificateDownload($certificate_number, Request $request)
    {
        try {
            $certificate_record = CertificateRecord::where('certificate_id', $certificate_number)->first();
            $course = Course::findOrFail($certificate_record->course_id);

            if ($course->certificate_id != null) {
                $certificate = Certificate::findOrFail($course->certificate_id);
            } else {
                if ($course->type == 1) {
                    $certificate = Certificate::where('for_course', 1)->first();
                } else {
                    $certificate = Certificate::where('for_quiz', 1)->first();
                }
            }

            if (!$certificate) {
                Toastr::error(trans('certificate.Right Now You Cannot Download The Certificate'));
                return back();
            }


            $title = $certificate_number . ".jpg";

            $downloadFile = new CertificateController();

            $request->certificate_id = $certificate_record->certificate_id;
            $request->course = $course;
            $request->user = User::find($certificate_record->student_id);
            $certificate = $downloadFile->makeCertificate($certificate->id, $request)['image'] ?? '';

            $certificate->encode('jpg');
            $headers = [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename=' . $title,
            ];
            return response()->stream(function () use ($certificate) {
                echo $certificate;
            }, 200, $headers);
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function privacy()
    {
        try {
            if (hasDynamicPage()) {
                $row = FrontPage::where('slug', '/privacy')->first();
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                $privacy_policy = PrivacyPolicy::getData();
                return view(theme('pages.privacy'), compact('privacy_policy'));
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function fullScreenView(Request $request, $course_id, $lesson_id)
    {

        try {
            $isEnrolled = true;
            if ($request->has('program_id')) {
                $isEnrolled = CourseEnrolled::where('program_id', $request->program_id)->where('user_id', Auth::id())->count();
                if ($isEnrolled == 0) {
                    Toastr::error(trans('common.Access Denied'), trans('common.Failed'));
                    return redirect()->back();
                }
            } else if ($request->has('courseType')) {
                $isEnrolled = CourseEnrolled::where('course_id', $course_id)->where('course_type', $request->courseType)->where('user_id', Auth::id())->count();
                if ($isEnrolled == 0) {
                    Toastr::error(trans('common.Access Denied'), trans('common.Failed'));
                    return redirect()->back();
                }
            } else {
                Toastr::error(trans('common.Access Denied'), trans('common.Failed'));
                return redirect()->back();
            }

            //            updateEnrolledCourseLastView($course_id);

            //            if (isModuleActive('OrgSubscription') && Auth::check()) {
            //                if (!orgSubscriptionCourseValidity($course_id)) {
            //                    Toastr::warning(trans('org-subscription.Your Subscription Expire'));
            //                    return redirect()->back();
            //                }
            //            }
            //            if (isModuleActive('OrgSubscription') && Auth::check()) {
            //                if (!orgSubscriptionCourseSequence($course_id)) {
            //                    Toastr::warning(trans('org-subscription.You Can Not Continue This . Pls Complete Previous Course'));
            //                    return redirect()->back();
            //                }
            //            }
            //            if (isModuleActive('BundleSubscription')) {
            //                if (isBundleExpire($course_id)) {
            //                    Toastr::error('Your bundle validity expired', 'Access Denied');
            //                    return redirect()->back();
            //                }
            //            }

            $result = [];
            $preResult = [];

            $alreadyJoin = 0;
            if (isset($request->quiz_result_id)) {
                $quizTest = QuizTest::findOrFail($request->quiz_result_id);

                if (Auth::check()) {
                    $user = Auth::user();
                    $all = QuizTest::with('details')->where('quiz_id', $quizTest->quiz_id)->where('course_id', $course_id)->where('user_id', $user->id)->get();
                } else {
                    Toastr::error('You must login for continue', 'Failed');
                    return redirect()->back();
                }

                if (count($all) != 0) {
                    $alreadyJoin = 1;
                }

                foreach ($all as $key => $i) {
                    $onlineQuiz = OnlineQuiz::find($i->quiz_id);
                    $date = showDate($i->created_at);
                    $totalQus = totalQuizQus($i->quiz_id);
                    $totalAns = count($i->details);
                    $totalCorrect = 0;
                    $totalScore = totalQuizMarks($i->quiz_id);
                    $score = 0;
                    if ($totalAns != 0) {
                        foreach ($i->details as $test) {
                            if ($test->status == 1) {
                                $score += $test->mark ?? 1;
                                $totalCorrect++;
                            }
                        }
                    }

                    if ($request->quiz_result_id == $i->id) {

                        $result['start_at'] = $i->start_at;
                        $result['end_at'] = $i->end_at;
                        $result['publish'] = $i->publish;
                        $result['duration'] = $i->duration;
                        $result['totalQus'] = $totalQus;
                        $result['totalAns'] = $totalAns;
                        $result['totalCorrect'] = $totalCorrect;
                        $result['totalWrong'] = $totalAns - $totalCorrect;
                        $result['score'] = $score;
                        $result['totalScore'] = $totalScore;
                        $result['passMark'] = $onlineQuiz->percentage ?? 0;
                        $result['mark'] = $score > 0 ? round($score / $totalScore * 100) : 0;;
                        $result['status'] = $result['mark'] >= $result['passMark'] ? "Passed" : "Failed";
                        $result['text_color'] = $result['mark'] >= $result['passMark'] ? "success_text" : "error_text";
                        $i->pass = $result['mark'] >= $result['passMark'] ? "1" : "0";
                        $i->save();
                    } else {
                        $preResult[$key]['quiz_test_id'] = $i->id;
                        $preResult[$key]['totalQus'] = $totalQus;
                        $preResult[$key]['date'] = $date;
                        $preResult[$key]['totalAns'] = $totalAns;
                        $preResult[$key]['totalCorrect'] = $totalCorrect;
                        $preResult[$key]['totalWrong'] = $totalAns - $totalCorrect;
                        $preResult[$key]['score'] = $score;
                        $preResult[$key]['totalScore'] = $totalScore;
                        $preResult[$key]['passMark'] = $onlineQuiz->percentage ?? 0;
                        $preResult[$key]['mark'] = $score > 0 ? round($score / $totalScore * 100) : 0;;
                        $preResult[$key]['status'] = $preResult[$key]['mark'] >= $preResult[$key]['passMark'] ? "Passed" : "Failed";
                        $preResult[$key]['text_color'] = $preResult[$key]['mark'] >= $preResult[$key]['passMark'] ? "success_text" : "error_text";
                        $i->pass = $preResult[$key]['mark'] >= $preResult[$key]['passMark'] ? "1" : "0";
                        $i->save();
                    }

                    $check = Lesson::where('course_id', $i->course_id)->where('quiz_id', $i->quiz_id)->first();
                    if ($check && $i->pass == 1) {
                        $lesson = LessonComplete::where('course_id', $i->course_id)->where('lesson_id', $check->id)->where('user_id', Auth::id())->first();
                        if (!$lesson) {
                            checkGamification('each_unit_complete', 'learning');
                            $lesson = new LessonComplete();
                            $lesson->user_id = Auth::id();
                            $lesson->course_id = $i->course_id;
                            $lesson->lesson_id = $check->id;
                        }
                        $lesson->status = 1;
                        $lesson->save();
                    }
                }
            }

            $course = Course::findOrFail($course_id);
            $lesson = Lesson::where('id', $lesson_id)->first();

            if (!$lesson) {
                abort('404');
            }


            //$lesson->is_lock;
            //            $isEnrolled = false;
            //
            //            if ($lesson->is_lock == 1) {
            //                if (!Auth::check()) {
            //                    Toastr::error('You are not enrolled for this course !', 'Failed');
            //                    return redirect()->back();
            //                } else {
            //
            //                    if ($course->isLoginUserEnrolled) {
            //                        Toastr::error('You are not enrolled for this course !', 'Failed');
            //                        return redirect()->back();
            //                    } else {
            //                        $isEnrolled = true;
            //                    }
            //                }
            //            } else {
            //                $isEnrolled = true;
            //            }$isEnrolled = false;
            //
            //            if ($lesson->is_lock == 1) {
            //                if (!Auth::check()) {
            //                    Toastr::error('You are not enrolled for this course !', 'Failed');
            //                    return redirect()->back();
            //                } else {
            //
            //                    if ($course->isLoginUserEnrolled) {
            //                        Toastr::error('You are not enrolled for this course !', 'Failed');
            //                        return redirect()->back();
            //                    } else {
            //                        $isEnrolled = true;
            //                    }
            //                }
            //            } else {
            //                $isEnrolled = true;
            //            }
            $certificate = $course->certificate;

            if (!$certificate) {
                if ($course->type == 1) {
                    $certificate = Certificate::where('for_course', 1)->first();
                } else {
                    $certificate = Certificate::where('for_quiz', 1)->first();
                }
            }


            //drop content  start

            $today = Carbon::now()->toDateString();
            $showDrip = Settings('show_drip') ?? 0;
            $all = Lesson::where('course_id', $course->id)->with('completed')->orderBy('position', 'asc')->get();;

            $lessons = [];
            if ($course->drip == 1) {
                if ($showDrip == 1) {
                    foreach ($all as $key => $data) {
                        $show = false;
                        $unlock_date = $data->unlock_date;
                        $unlock_days = $data->unlock_days;

                        if (!empty($unlock_days) || !empty($unlock_date)) {

                            if (!empty($unlock_date)) {
                                if (strtotime($unlock_date) == strtotime($today)) {
                                    $show = true;
                                }
                            }
                            if (!empty($unlock_days)) {
                                if (Auth::check()) {
                                    $enrolled = DB::table('course_enrolleds')->where('user_id', Auth::user()->id)->where('course_id', $course->id)->where('status', 1)->first();
                                    if (!empty($enrolled)) {
                                        $unlock = Carbon::parse($enrolled->created_at);
                                        $unlock->addDays($data->unlock_days);
                                        $unlock = $unlock->toDateString();

                                        if (strtotime($unlock) <= strtotime($today)) {
                                            $show = true;
                                        }
                                    }
                                }
                            }

                            if ($show) {
                                $lessons[] = $data;
                            }
                        } else {
                            $lessons[] = $data;
                        }
                    }
                } else {
                    $lessons = $all;
                }
            } else {
                $lessons = $all;
            }

            $total = count($lessons);
            // drop content end

            if ($course->drip != 0) {
                $lessonShow = false;
                $unlock_lesson_date = $lesson->unlock_date;
                $unlock_lesson_days = $lesson->unlock_days;
                if (!empty($unlock_lesson_days) || !empty($unlock_lesson_date)) {
                    if (!empty($unlock_lesson_date)) {
                        if (strtotime($unlock_lesson_date) == strtotime($today)) {
                            $lessonShow = true;
                        }
                    }

                    if (!empty($unlock_lesson_days)) {
                        if (!Auth::check()) {
                            $lessonShow = false;
                        } else {
                            $enrolled = DB::table('course_enrolleds')->where('user_id', Auth::user()->id)->where('course_id', $course_id)->where('status', 1)->first();
                            if (!empty($enrolled)) {
                                $unlock_lesson = Carbon::parse($enrolled->created_at);
                                $unlock_lesson->addDays($lesson->unlock_days);
                                $unlock_lesson = $unlock_lesson->toDateString();

                                if (strtotime($unlock_lesson) <= strtotime($today)) {
                                    $lessonShow = true;
                                }
                            }
                        }
                    }
                } else {
                    $lessonShow = true;
                }
                if (Auth::check() && Auth::user()->role_id == 1) {
                    $lessonShow = true;
                }

                if (!$lessonShow) {
                    Toastr::error('Lesson currently unavailable!', 'Failed');
                    return redirect()->back();
                }
            }


            $percentage = round($course->loginUserTotalPercentage);

            $course_reviews = DB::table('course_reveiws')->select('user_id')->where('course_id', $course->id)->get();

            $reviewer_user_ids = [];
            foreach ($course_reviews as $key => $review) {
                $reviewer_user_ids[] = $review->user_id;
            }
            $chapters = Chapter::where('course_id', $course->id)->orderBy('position', 'asc')->get();
            $quizSetup = QuizeSetup::getData();

            if ($lesson->host == "VdoCipher") {
                $otp = $this->getOTPForVdoCipher($lesson->video_url);
                $lesson->otp = $otp['otp'];
                $lesson->playbackInfo = $otp['playbackInfo'];
            }


            $isAdmin = false;
            if (Auth::check()) {
                if (Auth::user()->role_id == 1) {
                    $isAdmin = true;
                }
            }
            $lesson_ids = [];

            foreach ($chapters as $c) {
                foreach ($all as $item) {
                    if ($c->id == $item->chapter_id) {
                        $lesson_ids[] = $item->id;
                    }
                }
            }
            if (!$isAdmin) {
                if ($course->complete_order == 1) {
                    if (!Auth::check()) {
                        Toastr::error('You must login for continue', 'Failed');
                        return redirect()->back();
                    }

                    $index = array_search($lesson_id, $lesson_ids);


                    $previous = $lesson_ids[$index - 1] ?? null;

                    //                    if ($previous) {
                    //                        $isComplete = DB::table('lesson_completes')->where('lesson_id', $previous)->where('user_id', Auth::user()->id)->select('status')->first();
                    //
                    //                        if (!$isComplete || $isComplete->status != 1) {
                    //                            Toastr::error(trans('frontend.At First, You need to complete previous lesson'), trans('Failed'));
                    //                            return redirect()->back();
                    //                        }
                    //                    }
                }
            }

            $quizPass = true;
            if (Auth::check()) {
                $hasQuiz = QuizTest::where('course_id', $course->id)->where('user_id', Auth::user()->id)->groupBy('quiz_id')->get();
                $hasPassQuiz = QuizTest::where('course_id', $course->id)->where('user_id', Auth::user()->id)->where('pass', 1)->groupBy('quiz_id')->get();

                if (count($hasQuiz) != count($hasPassQuiz)) {
                    $quizPass = false;
                }
            }

            if (isModuleActive('Org')) {
                if (!empty($lesson->org_material_id)) {
                    $default = $lesson->orgMaterial->default;
                    $lesson->video_url = $default->link;
                    $lesson->host = $default->type;
                }
            }

            return view(theme('pages.fullscreen_video'), compact('quizPass', 'alreadyJoin', 'lesson_ids', 'result', 'preResult', 'quizSetup', 'chapters', 'reviewer_user_ids', 'percentage', 'isEnrolled', 'total', 'certificate', 'course', 'lesson', 'lessons'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function getOTPForVdoCipher($video_id)
    {
        $data['otp'] = '';
        $data['playbackInfo'] = '';

        try {
            $url = "https://dev.vdocipher.com/api/videos/" . $video_id . "/otp";

            $curl = curl_init();
            $header = array(
                "Accept: application/json",
                "Authorization:Apisecret " . saasEnv('VDOCIPHER_API_SECRET'),
                "Content-Type: application/json"
            );

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    "ttl" => 300,
                ]),
                CURLOPT_HTTPHEADER => $header,
            ));

            $response = json_decode(curl_exec($curl));
            $err = curl_error($curl);

            curl_close($curl);

            if (!$err) {
                $data['otp'] = $response->otp;
                $data['playbackInfo'] = $response->playbackInfo;
            }
        } catch (\Exception $e) {
        }
        return $data;
    }


    public function subscribe(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }

        $validate_rules = [
            'email' => 'required|email',
        ];


        $request->validate($validate_rules, validationMessage($validate_rules));


        try {
            if (!hasTable('newsletter_settings')) {

                $check = Subscription::where('email', '=', $request->email)->first();
                if (empty($check)) {
                    $subscribe = new Subscription();
                    $subscribe->email = $request->email;
                    $subscribe->save();

                    Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                } else {
                    Toastr::error('Already subscribe!', 'Failed');
                }
            } else {
                $newsletterSetting = NewsletterSetting::getData();
                if ($newsletterSetting->home_service == "Local") {

                    $check = Subscription::where('email', '=', $request->email)->first();

                    if (empty($check)) {
                        $subscribe = new Subscription();
                        $subscribe->email = $request->email;
                        $subscribe->type = 'Homepage';
                        $subscribe->save();

                        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                    } else {
                        Toastr::error('Already subscribe!', 'Failed');
                    }
                    return Redirect::back();
                } elseif ($newsletterSetting->home_service == "Mailchimp") {
                    if (saasEnv('MailChimp_Status') == "true") {
                        $list = $newsletterSetting->home_list_id;
                        $MailChimp = new MailChimp(saasEnv('MailChimp_API'));
                        $result = $MailChimp->post("lists/$list/members", [
                            'email_address' => $request->email,
                            'status' => 'subscribed',
                        ]);
                        if ($MailChimp->success()) {
                            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                            return Redirect::back();
                        } else {
                            Toastr::error(json_decode($MailChimp->getLastResponse()['body'], TRUE)['title'] ?? 'Something Went Wrong', trans('common.Failed'));
                            return Redirect::back();
                        }
                    }
                } elseif ($newsletterSetting->home_service == "GetResponse") {
                    if (saasEnv('GET_RESPONSE_STATUS') == "true") {
                        $list = $newsletterSetting->home_list_id;
                        $getResponse = new \GetResponse(saasEnv('GET_RESPONSE_API'));

                        $callback = $getResponse->addContact(array(
                            'email' => $request->email,
                            'campaign' => array('campaignId' => $list),

                        ));


                        if (empty($callback)) {
                            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                            return Redirect::back();
                        } else {
                            Toastr::error($callback->message ?? 'Something Went Wrong', trans('common.Failed'));
                            return Redirect::back();
                        }
                    }
                } elseif ($newsletterSetting->home_service == "Acelle") {
                    if (saasEnv('ACELLE_STATUS') == "true") {

                        $list = $newsletterSetting->home_list_id;
                        $email = $request->email;
                        $make_action_url = '/subscribers?list_uid=' . $list . '&EMAIL=' . $email;
                        $acelleController = new AcelleController();
                        $response = $acelleController->curlPostRequest($make_action_url);

                        if ($response) {
                            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                            return Redirect::back();
                        } else {
                            Toastr::error('Something Went Wrong', trans('common.Failed'));
                            return Redirect::back();
                        }
                    }
                }
                Toastr::error('Something went wrong.', trans('common.Failed'));
            }


            return Redirect::back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function myCart()
    {

        $checkout = request()->checkout;
        if ($checkout) {
            if (Auth::check()) {
                return \redirect(route('CheckOut'));
            } else {
                session(['redirectTo' => route('CheckOut')]);
                return \redirect(route('login'));
            }
        }
        try {
            if (Auth::check()) {
                return view(theme('pages.myCart'));
            } else {
                return view(theme('pages.myCart2'));
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function addToCartQuiz(Request $request, $id)
    {
        try {

            $course = Course::where('price', '!=', '0.00');
            if ($request->has('courseType')) {
                $course = $course->where('type', $request->courseType)->where('parent_id', $id)->first();
            } else {
                $course = $course->where('id', $id)->first();
            }

            if (!$course) {
                Toastr::error('Quiz not found OR You or trying to buy 0 cast product', 'Failed');
                return redirect()->back();
            }
            if (isModuleActive('Org')) {
                $type = $course->required_type;
                if ($type == 1) {
                    Toastr::error(trans('org.Unable to add cart'), trans('common.Failed'));
                    return redirect()->back();
                }
            }

            $user = Auth::user();

            if (Auth::check() && ($user->role_id != 1)) {

                $exist = Cart::where('user_id', $user->id);
                if ($request->has('courseType')) {
                    $exist = $exist->where('course_type', $request->courseType);
                }
                $exist = $exist->where('course_id', $id)->first();
                $oldCart = Cart::where('user_id', $user->id)->when(isModuleActive('Appointment'), function ($query) {
                    $query->whereNotNull('course_id');
                })->first();


                if (isset($exist)) {
                    Toastr::error(trans('Quiz already added in your cart'), trans('common.Failed'));

                    return redirect()->back();
                } elseif (Auth::check() && ($user->role_id == 1)) {
                    Toastr::error(trans('frontend.You logged in as admin so can not add cart'), trans('common.Failed'));
                    return redirect()->back();
                } else {

                    if (isset($oldCart)) {


                        $cart = new Cart();
                        $cart->user_id = $user->id;
                        $cart->instructor_id = $course->user_id;
                        $cart->course_id = $id;
                        if ($request->has('courseType')) {
                            $cart->course_type = $request->courseType;
                        }
                        $cart->tracking = $oldCart->tracking;
                        if ($course->discount_price > 0) {
                            $cart->price = $course->discount_price;
                        } else {
                            $cart->price = $course->price;
                        }
                        $cart->save();
                    } else {

                        $cart = new Cart();
                        $cart->user_id = $user->id;
                        $cart->instructor_id = $course->user_id;
                        $cart->course_id = $id;
                        if ($request->has('courseType')) {
                            $cart->course_type = $request->courseType;
                        }
                        $cart->tracking = getTrx();
                        if ($course->discount_price > 0) {
                            $cart->price = $course->discount_price;
                        } else {

                            $cart->price = $course->price;
                        }

                        $cart->save();
                    }

                    //                    if ($cart->price == 0) {
                    //                        $paymentController = new PaymentController();
                    //                        $paymentController->directEnroll($cart->course_id, $cart->tracking);
                    //                    }
                    if ($request->has('courseType')) {
                        if ($request->courseType == 4) {
                            Toastr::success(trans('CNA PREP Added to your cart'), trans('common.Success'));
                        } else {
                            Toastr::success(trans('TEST PREP Added to your cart'), trans('common.Success'));
                        }
                    } else {
                        Toastr::success(trans('Big Quiz Added to your cart'), trans('common.Success'));
                    }
                    return redirect()->back();
                }
            } //If user not logged in then cart added into session
            Toastr::error('You must login', 'Error');
            session(['redirectTo' => route('quizzes')]);
            return \redirect()->route('login');
            //            else {
            //                $price = 0;
            //
            //
            //                if ($course->discount_price > 0) {
            //                    $price = $course->discount_price;
            //                } else {
            //                    $price = $course->price;
            //                }
            //
            //
            //                $cart = session()->get('cart');
            //                if (!$cart) {
            //                    $cart = [
            //                        $id => [
            //                            "id" => $course->id,
            //                            "course_id" => $course->id,
            //                            "instructor_id" => $course->user_id,
            //                            "instructor_name" => $course->user->name,
            //                            "title" => $course->programtitle,
            //                            "image" => $course->image,
            //                            "price" => $price,
            //                        ]
            //                    ];
            //                    session()->put('cart', $cart);
            //                    Toastr::success(trans('Quiz Added to your cart'), trans('common.Success'));
            //                    return redirect()->back();
            //                } elseif (isset($cart[$id])) {
            //                    Toastr::error(trans('Quiz already added in your cart'), trans('common.Failed'));
            //
            //                    return redirect()->back();
            //                } else {
            //
            //                    $cart[$id] = [
            //
            //                        "id" => $course->id,
            //                        "course_id" => $course->id,
            //                        "instructor_id" => $course->user_id,
            //                        "instructor_name" => $course->user->name,
            //                        "title" => $course->programtitle,
            //                        "image" => $course->image,
            //                        "price" => $price,
            //                    ];
            //
            //                    session()->put('cart', $cart);
            //
            //                    Toastr::success(trans('Quiz Added to your cart'), trans('common.Success'));
            //                    return redirect()->back();
            //                }
            //            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function buyNowQuiz(Request $request, $id)
    {

        try {
            if (!Auth::check()) {
                Toastr::error('You must login', 'Error');
                session(['redirectTo' => route('quizzes')]);
                return \redirect()->route('login');
            }
            $course = Course::where('price', '!=', '0.00');
            if ($request->has('courseType')) {
                $course = $course->where('type', $request->courseType)->where('parent_id', $id)->first();
            } else {
                $course = $course->where('id', $id)->first();
            }

            if (!$course) {
                Toastr::error('Quiz not found OR You or trying to buy 0 cast product', 'Failed');
                return redirect()->back();
            }

            //            if ($program->isLoginUserEnrolled) {
            //                Toastr::error(trans('Program already enrolled'), 'Failed');
            //                return redirect()->back();
            //            }
            //            if (isModuleActive('Org')) {
            //                $type = $program->required_type;
            //                if ($type == 1) {
            //                    Toastr::error(trans('org.Unable to add cart'), trans('common.Failed'));
            //                    return redirect()->back();
            //                }
            //            }

            $user = Auth::user();
            if (Auth::check() && ($user->role_id != 1)) {


                $exist = Cart::where('user_id', $user->id);
                if ($request->has('courseType')) {
                    $exist = $exist->where('course_type', $request->courseType);
                }
                $exist = $exist->where('course_id', $id)->first();
                $oldCart = Cart::where('user_id', $user->id)->when(isModuleActive('Appointment'), function ($query) {
                    $query->whereNotNull('program_id');
                })->first();

                if (isset($exist)) {
                    Toastr::error(trans('Quiz already added in your cart'), trans('common.Failed'));

                    return redirect()->route('CheckOut');
                } elseif (Auth::check() && ($user->role_id == 1)) {
                    Toastr::error(trans('frontend.You logged in as admin so can not add cart'), trans('common.Failed'));
                    return redirect()->back();
                } else {


                    if (isset($oldCart)) {
                        echo 'old';
                        $cart = new Cart();
                        $cart->user_id = $user->id;
                        $cart->instructor_id = $course->user_id;
                        $cart->course_id = $id;
                        if ($request->has('courseType')) {
                            $cart->course_type = $request->courseType;
                        }
                        $cart->tracking = $oldCart->tracking;
                        if ($course->discount_price < 0) {
                            $cart->price = $course->discount_price;
                        } else {
                            $cart->price = $course->price;
                        }

                        $cart->save();
                    } else {

                        $cart = new Cart();
                        $cart->user_id = $user->id;
                        $cart->instructor_id = $course->user_id;
                        $cart->course_id = $id;
                        if ($request->has('courseType')) {
                            $cart->course_type = $request->courseType;
                        }
                        $cart->tracking = getTrx();
                        if ($course->discount_price < 0) {
                            $cart->price = $course->discount_price;
                        } else {
                            $cart->price = $course->price;
                        }

                        $cart->save();
                    }
                    //                    if ($cart->price == 0) {
                    //                        $paymentController = new PaymentController();
                    //                        $paymentController->directEnroll($cart->program_id, $cart->tracking);
                    //                    }

                    if ($request->has('courseType')) {
                        if ($request->courseType == 4) {
                            Toastr::success(trans('CNA PREP Added to your cart'), trans('common.Success'));
                        } else {
                            Toastr::success(trans('TEST PREP Added to your cart'), trans('common.Success'));
                        }
                    } else {
                        Toastr::success(trans('Big Quiz Added to your cart'), trans('common.Success'));
                    }
                    return redirect()->route('CheckOut')->with('back', courseDetailsUrl(@$course->id, @$course->type, @$course->slug));
                }
            } //If user not logged in then cart added into session

            //            else {
            //                $price = 0;
            //                if (!$course) {
            //                    Toastr::error('Quiz not found', 'Failed');
            //                    return redirect()->back();
            //                }
            //
            //                if ($course->discount_price > 0) {
            //                    $price = $course->discount_price;
            //                } else {
            //                    $price = $course->price;
            //                }
            //
            //
            //                $cart = session()->get('cart');
            //                if (!$cart) {
            //                    $cart = [
            //                        $id => [
            //                            "id" => $course->id,
            //                            "course_id" => $course->id,
            //                            "instructor_id" => $course->user_id,
            //                            "instructor_name" => $course->user->name,
            //                            "title" => $course->programtitle,
            //                            "image" => $course->image,
            //                            "price" => $price,
            //                        ]
            //                    ];
            //                    session()->put('cart', $cart);
            //                    Toastr::success(trans('Quiz Added to your cart'), trans('common.Success'));
            //                    return redirect()->route('CheckOut');
            //                } elseif (isset($cart[$id])) {
            //                    Toastr::error(trans('frontend.Course already added in your cart'), trans('common.Failed'));
            //                    return redirect()->route('CheckOut');
            //                } else {
            //
            //                    $cart[$id] = [
            //
            //                        "id" => $course->id,
            //                        "course_id" => $course->id,
            //                        "instructor_id" => $course->user_id,
            //                        "instructor_name" => $course->user->name,
            //                        "title" => $course->title,
            //                        "image" => $course->image,
            //                        "price" => $price,
            //                    ];
            //
            //                    session()->put('cart', $cart);
            //
            //                    Toastr::success(trans('frontend.Course Added to your cart'), trans('common.Success'));
            //                    return redirect()->route('CheckOut');
            //                }
            //            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function addToCart(Request $request, $id)
    {
        try {

            $program = Program::where('id', $id)->with(['currentProgramPlan.initialProgramPalnDetail', 'programPlans' => function ($q) use ($request) {
                $q->where('id', $request->plan_id)->with('initialProgramPalnDetail');
            }])->first();
            if (!$program) {
                Toastr::error('Program not found', 'Failed');
                return redirect()->back();
            }
            if (isModuleActive('Org')) {
                $type = $program->required_type;
                if ($type == 1) {
                    Toastr::error(trans('org.Unable to add cart'), trans('common.Failed'));
                    return redirect()->back();
                }
            }

            $user = Auth::user();

            if (Auth::check() && ($user->role_id != 1)) {

                $exist = Cart::where('user_id', $user->id)->where('program_id', $id)->where('plan_id', $request->plan_id)->first();
                $oldCart = Cart::where('user_id', $user->id)->when(isModuleActive('Appointment'), function ($query) {
                    $query->whereNotNull('program_id');
                })->first();


                if (isset($exist)) {
                    Toastr::error(trans('Program already added in your cart'), trans('common.Failed'));

                    return redirect()->back();
                } elseif (Auth::check() && ($user->role_id == 1)) {
                    Toastr::error(trans('frontend.You logged in as admin so can not add cart'), trans('common.Failed'));
                    return redirect()->back();
                } else {

                    if (isset($oldCart)) {


                        $cart = new Cart();
                        $cart->user_id = $user->id;
                        $cart->instructor_id = $program->user_id;
                        $cart->program_id = $id;
                        $cart->plan_id = $request->plan_id;
                        $cart->tracking = $oldCart->tracking;
                        if ($program->discount_price > 0) {
                            $cart->price = $program->discount_price;
                        } else {
                            if (!empty($program->programPlans[0]->initialProgramPalnDetail[0])) {
                                $cart->price = $program->programPlans[0]->initialProgramPalnDetail[0]->amount;
                            } else {
                                $cart->price = $program->programPlans[0]->amount;
                            }
                        }

                        $cart->save();
                    } else {

                        $cart = new Cart();
                        $cart->user_id = $user->id;
                        $cart->instructor_id = $program->user_id;
                        $cart->program_id = $id;
                        $cart->plan_id = $request->plan_id;
                        $cart->tracking = getTrx();
                        if ($program->discount_price > 0) {
                            $cart->price = $program->discount_price;
                        } else {
                            if (!empty($program->programPlans[0]->initialProgramPalnDetail[0])) {
                                $cart->price = $program->programPlans[0]->initialProgramPalnDetail[0]->amount;
                            } else {
                                $cart->price = $program->programPlans[0]->amount;
                            }
                        }

                        $cart->save();
                    }
                    //                    if ($cart->price == 0) {
                    //                        $paymentController = new PaymentController();
                    //                        $paymentController->directEnroll($cart->course_id, $cart->tracking);
                    //                    }

                    Toastr::success(trans('Program Added to your cart'), trans('common.Success'));
                    return redirect()->back();
                }
            } //If user not logged in then cart added into session
            Toastr::error('You must login', 'Error');
            session(['redirectTo' => route('programs.detail', $id)]);
            return \redirect()->route('login');
            //            else {
            //                $price = 0;
            //
            //
            //                if ($program->discount_price > 0) {
            //                    $price = $program->discount_price;
            //                } else {
            //                    if (!empty($program->programPlans[0]->initialProgramPalnDetail[0])) {
            //                        $price = $program->programPlans[0]->initialProgramPalnDetail[0]->amount;
            //                    } else {
            //                        $price = $program->programPlans[0]->amount;
            //                    }
            //                }
            //
            //
            //                $cart = session()->get('cart');
            //                if (!$cart) {
            //                    $cart = [
            //                        $id => [
            //                            "id" => $program->id,
            //                            "program_id" => $program->id,
            //                            "plan_id" => $program->plan_id,
            //                            "instructor_id" => $program->user_id,
            //                            "instructor_name" => $program->user->name,
            //                            "title" => $program->programtitle,
            //                            "image" => $program->image,
            //                            "price" => $price,
            //                        ]
            //                    ];
            //                    session()->put('cart', $cart);
            //                    Toastr::success(trans('Program Added to your cart'), trans('common.Success'));
            //                    return redirect()->back();
            //                } elseif (isset($cart[$id])) {
            //                    Toastr::error(trans('Program already added in your cart'), trans('common.Failed'));
            //
            //                    return redirect()->back();
            //                } else {
            //
            //                    $cart[$id] = [
            //
            //                        "id" => $program->id,
            //                        "program_id" => $program->id,
            //                        "plan_id" => $program->plan_id,
            //                        "instructor_id" => $program->user_id,
            //                        "instructor_name" => $program->user->name,
            //                        "title" => $program->programtitle,
            //                        "image" => $program->image,
            //                        "price" => $price,
            //                    ];
            //
            //                    session()->put('cart', $cart);
            //
            //                    Toastr::success(trans('Program Added to your cart'), trans('common.Success'));
            //                    return redirect()->back();
            //                }
            //            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function buyNow(Request $request, $id)
    {

        try {
            if (!Auth::check()) {
                Toastr::error('You must login', 'Error');
                session(['redirectTo' => route('programs.detail', $id)]);
                return \redirect()->route('login');
            }
            $program = Program::where('id', $id)->with(['currentProgramPlan.initialProgramPalnDetail', 'programPlans' => function ($q) use ($request) {
                $q->where('id', $request->plan_id);
            }])->first();
            if (!$program) {
                Toastr::error('Program not found', 'Failed');
                return redirect()->back();
            }

            //            if ($program->isLoginUserEnrolled) {
            //                Toastr::error(trans('Program already enrolled'), 'Failed');
            //                return redirect()->back();
            //            }
            //            if (isModuleActive('Org')) {
            //                $type = $program->required_type;
            //                if ($type == 1) {
            //                    Toastr::error(trans('org.Unable to add cart'), trans('common.Failed'));
            //                    return redirect()->back();
            //                }
            //            }

            $user = Auth::user();
            if (Auth::check() && ($user->role_id != 1)) {


                $exist = Cart::where('user_id', $user->id)->where('program_id', $id)->where('plan_id', $request->plan_id)->first();
                $oldCart = Cart::where('user_id', $user->id)->when(isModuleActive('Appointment'), function ($query) {
                    $query->whereNotNull('program_id');
                })->first();

                if (isset($exist)) {
                    Toastr::error(trans('Program already added in your cart'), trans('common.Failed'));

                    return redirect()->route('CheckOut');
                } elseif (Auth::check() && ($user->role_id == 1)) {
                    Toastr::error(trans('frontend.You logged in as admin so can not add cart'), trans('common.Failed'));
                    return redirect()->back();
                } else {


                    if (isset($oldCart)) {

                        $cart = new Cart();
                        $cart->user_id = $user->id;
                        $cart->instructor_id = $program->user_id;
                        $cart->program_id = $id;
                        $cart->plan_id = $request->plan_id;
                        $cart->tracking = $oldCart->tracking;
                        if ($program->discount_price < 0) {
                            $cart->price = $program->discount_price;
                        } else {
                            if (!empty($program->programPlans[0]->initialProgramPalnDetail[0])) {
                                $cart->price = $program->programPlans[0]->initialProgramPalnDetail[0]->amount;
                            } else {
                                $cart->price = $program->programPlans[0]->amount;
                            }
                        }

                        $cart->save();
                    } else {

                        $cart = new Cart();
                        $cart->user_id = $user->id;
                        $cart->instructor_id = $program->user_id;
                        $cart->program_id = $id;
                        $cart->plan_id = $request->plan_id;
                        $cart->tracking = getTrx();
                        if ($program->discount_price < 0) {
                            $cart->price = $program->discount_price;
                        } else {
                            if (!empty($program->programPlans[0]->initialProgramPalnDetail[0])) {
                                $cart->price = $program->programPlans[0]->initialProgramPalnDetail[0]->amount;
                            } else {
                                $cart->price = $program->programPlans[0]->amount;
                            }
                        }

                        $cart->save();
                    }
                    if ($cart->price == 0) {
                        $paymentController = new PaymentController();
                        $paymentController->directEnroll($cart->program_id, $cart->tracking);
                    }

                    Toastr::success(trans('Program Added to your cart'), trans('common.Success'));
                    return redirect()->route('CheckOut')->with('back', route('programs.detail', $program->id));
                    //                    return redirect()->route('CheckOut')->with('back', courseDetailsUrl(@$course->id, @$course->type, @$course->slug));
                }
            } //If user not logged in then cart added into session

            else {
                $price = 0;
                if (!$program) {
                    Toastr::error('Program not found', 'Failed');
                    return redirect()->back();
                }

                if ($program->discount_price > 0) {
                    $price = $program->discount_price;
                } else {
                    if (!empty($program->programPlans[0]->initialProgramPalnDetail[0])) {
                        $price->price = $program->programPlans[0]->initialProgramPalnDetail[0]->amount;
                    } else {
                        $price->price = $program->programPlans[0]->amount;
                    }
                }


                $cart = session()->get('cart');
                if (!$cart) {
                    $cart = [
                        $id => [
                            "id" => $program->id,
                            "course_id" => $program->id,
                            "instructor_id" => $program->user_id,
                            "plan_id" => $program->plan_id,
                            "instructor_name" => $program->user->name,
                            "title" => $program->programtitle,
                            "image" => $program->image,
                            "price" => $price,
                        ]
                    ];
                    session()->put('cart', $cart);
                    Toastr::success(trans('frontend.Course Added to your cart'), trans('common.Success'));
                    return redirect()->route('CheckOut');
                } elseif (isset($cart[$id])) {
                    Toastr::error(trans('frontend.Course already added in your cart'), trans('common.Failed'));
                    return redirect()->route('CheckOut');
                } else {

                    $cart[$id] = [

                        "id" => $program->id,
                        "course_id" => $program->id,
                        "instructor_id" => $program->user_id,
                        "plan_id" => $program->plan_id,
                        "instructor_name" => $program->user->name,
                        "title" => $program->title,
                        "image" => $program->image,
                        "price" => $price,
                    ];

                    session()->put('cart', $cart);

                    Toastr::success(trans('frontend.Course Added to your cart'), trans('common.Success'));
                    return redirect()->route('CheckOut');
                }
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function removeItem($id)
    {
        try {
            $success = trans('lang.Cart has been Removed Successfully');
            if (Auth::check()) {

                $item = Cart::find($id);
                if ($item) {
                    $item->delete();
                }
                Toastr::success('Course removed from your cart', 'Success');
                return redirect()->back();
            } else {

                $cart = session()->get('cart');

                if (isset($cart[$id])) {
                    if (count($cart) == 1) {
                        unset($cart[$id]);
                        session()->forget('cart');
                    } else {
                        unset($cart[$id]);
                    }


                    session()->put('cart', $cart);
                    Toastr::success('Course removed from your cart', 'Success');
                    return redirect()->back();
                }
            }
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function removeItemAjax($id)
    {
        try {

            if (Auth::check()) {

                $item = Cart::find($id);

                if ($item) {
                    $item->delete();
                }
                return true;
            } else {

                $cart = session()->get('cart');

                if (isset($cart[$id])) {
                    if (count($cart) == 1) {
                        unset($cart[$id]);
                        session()->forget('cart');
                    } else {
                        unset($cart[$id]);
                    }


                    session()->put('cart', $cart);
                    return true;
                }
            }
        } catch (\Exception $e) {
            return false;
        }
    }


    public function categoryCourse(Request $request, $id, $name)
    {
        try {

            return view(theme('pages.search'), compact('request', 'id'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function subCategoryCourse(Request $request, $id, $name)
    {
        $quiz_id = OnlineQuiz::where('sub_category_id', $id)->get()->pluck('id')->toArray();
        $course_id = Course::where('subcategory_id', $id)->get()->pluck('id')->toArray();
        $class_id = VirtualClass::where('sub_category_id', $id)->get()->pluck('id')->toArray();


        $query = Course::with('user', 'category', 'subCategory', 'enrolls', 'comments', 'reviews', 'lessons', 'quiz', 'class')
            ->where('status', 1)
            ->latest();


        $query->where(function ($q) use ($quiz_id, $course_id, $class_id) {
            $q->whereIn('quiz_id', $quiz_id)
                ->orWhereIn('id', $course_id)
                ->orWhereIn('class_id', $class_id);
        });

        $type = $request->type;
        if (empty($type)) {
            $type = '';
        } else {
            $types = explode(',', $type);
            if (count($types) == 1) {
                foreach ($types as $t) {
                    if ($t == 'free') {
                        $query->where('price', 0);
                    } elseif ($t == 'paid') {
                        $query = $query->where('price', '>', 0);
                    }
                }
            }
        }

        $language = $request->language;
        if (empty($language)) {
            $language = '';
        } else {
            $row_languages = explode(',', $language);
            $languages = [];
            $LanguageList = Language::whereIn('code', $row_languages)->first();
            foreach ($row_languages as $l) {
                $lang = $LanguageList->where('code', $l)->first();
                if ($lang) {
                    $languages[] = $lang->id;
                }
            }
            $query->whereIn('lang_id', $languages);
        }


        $level = $request->level;
        if (empty($level)) {
            $level = '';
        } else {
            $levels = explode(',', $level);
            $query->whereIn('level', $levels);
        }

        $mode = $request->mode;
        if (empty($mode)) {
            $mode = '';
        } else {
            $modes = explode(',', $mode);
            $query->whereIn('mode_of_delivery', $modes);
        }

        $order = $request->order;
        if (empty($order)) {
            $order = '';
        } else {
            if ($order == "price") {
                $query->orderBy('price', 'asc');
            } else {
                $query->latest();
            }
        }

        $courses = $query->paginate(9);
        $total = $courses->total();
        $levels = CourseLevel::select('id', 'title')->where('status', 1)->get();

        return view(theme('pages.search'), compact('levels', 'order', 'level', 'order', 'mode', 'language', 'type', 'total', 'courses', 'request', 'id'));
    }


    public function fetch_course(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = DB::table('courses')
                ->where('title', 'LIKE', "%{$query}%")
                ->get();
            $output = '<ul>';

            foreach ($data as $row) {

                $output .= '
                        <li>
                            <a style="color:black" href="' . courseDetailsUrl(@$row->id, @$row->type, @$row->slug) . '">' . $row->title . '</a>
                        </li>
                        ';
            }
            $output .= '</ul>';
            echo $output;
        }
    }


    public function submitAns(Request $request)
    {
        $setting = QuizeSetup::getData();

        $qusAns = $request->get('qusAns');

        $array = explode('|', $qusAns);
        $ansId = $array[1];
        $qusId = $array[0];
        $userId = Auth::id() ?? 1;

        $question_review = $setting->question_review;
        $show_result_each_submit = $setting->show_result_each_submit;


        if ($request->get('courseId')) {
            $courseId = $request->get('courseId');


            if (!empty($qusAns)) {
                $totalQusSubmit = QuizTest::where('user_id', $userId)->count();
                $test = QuizTest::where('user_id', $userId)->where('course_id', $courseId)->where('question_id', $qusId)->first();

                if (empty($test)) {
                    $test = new QuizTest();
                    $test->user_id = $userId;
                    $test->course_id = $courseId;
                    $test->quiz_id = $request->get('quizId');
                    $test->question_id = $qusId;
                    $test->ans_id = $ansId;
                    $test->status = $question_review == 1 ? 0 : 1;
                    $test->count = $totalQusSubmit + 1;
                    $test->date = date('m/d/Y');
                    $test->save();
                } else {
                    if ($question_review == 1) {
                        $test->ans_id = $ansId;
                        $test->save();
                    } else {
                        return response()->json(['error' => 'Already Submitted'], 500);
                    }
                }
            }

            if ($show_result_each_submit == 1) {
                $ans = QuestionBankMuOption::find($ansId);

                if ($ans->status == 1) {
                    $result = true;
                } else {
                    $result = false;
                }

                return response()->json(['result' => $result], 200);
            } else {
                return response()->json(['submit' => true], 200);
            }
        } else {
            return response()->json(['error' => 'Something Went Wrong'], 500);
        }
    }


    public function getResult($courseId, $quizId)
    {
        $userId = Auth::id() ?? 1;
        $alreadySubmitTest = QuizTest::where('user_id', $userId)->where('course_id', $courseId)->where('quiz_id', $quizId)->distinct()->get();
        $quiz = OnlineQuiz::find($quizId);
        $totalQus = totalQuizQus($quiz->id);
        $totalAns = count($alreadySubmitTest);
        $totalCorrect = 0;
        $totalScore = totalQuizMarks($quizId);
        $score = 0;
        if ($totalAns != 0) {
            $hasResult = true;
            foreach ($alreadySubmitTest as $test) {
                $test->status = 1;
                $test->save();
                $ans = QuestionBankMuOption::find($test->ans_id);

                if (!empty($ans)) {
                    if ($ans->status == 1) {

                        $score += $ans->question->marks ?? 1;
                        $totalCorrect++;
                        //                        $totalScore +=$ans->
                    }
                }
            }
        } else {
            $hasResult = false;
        }

        $output = '';

        $output .= ' Total Question ' . $totalQus . '<br>';
        $output .= ' Total Ans ' . $totalAns . '<br>';
        $output .= ' Total Correct ' . $totalCorrect . '<br>';
        $output .= ' Score ' . $score . ' out of ' . $totalScore . ' <br>';
        return ['hasResult' => $hasResult, 'output' => $output];;
    }

    public function contact()
    {
        try {
            if (hasDynamicPage()) {
                $row = FrontPage::where('slug', '/contact-us')->first();
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                $page_content = app('getHomeContent');
                return view(theme('pages.contact'), compact('page_content'));
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function contactUs()
    {
        try {
            $page_content = app('getHomeContent');
            return view(theme('pages.contact'), compact('page_content'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function newPage()
    {
        return view(theme('pages.new_page'));
    }
    
    public function application_requirements()
    {
    return view(theme('pages.application_requirements'));
    }

    public function contactMsgSubmit(Request $request)
    {

        if (saasEnv('NOCAPTCHA_FOR_CONTACT') == 'true') {
            $validate_rules = [
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required',
                'phone' => 'required',
                'zip' => 'required',
                'program' => 'required',
                'year' => 'required',
                'g-recaptcha-response' => 'required|captcha'
            ];
        } else {
            $validate_rules = [
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required',
                'phone' => 'required',
                'zip' => 'required',
                'program' => 'required',
                'year' => 'required'
            ];
        }

        $request->validate($validate_rules, validationMessage($validate_rules));

        if (appMode()) {
            Toastr::error('For demo version you can not send message', trans('common.Failed'));
            return redirect()->back();
        }

        $name = $request->get('name');
        $email = $request->get('email');
        $message = $request->get('message');
        $phone = $request->get('phone');
        $zip = $request->get('zip');
        $program = $request->get('program');
        $year = $request->get('year');


        $admin = User::where('role_id', 1)->first();


        $send = SendGeneralEmail::dispatch($admin, 'CONTACT_MESSAGE', [
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'subject' => 'Contact Us',
            'phone' => $phone,
            'zip' => $zip,
            'program' => $program,
            'year' => $year
        ]);


        if ($send) {
            Toastr::success('Successfully Sent Message', trans('common.Success'));
            return redirect()->back();
        } else {
            Toastr::error('Something went wrong', trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function frontPage($slug)
    {

        $page = $row = FrontPage::where('slug', $slug)->first();
        if (!$row) {
            abort(404);
        }
        try {

            if ($row->status != 1) {
                Toastr::error('Sorry. Page is not active', trans('common.Failed'));
                return redirect()->back();
            }

            if (hasDynamicPage()) {
                $details = dynamicContentAppend($row->details);
                // dd($details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                return view(theme('pages.page'), compact('page'));
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function search(Request $request)
    {
        try {
            $id = 0;
            return view(theme('pages.search'), compact('request', 'id'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function enrollOrCart($id)
    {


        $course = Course::findOrFail($id);

        if (isModuleActive('Org')) {
            $type = $course->required_type;
            if ($type == 1) {
                $output['result'] = 'failed';
                $output['message'] = trans('org.Unable to add cart');
                return $output;
            }
        }
        $output = [];

        //add to cart
        $output['type'] = 'addToCart';


        try {
            $user = Auth::user();
            if (Auth::check() && ($user->role_id != 1)) {
                if (!$course->isLoginUserEnrolled) {
                    $exist = Cart::where('user_id', $user->id)
                        ->when(isModuleActive('Invoice'), function ($query) {
                            $query->whereNull('type');
                        })
                        ->where('course_id', $id)->first();
                    $oldCart = Cart::where('user_id', $user->id)
                        ->when(isModuleActive('Invoice'), function ($query) {
                            $query->whereNull('type');
                        })
                        ->first();


                    if (isset($exist)) {
                        $output['result'] = 'failed';
                        $output['message'] = trans('frontend.Course already added in your cart');
                    } elseif (Auth::check() && ($user->role_id == 1)) {
                        $output['result'] = 'failed';
                        $output['message'] = trans('frontend.You logged in as admin so can not add cart');
                    } else {

                        if (isset($oldCart)) {

                            $cart = new Cart();
                            $cart->user_id = $user->id;
                            $cart->instructor_id = $course->user_id;
                            $cart->course_id = $id;
                            $cart->tracking = $oldCart->tracking;
                            if ($course->discount_price != null) {
                                $cart->price = $course->discount_price;
                            } else {
                                $cart->price = $course->price;
                            }
                            $cart->save();
                        } else {
                            $cart = new Cart();
                            $cart->user_id = $user->id;
                            $cart->instructor_id = $course->user_id;
                            $cart->course_id = $id;
                            $cart->tracking = getTrx();
                            if ($course->discount_price != null) {
                                $cart->price = $course->discount_price;
                            } else {
                                $cart->price = $course->price;
                            }
                            $cart->save();
                        }

                        if ($cart->price == 0 && !isModuleActive('Org')) {
                            $output['type'] = 'enroll';
                            $paymentController = new PaymentController();
                            $paymentController->directEnroll($cart->course_id, $cart->tracking);
                            $output['message'] = trans('frontend.Course enrolled successfully');
                        } else {
                            $output['message'] = trans('frontend.Course Added to your cart');
                        }


                        $output['result'] = 'success';
                        $output['total'] = cartItem();
                    }
                } else {
                    $output['result'] = 'failed';
                    $output['message'] = trans('frontend.Already Enrolled');
                }
            } //If user not logged in then cart added into session

            else {

                $course = Course::find($id);
                if (!$course) {
                    $output['result'] = 'failed';
                    $output['message'] = trans('courses.Course not found');
                }

                if ($course->discount_price > 0) {
                    $price = $course->discount_price;
                } else {
                    $price = $course->price;
                }


                $cart = session()->get('cart');
                if (!$cart) {
                    $cart = [
                        $id => [
                            "id" => $course->id,
                            "course_id" => $course->id,
                            "instructor_id" => $course->user_id,
                            "instructor_name" => $course->user->name,
                            "title" => $course->title,
                            "image" => $course->image,
                            "slug" => $course->slug,
                            "type" => $course->type,
                            "price" => $price,
                        ]
                    ];
                    session()->put('cart', $cart);

                    $output['result'] = 'success';
                    $output['total'] = cartItem();
                    $output['message'] = trans('frontend.Course Added to your cart');
                } elseif (isset($cart[$id])) {
                    $output['result'] = 'failed';
                    $output['message'] = trans('frontend.Course already added in your cart');
                } else {

                    $cart[$id] = [

                        "id" => $course->id,
                        "course_id" => $course->id,
                        "instructor_id" => $course->user_id,
                        "instructor_name" => $course->user->name,
                        "title" => $course->title,
                        "image" => $course->image,
                        "slug" => $course->slug,
                        "price" => $price,
                    ];

                    session()->put('cart', $cart);

                    $output['result'] = 'success';
                    $output['total'] = cartItem();
                    $output['message'] = trans('frontend.Course Added to your cart');
                }
            }
        } catch (\Exception $e) {
            $output['result'] = 'failed';
            $output['message'] = 'Operation Failed !';
        }


        return json_encode($output);
    }

    public function getItemList()
    {
        $carts = [];
        if (Auth::check()) {

            $items = Cart::where('user_id', Auth::id())->with(['course', 'course.user', 'program', 'program.user'])->when(isModuleActive('Invoice'), function ($query) {
                $query->whereNull('type');
            })->get();

            if (!empty($items)) {

                foreach ($items as $key => $cart) {
                    $check = Program::find($cart['program_id']);
                    if ($check) {
                        $carts[$key]['id'] = $cart['id'];
                        $carts[$key]['program_id'] = $cart['program_id'];
                        $carts[$key]['instructor_id'] = $cart['instructor_id'];
                        $carts[$key]['title'] = $cart->program->programtitle;
                        $carts[$key]['instructor_name'] = $cart->program->user->name;
                        $carts[$key]['image'] = getCourseImage($cart->program->icon);

                        if ($cart->program->discount_price > 0) {

                            $carts[$key]['price'] = getPriceFormat($cart->program->discount_price);
                        } else {

                            $carts[$key]['price'] = getPriceFormat($cart->price);
                        }
                    }
                    $check = Course::find($cart['course_id']);
                    if ($check) {
                        $carts[$key]['id'] = $cart['id'];
                        $carts[$key]['course_id'] = $cart['course_id'];
                        $carts[$key]['instructor_id'] = $cart['instructor_id'];
                        $carts[$key]['title'] = $cart->course->title;
                        $carts[$key]['instructor_name'] = $cart->course->user->name;
                        $carts[$key]['image'] = getCourseImage($cart->course->thumbnail);

                        if ($cart->course->discount_price > 0) {

                            $carts[$key]['price'] = getPriceFormat($cart->course->discount_price);
                        } else {

                            $carts[$key]['price'] = getPriceFormat($cart->price);
                        }
                    }

                    //                    if (isModuleActive('BundleSubscription')) {
                    //                        $bundleCheck = BundleCoursePlan::find($cart['bundle_course_id']);
                    //                        if ($bundleCheck) {
                    //                            $carts[$key]['id'] = $cart['id'];
                    //                            $carts[$key]['course_id'] = $cart['course_id'];
                    //                            $carts[$key]['instructor_id'] = $cart['instructor_id'];
                    //                            $carts[$key]['title'] = $bundleCheck->title;
                    //                            $carts[$key]['instructor_name'] = $bundleCheck->user->name;
                    //                            $carts[$key]['image'] = getCourseImage($bundleCheck->icon);
                    //                            $carts[$key]['price'] = getPriceFormat($bundleCheck->price);
                    //                        }
                    //                    }

                }
            }
        } else {
            $items = session()->get('cart');
            if (!empty($items)) {
                $carts = $items;
                //                foreach ($items as $key => $cart) {
                //
                //                    $program = Program::find(15);
                ////                    return $program;
                //                    if ($program) {
                //                        $carts[$key]['id'] = $cart['id'];
                //                        $carts[$key]['program_id'] = $program->id;
                //                        $carts[$key]['instructor_id'] = $program->user_id;
                //                        $carts[$key]['title'] = $program->programtitle;
                //                        $carts[$key]['instructor_name'] = $program->user->name;
                //                        $carts[$key]['image'] = getCourseImage($program->icon);
                //
                //                        if ($program->discount_price > 0) {
                //                            $carts[$key]['price'] = getPriceFormat($program->discount_price);
                //                        } else {
                //                            $carts[$key]['price'] = getPriceFormat($cart->price);
                //
                //                        }
                //                    }
                //                }
            }
        }


        return response()->json($carts);
    }


    public function lessonComplete(Request $request)
    {


        try {
            $newLessonComplete = false;
            $lesson = LessonComplete::where('course_id', $request->course_id)->where('lesson_id', $request->lesson_id)->where('user_id', Auth::id())->first();
            $certificateBtn = 0;
            if (!$lesson) {
                $check = Lesson::find($request->lesson_id);
                if ($check) {
                    checkGamification('each_unit_complete', '');
                }
                $newLessonComplete = true;
                $lesson = new LessonComplete();
                $lesson->user_id = Auth::id();
                $lesson->course_id = $request->course_id;
                $lesson->lesson_id = $request->lesson_id;
            }
            $lesson->status = $request->status;
            if ($request->status == 1)
                $success = trans('frontend.Lesson Marked as Complete');
            else
                $success = trans('frontend.Lesson Marked as Incomplete');
            $lesson->save();

            $course = Course::find($request->course_id);
            if ($course) {
                $percentage = round($course->loginUserTotalPercentage);
                if ($percentage >= 100) {
                    if ($newLessonComplete) {
                        checkGamification('each_course_complete', 'learning');
                    }
                    $this->getCertificateRecord($course->id);


                    if (UserEmailNotificationSetup('Complete_Course', Auth::user())) {
                        SendGeneralEmail::dispatch(Auth::user(), 'Complete_Course', [
                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $course->title
                        ]);
                    }
                    if (UserBrowserNotificationSetup('Complete_Course', Auth::user())) {
                        send_browser_notification(
                            Auth::user(),
                            'Complete_Course',
                            [
                                'time' => Carbon::now()->format('d-M-Y, g:i A'),
                                'course' => $course->title
                            ],
                            trans('common.View'),
                            courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                        );
                    }

                    if (UserMobileNotificationSetup('Complete_Course', Auth::user()) && !empty(Auth::user()->device_token)) {
                        send_mobile_notification(Auth::user(), 'Complete_Course', [
                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $course->title
                        ]);
                    }
                }
            }
            if (count($lesson->course->lessons) == count($lesson->course->completeLessons->where('status', 1)))
                $certificateBtn = 1;


            $previousUrl = app('url')->previous();

            return redirect()->to($previousUrl . '&' . http_build_query(['done' => 1]));
        } catch (\Exception $e) {

            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function lessonCompleteAjax(Request $request)
    {


        try {
            $newLessonComplete = false;

            if (empty($request->user_id)) {
                $user = Auth::user();
            } else {
                $user = User::find($request->user_id);
            }

            $enrolled = CourseEnrolled::where('course_id', $request->course_id)->where('user_id', $user->id)->first();

            $lesson = LessonComplete::query()
                ->where('course_id', $request->course_id)
                ->where('lesson_id', $request->lesson_id)
                ->where('user_id', $user->id)
                ->first();
            if (!$lesson) {
                $check = Lesson::find($request->lesson_id);
                if ($check) {
                    checkGamification('each_unit_complete', '');
                }

                $lesson = new LessonComplete();
                $newLessonComplete = true;
            }
            $lesson->user_id = $user->id;
            $lesson->course_id = $request->course_id;
            $lesson->lesson_id = $request->lesson_id;
            $lesson->enroll_id = @$enrolled->id;
            $lesson->status = 1;
            $lesson->save();

            $course = Course::withCount('lessons')->find($request->course_id);
            if ($course) {
                $completeLessons = LessonComplete::where('user_id', $user->id)->where('course_id', $course->id)->where('status', 1)->count();
                $totalLessons = $course->lessons;

                if ($completeLessons != 0) {
                    $percentage = ceil($completeLessons / count($totalLessons) * 100);
                } else {
                    $percentage = 0;
                }
                if ($percentage > 100) {
                    $percentage = 100;
                }

                if ($percentage >= 100) {

                    if ($newLessonComplete) {
                        checkGamification('each_course_complete', 'learning');
                    }

                    if ($enrolled->pathway_id != null) {
                        StudentSkillController::studentCreateSkill(2, $course->id, $user, $enrolled);
                    } else {
                        StudentSkillController::studentCreateSkill(1, $course->id, $user, $enrolled);
                    }

                    $this->getCertificateRecord($course->id);


                    if (UserEmailNotificationSetup('Complete_Course', $user)) {
                        SendGeneralEmail::dispatch($user, 'Complete_Course', [
                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $course->title
                        ]);
                    }
                    if (UserBrowserNotificationSetup('Complete_Course', $user)) {
                        send_browser_notification(
                            $user,
                            'Complete_Course',
                            [
                                'time' => Carbon::now()->format('d-M-Y, g:i A'),
                                'course' => $course->title
                            ],
                            trans('common.View'),
                            courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                        );
                    }

                    if (UserMobileNotificationSetup('Complete_Course', $user) && !empty($user->device_token)) {
                        send_mobile_notification($user, 'Complete_Course', [
                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $course->title
                        ]);
                    }
                }
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCertificateRecord($course_id)
    {

        try {

            $course = Course::find($course_id);

            if (!empty($course->certificate_id)) {
                $certificate = Certificate::find($course->certificate_id);
            } else {
                if ($course->type == 1) {
                    $certificate = Certificate::where('for_course', 1)->first();
                } elseif ($course->type == 2) {
                    $certificate = Certificate::where('for_quiz', 1)->first();
                } elseif ($course->type == 3) {
                    $certificate = Certificate::where('for_class', 1)->first();
                } else {
                    $certificate = null;
                }
            }
            if ($certificate) {
                $certificate_record = CertificateRecord::where('student_id', Auth::user()->id)->where('course_id', $course_id)->first();
                if (!$certificate_record) {
                    checkGamification('each_certificate', 'certification');

                    $certificate_record = new CertificateRecord();
                    $certificate_record->certificate_id = $this->generateUniqueCode();
                    $certificate_record->student_id = Auth::user()->id;
                    $certificate_record->course_id = $course_id;
                    $certificate_record->created_by = Auth::user()->id;
                    if (isModuleActive('Org')) {
                        if ($course->required_type == 1) {
                            $enrolls = $course->enrolls->where('user_id', Auth::id());
                            if (isset($enrolls[0])) {
                                $plan_id = $enrolls[0]->org_subscription_plan_id;
                                $checkout = OrgSubscriptionCheckout::where('plan_id', $plan_id)->where('user_id', \auth()->id())->latest()->first();
                                $certificate_record->start_date = $checkout->start_date;
                                $certificate_record->end_date = $checkout->end_date;
                            }
                        } else {
                            $certificate_record->start_date = $course->created_at;
                            $certificate_record->end_date = '';
                        }
                        addOrgRecentActivity(\auth()->id(), $course->id, 'Complete');
                    }

                    $certificate_record->save();
                }

                if (isModuleActive('Org')) {

                    request()->certificate_id = $certificate_record->certificate_id;
                    request()->course = $course;
                    request()->user = Auth::user();
                    $downloadFile = new CertificateController();
                    $certificate = $downloadFile->makeCertificate($certificate->id, request())['image'] ?? '';

                    $certificate->encode('jpg');

                    $certificate->save('public/certificate/' . $certificate_record->id . '.jpg');
                }
                return $certificate_record;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }


    public function subscriptionCourses()
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        if (isModuleActive('Subscription')) {
            if (!isSubscribe()) {
                Toastr::error('You must subscribe first', 'Error');
                return redirect()->back();
            }
        }
        try {

            return view(theme('pages.subscription-courses'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function orgSubscriptionCourses(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        try {

            return view(theme('pages.org-subscription-courses'), compact('request'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function orgSubscriptionPlanList($planId, Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        try {
            return view(theme('pages.org-subscription-plan-list'), compact('request', 'planId'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function subscription(Request $request)
    {

        if (isModuleActive('Subscription')) {

            return view(theme('pages.subscription'));
        } else {
            Toastr::error('Module not active', 'Error');
            return redirect()->back();
        }
    }

    public function subscriptionCourseList(Request $request, $plan_id)
    {
        try {
            if (isModuleActive('Subscription')) {
                return view(theme('pages.subscription_course_list'), compact('plan_id'));
            } else {
                Toastr::error('Module not active', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function subscriptionCheckout(Request $request)
    {


        if (empty($request->plan)) {
            $s_plan = '';
        } else {
            $s_plan = $request->plan;
        }

        if (empty($request->price)) {
            $price = '';
        } else {
            $price = $request->price;
        }

        //        if (currentTheme() != 'tvt') {
        //            if (!empty($s_plan) && !empty($price)) {
        //                if (Auth::check()) {
        //                    if (Auth::user()->role_id == 3) {
        //                        $subscription = new CourseSubscriptionController();
        //                        $addCart = $subscription->addToCart(Auth::user()->id, $s_plan);
        //
        //                        if (!$addCart) {
        //                            Toastr::error('Invalid Request', 'Error');
        //                            return \redirect()->route('courseSubscription');
        //                        }
        //                    } else {
        //                        Toastr::error('You must login as a student', 'Error');
        //                        return \redirect()->route('courseSubscription');
        //                    }
        //
        //                } else {
        //                    Toastr::error('You must login', 'Error');
        //                    return \redirect()->route('login');
        //                }
        //            } else {
        //                Toastr::error('Invalid Request ', 'Error');
        //                return \redirect()->route('login');
        //            }
        //        }


        return view(theme('pages.subscriptionCheckout'), compact('request', 's_plan', 'price'));
    }


    public function continueCourse(Request $request, $slug)
    {

        try {
            $lesson_id = null;
            $user = Auth::user();
            $course = Course::where('slug', $slug)->first();
            if ($request->has('program_id')) {
                $isEnrolled = CourseEnrolled::where('program_id', $request->program_id)->where('user_id', Auth::id())->count();
                if ($isEnrolled == 0) {
                    Toastr::error(trans('common.Access Denied'), trans('common.Failed'));
                    return redirect()->back();
                }
            } else if ($request->has('courseType')) {
                $isEnrolled = CourseEnrolled::where('course_id', $course->id)->where('course_type', $request->courseType)->where('user_id', Auth::id())->count();
                if ($isEnrolled == 0) {
                    Toastr::error(trans('common.Access Denied'), trans('common.Failed'));
                    return redirect()->back();
                }
            } else {
                Toastr::error(trans('common.Access Denied'), trans('common.Failed'));
                return redirect()->back();
            }

            $isEnrolled = $course->isLoginUserEnrolled;
            $enrollForCpd = false;
            $enrollForClass = false;
            if (isModuleActive('CPD')) {
                $enrollForCpd = $course->hasEnrollForCPd ? true : false;
            }
            if (isModuleActive('MyClass')) {
                $studentClassRepository = App::make(AddStudentToClassRepositoryInterface::class);
                $enrollForClass = $studentClassRepository->hasEnrollCourse($course->id, auth()->user()->id);
            }

            //            if (!$isEnrolled || $enrollForCpd == true || $enrollForClass == true) {

            $lesson = LessonComplete::where('course_id', $course->id)->where('user_id', $user->id)->has('lesson')->orderBy('updated_at', 'desc')->first();
            if (empty($lesson)) {
                $chapter = Chapter::where('course_id', $course->id)->whereHas('lessons')->orderBy('position', 'asc')->first();
                if (empty($chapter)) {
                    Toastr::error('No lesson found', 'Failed');
                    return redirect()->route('courseDetailsView', $slug);
                }
                $lesson = Lesson::where('course_id', $course->id)->where('chapter_id', $chapter->id)->orderBy('position', 'asc')->first();
                if (!empty($lesson)) {
                    $lesson_id = $lesson->id;
                }
            } else {
                $next_lesson = null;
                $chapters = Chapter::select('id')->where('course_id', $course->id)->whereHas('lessons')->orderBy('position', 'asc')->get();
                foreach ($chapters as $c) {
                    $lessons = Lesson::select('id')->where('course_id', $course->id)->where('chapter_id', $c->id)->orderBy('position', 'asc')->get()->pluck('id')->toArray();
                    if (in_array($lesson->lesson_id, $lessons)) {
                        $position = array_search($lesson->lesson_id, $lessons);
                        $position = $position + 1;
                        if (isset($lessons[$position])) {
                            $next_lesson = $lessons[$position];
                        }
                    }
                }
                $lesson_id = !empty($next_lesson) ? $next_lesson : $lesson->lesson_id;
            }

            if (!empty($lesson_id)) {
                if ($request->has('program_id')) {
                    return \redirect()->to(url('fullscreen-view/' . $course->id . '/' . $lesson_id) . '?program_id=' . $request->program_id);
                } else if ($request->has('courseType')) {
                    return \redirect()->to(url('fullscreen-view/' . $course->id . '/' . $lesson_id) . '?courseType=' . $request->courseType);
                }
            } else {
                Toastr::error('There is no lesson for this course!', 'Failed');
                return redirect()->route('courseDetailsView', $slug);
            }
            //            } else {
            //                Toastr::error('You are not enrolled for this course !', 'Failed');
            //                return redirect()->route('courseDetailsView', $slug);
            //            }
        } catch (\Exception $e) {

            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function vimeoPlayer($video_id)
    {
        return view('vimeo_player', compact('video_id'));
    }


    public function scormPlayer($lesson_id, $user_id = null)
    {
        $lesson = Lesson::with('course')->find($lesson_id);
        $course = $lesson->course;
        $with = [];
        if (isModuleActive('Org')) {
            $with[] = 'branch';
        }
        $user = User::with($with)->find($user_id);
        return view('scorm_player', compact('lesson', 'course', 'user'));
    }

    public function offline()
    {
        return 'offline';
    }


    public function test()
    {
        return 'okk';
    }

    public function calendarView()
    {
        try {
            $calendars = Calendar::with('course', 'event', 'course.user', 'course.user.role')->get();

            //    return $calendars;
            return view(theme('pages.calendarView'), compact('calendars'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function documentPlayer($lesson_id)
    {
        $lesson = Lesson::with('course')->find($lesson_id);
        return view('document_player', compact('lesson'));
    }
}
