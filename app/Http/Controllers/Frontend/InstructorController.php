<?php

namespace App\Http\Controllers\Frontend;

use App\User;
use Carbon\Carbon;
use App\BillingDetails;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use function PHPSTORM_META\type;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CloverController;
use Modules\CourseSetting\Entities\Course;
use Modules\Setting\Entities\InstructorSetup;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\SystemSetting\Entities\TutorSlote;
use Modules\SystemSetting\Entities\TutorHiring;
use Modules\FrontendManage\Entities\BecomeInstructor;
use Modules\Payment\Entities\Checkout;

class InstructorController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenanceMode');
    }

    public function instructors(Request $request)
    {
        try {
            //            if (hasDynamicPage()) {
            //                $row = FrontPage::where('slug', '/instructors')->first();
            //                $details = dynamicContentAppend($row->details);
            //                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            //            } else {
            $instructors = User::where('role_id', 2)->where('status', '1')->whereNotNull('total_hours')->orderBy('total_rating', 'desc')->paginate(16);
            $themes = [
                'edume',
                'teachery'
            ];
            // $data = '';
            // if ($request->ajax()) {
            //     foreach ($instructors as $instructor) {
            //         if (in_array(Settings('frontend_active_theme'), $themes)) {
            //             $data .= view(theme('partials._single_instractor'), compact('instructor'));
            //         } else {
            //             $data .= '    <div class="col-md-6 col-lg-4 col-xl-3">
            //                 <div class="single_instractor mb_30">
            //                     <a href="' . route('instructorDetails', [$instructor->id, Str::slug($instructor->name, '-')]) . '"
            //                        class="thumb">
            //                         <img src="' . getInstructorImage($instructor->image) . '" alt="">
            //                     </a>
            //                     <a href="' . route('instructorDetails', [$instructor->id, Str::slug($instructor->name, '-')]) . '">
            //                         <h4>' . $instructor->name . '</h4></a>
            //                     <span>' . $instructor->headline . '</span>
            //                 </div>
            //             </div>';
            //         }
            //     }
            //     return $data;
            // }

            $postions = DB::table('instructor_positions')->get();
            $hears = DB::table('instructor_hears')->get();

            // dd($instructors, $postions, $hears);

            return view(theme('pages.instructors'), compact('instructors', 'postions', 'hears'));
            //            }


        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function instructorDetails($id, $name, Request $request)
    {
        try {

            $instructor = User::findOrFail($id);
            $InstructorSetup = InstructorSetup::getData();
            $courses = Course::where('user_id', $id)->with('enrollUsers', 'lessons', 'category')->where('status', 1)->orderBy('total_rating', 'desc')->paginate(12);

            $data = '';
            if ($request->ajax()) {
                foreach ($courses as $course) {
                    $data .= view(theme('partials._single_course'), ['course' => $course])->render();
                }
                return $data;
            }
            if (isModuleActive('BundleSubscription')) {
                $bundleCourse = new  \Modules\BundleSubscription\Repositories\BundleCoursePlanRepository;
                $BundleCourse = $bundleCourse->getInstructorBundle($id);
            } else {
                $BundleCourse = null;
            }
            return view(theme('pages.instructor'), compact('BundleCourse', 'instructor', 'id', 'InstructorSetup'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function tutorDetails($id, $name, Request $request)
    {
        try {

            $tutor = User::with('tutorReviews','userTutorReviews')->findOrFail($id);
            $courses = Course::where('user_id', $id)->where('status', 1)->where('type', 1)->get();

//            reviews
            if ($request->ajax()) {
                if ($request->type == "review") {
                    $reviews = DB::table('tutor_reveiws')
                        ->select(
                            'tutor_reveiws.id',
                            'tutor_reveiws.star',
                            'tutor_reveiws.comment',
                            'tutor_reveiws.instructor_id',
                            'tutor_reveiws.created_at',
                            'users.id as userId',
                            'users.name as userName',
                        )
                        ->join('users', 'users.id', '=', 'tutor_reveiws.user_id')
                        ->where('tutor_reveiws.instructor_id', $tutor->id)->paginate(10);
                    $data = '';
                    foreach ($reviews as $review) {
                        $data .= view(theme('partials._single_tutor_review'), ['review' => $review, 'tutor' => $tutor])->render();
                    }
                    if (count($reviews) == 0) {
                        $data .= '';
                    }
                    return $data;
                }
            }



            return view(theme('pages.tutorDetails'), compact('tutor', 'courses'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function tutorBooking($id)
    {
        try {

            $tutor = User::findOrFail($id);
            $courses = Course::where('user_id', $id)->where('status', 1)->where('type', 1)->get();
            $time_slots = TutorSlote::where('instructor_id', $id)->whereNotNull('start_time')->get();

            return view(theme('pages.tutorBooking'), compact('tutor', 'courses', 'time_slots'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function checkAvailableSlots(Request $request)
    {
        $tutor = TutorSlote::where('instructor_id', $request->tutor_id)->whereDoesntHave('slotHiring', function ($q) use ($request) {
            $q->whereDate('assign_date', Carbon::parse($request->date)->format('Y-m-d'));
        })->get(['id', 'start_time', 'end_time']);

        return response()->json($tutor);
    }
    public function tutorPayment(Request $request)
    {
        try {
            $clover = new CloverController();
            $pakms = $clover->getPakmsKey();

            $new_pkms = Config::set('apiaccess', $pakms);

            $tutor = User::findOrFail($request->tutor_id);
            $course = Course::where('id', $request->course_id)->where('status', 1)->first();
            $time_slots = TutorSlote::whereIn('id', $request->time_slot)->get();
            $payment_type = 'tutor_payment';
            $selected_date = $request->date;
            Session::put('timeslot_id', $request->time_slot);

            return view(theme('pages.tutorPayment'), compact('tutor', 'course', 'time_slots', 'payment_type', 'selected_date'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
    public function tutorPaymentSubmit(Request $request)
    {

        $clover = new CloverController();
        if ($response = $clover->makePayment($request, $request->payment_type, true)) {
            $this->tutorBookingConfirmed($response, "clover", $request->user_id, $request->tutor_id, $request->selected_date, $request->course_id, $request->amount, session()->get('timeslot_id'));

            $bill = BillingDetails::with('country')->where('user_id', Auth::id())->latest()->first();
            $checkout = Checkout::where('tracking', $response->id)->first();
            $checkout->billing_detail_id = $bill->id;
            $checkout->save();

            Toastr::success('Payment Successfully Done', 'Success');
            return redirect()->route('instructors');
        } else {
            Toastr::error('Something Went Wrong', 'Error');
            return redirect()->back();
        }
    }

    public function tutorBookingConfirmed($response, $gateWayName, $user_id, $tutor_id, $selected_date, $course_id, $amount, $timeslot_id)
    {


        foreach ($timeslot_id as $slot_id) {

            $time_slots = TutorSlote::find($slot_id);

            $meeting_date_time = $selected_date . $time_slots->start_time;

            $meeting = $this->zoomMeeting($meeting_date_time);

            $tutor_hiring = new TutorHiring();
            $tutor_hiring->instructor_id = (int)$tutor_id;
            $tutor_hiring->user_id = (int)$user_id;
            $tutor_hiring->course_id = (int)$course_id;
            $tutor_hiring->tutor_slote_id = (int)$slot_id;
            $tutor_hiring->assign_date = $selected_date;
            $tutor_hiring->assign_start_time = $time_slots->start_time;
            $tutor_hiring->assign_end_time = $time_slots->end_time;
            $tutor_hiring->meeting_id = $meeting->id;
            $tutor_hiring->meeting_join_url = $meeting->join_url;
            $tutor_hiring->meeting_start_url = $meeting->start_url;
            $tutor_hiring->tracking_id = $response->id;
            $tutor_hiring->price = (int)$amount / 100;

            $tutor_hiring->save();
        }
    }

    public function zoomMeeting($meeting_date_time)
    {
        $start_time = gmdate('Y-m-d\TH:i:s', strtotime(isset($meeting_date_time) ? $meeting_date_time : date('Y-m-d H:i:s')));
        $password = rand('100000', '999999');
        $post = array();


        $post['topic'] = isset($data['TITLE']) ? $data['TITLE'] : 'Tutor Class';
        $post['agenda'] = isset($data['APPOINTMENT_TYPE_NAME']) ? $data['APPOINTMENT_TYPE_NAME'] : 'Class';
        $post['type'] = '2';
        $post['start_time'] = $start_time;
        $post['timezone'] = 'Asia/Pakistan';
        $post['password'] = $password;
        $post['duration'] = 60;
        $post['settings'] = array(
            'join_before_host' => true,
            'host_video' => false,
            'participant_video' => false,
            'mute_upon_entry' => true,
            'enforce_login' => true,
            'auto_recording' => "none",
        );

        $postFields = json_encode($post);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/users/me/meetings",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer  " . env('ZOOM_TOKEN'),
                "Content-Type: application/json"
            ),
        ));

        $zoom_response = curl_exec($curl);
        curl_close($curl);

        return json_decode($zoom_response);
    }

    public function becomeInstructor()
    {
        try {
            if (hasDynamicPage()) {
                $row = FrontPage::where('slug', '/become-instructor')->first();
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                $becomeInstructor = BecomeInstructor::all();
                return view(theme('pages.becomeInstructor'), compact('becomeInstructor'));
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
