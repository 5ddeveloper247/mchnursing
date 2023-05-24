<?php

namespace App\Http\Controllers\Frontend;


use App\Events\OneToOneConnection;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CloverController;
use App\Jobs\SendGeneralEmail;
use App\Traits\ImageStore;
use App\User;
use App\UserLogin;
use Carbon\Carbon;
use App\TopicReport;
use App\StudentCustomField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Modules\Affiliate\Events\ReferralPayment;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\OfflinePayment\Entities\OfflinePayment;
use Modules\Payment\Entities\Cart;
use App\Http\Controllers\Controller;
use App\Models\UserAuthorzIationAgreement;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Coupons\Entities\Coupon;
use Illuminate\Support\Facades\Config;
use Modules\Payment\Entities\Checkout;
use Modules\CourseSetting\Entities\Course;
use Modules\Certificate\Entities\Certificate;
use Modules\Assignment\Entities\InfixAssignment;
use Modules\CourseSetting\Entities\CourseReveiw;
use Modules\CourseSetting\Entities\Notification;
use Modules\Assignment\Entities\InfixAssignAssignment;
use Modules\Payment\Entities\PaymentPlanDetails;
use Modules\Payment\Entities\StudentProgramPaymentPlans;
use Modules\Quiz\Entities\QuizTest;
use Modules\Setting\Entities\UserGamificationPoint;
use Modules\StudentSetting\Entities\Program;
use Modules\StudentSetting\Entities\TutorReveiws;
use Modules\Subscription\Entities\SubscriptionCart;
use Modules\Subscription\Entities\SubscriptionCheckout;
use Modules\Certificate\Http\Controllers\CertificateController;
use Modules\Survey\Entities\Survey;
use Modules\Survey\Http\Controllers\SurveyController;
use Modules\VirtualClass\Entities\ClassComplete;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class StudentController extends Controller
{
    use ImageStore;

    public function __construct()
    {
        $this->middleware('maintenanceMode');
    }

    public function myDashboard()
    {
        try {
            return view(theme('pages.myDashboard'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function myCourses(Request $request)
    {
        // dd($request);
        try {
            return view(theme('pages.myCourses'), compact('request'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function myProgramPaymentPlan(Request $request, $program_id)
    {
        try {
            $program = Program::find($program_id);
            $plans = StudentProgramPaymentPlans::where('program_id', $program_id)->where('user_id', Auth::id())->where('plan_id', $request->plan_id)->orderby('type')->get();
            return view(theme('pages.myProgramPaymentPlan'), compact('plans', 'program', 'request'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
    public function myPaymentPlanInstallment(Request $request, $installment_id)
    {
        try {
            $clover = new CloverController();
            $pakms = $clover->getPakmsKey();

            $installment = StudentProgramPaymentPlans::find($installment_id);
            return view(theme('pages.myPaymentPlanInstallment'), get_defined_vars());
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
    public function myPaymentPlanInstallmentPayment(Request $request)
    {
        try {

            $clover = new CloverController();
            if ($clover->makePayment($request, 'plan_installment_pay', $request->installment_id)) {
                session()->forget('user');
                //                update status
                $installment = StudentProgramPaymentPlans::find($request->installment_id);
                $installment->pay_status = 'paid';
                $installment->save();

                Toastr::success('Payment done successfully', 'Success');
                return redirect()->to(route('myCourses'));
            } else {
                Toastr::error('Something Went Wrong', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {

            Toastr::error('Something Went Wrong', 'Error');
            return redirect()->back();
        }
    }

    public function myAppointment(Request $request)
    {
        try {
            return view(theme('pages.appointment_myAppointment'), compact('request'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function myWishlists()
    {
        try {
            return view(theme('pages.myWishlists'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function myPurchases()
    {
        try {
            return view(theme('pages.myPurchases'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function myBundle()
    {
        try {
            return view(theme('pages.myBundle'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function topicReport($id)
    {

        try {
            $check = TopicReport::where('report_by', Auth::user()->id)->where('report_for', $id)->first();
            if ($check == null) {
                $report = new TopicReport();
                $report->report_by = Auth::user()->id;
                $report->report_for = $id;
                $report->save();
                Toastr::success(trans('student.Report is under review'), trans('common.Success'));
                return redirect()->back();
            } else {

                Toastr::error(trans('student.You have already done report'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function myCertificate()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        try {
            return view(theme('pages.myCertificate'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function myAssignment()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        try {
            return view(theme('pages.myAssignment'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function myProfile()
    {
        try {
            $custom_field = StudentCustomField::getData();

            return view(theme('pages.myProfile'), compact('custom_field'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function myAssignmentDetails($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        try {

            $assign_assignment = InfixAssignAssignment::where('student_id', Auth::user()->id)->where('id', $id)->first();
            if ($assign_assignment == null) {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }
            $assignment_info = InfixAssignment::where('id', $assign_assignment->assignment_id)->first();

            return view(theme('pages.assignment_details'), compact('assignment_info', 'assign_assignment'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function uploadUserForm(Request $request)
    {
        $user = UserAuthorzIationAgreement::where('user_id', Auth::id())->first();
        $extension = $request->file('user_agreement_form')->extension();
        $allow_ext = ['doc', 'docx', 'pdf'];

        if (!in_array(strtolower($extension), $allow_ext)) {
            return  $this->formUploadResponse(422, 'error', '#', 'Invalid File Extension, Allow Extensions (DOC, DOCS, PDF) !');
        }
        if (!$user) {
            return  $this->formUploadResponse(422, 'error', '#', 'File Not Uploaded, Try Again !');
        }
        $user->user_agreement_form = $this->saveFile($request->file('user_agreement_form'), $user->user_id);
        $user->status = 0;
        $user->save();
        return $this->formUploadResponse(200, 'success', $user->user_agreement_form, 'File SuccessFully Uploaded, Thank you !');
    }

    public function formUploadResponse($status = 200, $state = '', $path = '', $message = '')
    {
        return response()->json([
            'status' => $status,
            'state' => $state,
            'path' => $path,
            'message' => $message,
        ]);
    }

    public static function saveFile($file, $user_id)
    {
        if (isset($file)) {
            // $current_date = Carbon::now()->format('d-m-Y');
            // if (!File::isDirectory('public/student_affidavit/' . $current_date)) {
            //     File::makeDirectory('public/student_affidavit/' . $current_date, 0777, true, true);
            // }
            $new_file_name = 'student_' . $user_id . '.' . $file->clientExtension();
            $file_path = 'public/student_affidavit/' . $new_file_name;
            $file->move(public_path('student_affidavit'), $new_file_name);
            return $file_path;
        } else {
            return null;
        }
    }
    public function ajaxUploadProfilePic(Request $request)
    {
        try {
            $user = Auth::user();
            $fileName = "";
            if ($request->file('file') != "") {
                $user->image = $this->saveImage($request->file('file'));
            }
            $user->save();
            return $fileName;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function myProfileUpdate(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $custom_field = StudentCustomField::getData();

        if (Auth::user()->role_id == 1) {
            $validate_rules = [
                'name' => 'required',
                'email' => 'required|email',

            ];
        } else {
            $validate_rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . Auth::id(),
                'username' => 'required|unique:users,username,' . Auth::id(),
                'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users,phone,' . Auth::id(),
                'country' => 'required',
                'company_id' => $custom_field->required_company ? 'required' : 'nullable',
                'student_type' => $custom_field->required_student_type ? 'required' : 'nullable',
                'identification_number' => $custom_field->required_identification_number ? 'required' : 'nullable',
                'job_title' => $custom_field->required_job_title ? 'required' : 'nullable',
                'gender' => $custom_field->required_gender ? 'required' : 'nullable',
                'dob' => $custom_field->required_dob ? 'required' : 'nullable',
            ];
        }

        $request->validate($validate_rules, validationMessage($validate_rules));


        try {

            if (demoCheck()) {
                return redirect()->back();
            }

            $lang = explode('|', $request->language ?? '');

            $user = Auth::user();
            if (empty($request->phone)) {
                $phone = null;
            } else {
                $phone = $request->phone;
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $phone;
            $user->address = $request->address;
            $user->language_id = $lang[0] ?? 19;
            $user->language_code = $lang[1] ?? 'en';
            $user->language_name = $lang[2] ?? 'English';
            $user->language_rtl = $lang[3] ?? '0';
            $user->city = $request->city;
            $user->country = $request->country;
            $user->state = $request->state;
            $user->zip = $request->zip;

            $user->student_type = $request->student_type;
            $user->identification_number = $request->identification_number;
            $user->job_title = $request->job_title;
            $user->dob = $request->dob;
            $user->gender = $request->gender;

            $user->currency_id = Settings('currency_id');
            $user->facebook = $request->facebook;
            $user->twitter = $request->twitter;
            $user->linkedin = $request->linkedin;
            $user->instagram = $request->instagram;
            $user->youtube = $request->youtube;
            $user->headline = $request->headline;
            $user->about = clean($request->about);
            if ($request->file('image') != "") {
                $user->image = $this->saveImage($request->file('image'));
            }
            $user->save();

            if ($request->company_name) {
                $user->company->update([
                    'name' => $request->company_name,
                    'sector' => $request->company_sector,
                    'phone' => $request->company_phone,
                    'address' => $request->company_address,
                ]);
            }


            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {

            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }


    public function myAccount()
    {
        try {
            return view(theme('pages.myAccount'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function MyUpdatePassword(Request $request)
    {
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required_with:new_password|same:new_password|min:8'
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {
            if (demoCheck()) {
                return redirect()->back();
            }

            $user = Auth::user();


            if (!Hash::check($request->old_password, $user->password)) {
                Toastr::error(trans('student.Password Do not match'), trans('common.Failed'));
                return redirect()->back();
            }

            $user->update([
                'password' => bcrypt($request->new_password)
            ]);

            $login = UserLogin::where('user_id', Auth::id())->where('status', 1)->latest()->first();
            if ($login) {
                $login->status = 0;
                $login->logout_at = Carbon::now(Settings('active_time_zone'));
                $login->save();
            }


            SendGeneralEmail::dispatch($user, 'PASS_UPDATE', [
                'time' => Carbon::now()->format('d-M-Y, g:i A')
            ]);

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            //            Auth::logout();

            return back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function MyAccountDelete(Request $request)
    {
        $rules = [
            'old_password' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {
            if (demoCheck()) {
                return redirect()->back();
            }

            $user = Auth::user();


            if (!Hash::check($request->old_password, $user->password)) {
                Toastr::error(__('student.Password does not match'), __('common.Failed'));
                return redirect()->back();
            }

            $user->delete();


            //            SendGeneralEmail::dispatch($user, 'PASS_UPDATE', [
            //                'time' => Carbon::now()->format('d-M-Y, g:i A')
            //            ]);

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));

            return back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function MyEmailUpdate(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users,email,' . Auth::id(),
            'password' => 'required',
        ]);
        try {

            $user = Auth::user();

            if (Config::get('app.app_sync')) {
                Toastr::error('For demo version you can not change this !', trans('common.Failed'));
                return redirect()->back();
            } else {
                // $success = trans('lang.Password').' '.trans('lang.Saved').' '.trans('lang.Successfully');


                if (!Hash::check($request->password, $user->password)) {
                    Toastr::error(trans('student.Password Do not match'), trans('common.Failed'));
                    return redirect()->back();
                }

                $user->update([
                    'email' => $request->email
                ]);
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function deposit(Request $request)
    {
        try {
            return view(theme('pages.deposit'), compact('request'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function loggedInDevices()
    {
        try {
            return view(theme('pages.log_in_devices'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function logOutDevice(Request $request)
    {
        if (!Hash::check($request->password, auth()->user()->password)) {
            Toastr::error(trans('frontend.Your Password Doesnt Match'));
            return back();
        }

        if (demoCheck()) {
            return redirect()->back();
        }

        $login = UserLogin::find($request->id);
        if (!empty($login->api_token)) {
            DB::table('oauth_access_tokens')->where('id', '=', $login->api_token)->delete();
        }
        Auth::logoutOtherDevices($request->password);
        $login->status = 0;
        $login->logout_at = Carbon::now();
        $login->save();

        Toastr::success(trans('frontend.Logged Out SuccessFully'));
        return back();
    }

    public function Invoice($id)
    {

        try {
            if (Auth::user()->role_id == 1) {
                return view(theme('pages.invoices_admin'), compact('id'));
            } else {
                return view(theme('pages.myInvoices'), compact('id'));
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function subInvoice($id)
    {

        try {

            $enroll = SubscriptionCheckout::where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->with('plan', 'user')->first();

            if ($enroll == null) {
                Toastr::error(trans('student.Invalid Invoice'), trans('common.Failed'));
                return redirect()->back();
            }
            return view(theme('pages.mySubInvoices'), compact('enroll'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function StudentApplyCoupon(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'total' => 'required'
        ]);

        try {

            $code = $request->code;
            $cart_type = $request->type;

            $final = 0;
            $tax = 0;
            $discount = 0;
            $couponUsed = 0;
            $resultMsg = trans('common.Something Went Wrong');

            $coupon = Coupon::where('code', $code)->whereDate('start_date', '<=', Carbon::now())
                ->whereDate('end_date', '>=', Carbon::now())->where('status', 1)->first();
            return $coupon;
            $couponApply = false;
            $total = $request->total;

            $max_dis = $coupon->max_discount;
            $min_purchase = $coupon->min_purchase;
            $type = $coupon->type;
            $value = $coupon->value;

            if ($type == 0) {
                $discount = (($total * $value) / 100);
            } else {
                $discount = $value;
            }

            if ($discount >= $max_dis) {
                $discount = $max_dis;
            }

            if ($cart_type == 'subscription') {
                if (!isModuleActive('Subscription')) {
                    return false;
                }
                $tracking = SubscriptionCart::where('user_id', Auth::id())->first()->tracking;
                $checkout = SubscriptionCheckout::where('tracking', $tracking)->first();
                if (empty($checkout)) {
                    $checkout = new SubscriptionCheckout();
                }
                $checkTrackingId = SubscriptionCheckout::where('tracking', $tracking)->where('coupon_id', $coupon)->first();
            } else if ($cart_type == 'membership') {
                $this->membershipCoupon($coupon);
            } else {
                $tracking = Cart::where('user_id', Auth::id())->first()->tracking;
                $checkout = Checkout::where('tracking', $tracking)->first();
                if (empty($checkout)) {
                    $checkout = new Checkout();
                }
                $checkTrackingId = Checkout::where('tracking', $tracking)->where('coupon_id', $coupon)->first();
            }


            if ($coupon) {
                if (isModuleActive('Subscription')) {
                    $couponUsed += $coupon->loginUserTotalSubscriptionUsed();
                }
                $couponUsed += $coupon->loginUserTotalUsed();

                if ($coupon->limit != 0 && $coupon->limit <= $couponUsed) {
                    $resultMsg = trans('coupons.Already used this coupon');
                } else {
                    if ($checkTrackingId) {
                        $resultMsg = trans('coupons.Already used this coupon');
                    } elseif ($total < $min_purchase) {
                        $resultMsg = trans('frontend.Coupon Minimum Purchase Does Not Match');
                    } elseif ($discount > $total) {
                        $resultMsg = trans('coupons.Invalid Request');
                    } elseif ($coupon->category == 2 && count($checkout->carts) != 1) {
                        $resultMsg = trans('coupons.This coupon apply for single Program');
                    } elseif ($coupon->category == 2 && $checkout->carts[0]->program_id != $coupon->program_id) {
                        $resultMsg = trans('coupons.This coupon is not valid for this Program');
                    } elseif ($coupon->category == 3 && $coupon->coupon_user_id != $checkout->user_id) {
                        $resultMsg = trans('coupons.This coupon not for you');
                    } elseif ($cart_type == 'subscription' && $coupon->category != 1) {
                        $resultMsg = trans('frontend.Invalid Coupon');
                    } else {
                        $couponApply = true;
                        $resultMsg = trans("frontend.Coupon Successfully Applied");
                    }
                }
            } else {
                $checkout->discount = 0;
                $checkout->coupon_id = null;
                $checkout->purchase_price = $request->total;
                $checkout->save();
                $resultMsg = trans('frontend.Invalid Coupon');
            }

            if ($couponApply) {


                $final = ($total - $discount);
                $checkout->discount = $discount;
                $checkout->purchase_price = $final;

                if (hasTax()) {
                    $tax = taxAmount($request->total);
                    $total = applyTax($request->total);
                    $checkout->tax = $tax;
                } else {
                    $total = $request->total;
                }

                $checkout->tracking = $tracking;
                $checkout->purchase_price = getPriceAsNumber($final);
                $checkout->user_id = Auth::id();
                $checkout->coupon_id = $coupon->id;
                $checkout->price = $total;
                $checkout->status = 0;
                $checkout->save();


                return response()->json([
                    'success' => $resultMsg,
                    'total' => number_format(getPriceAsNumber($final), 2),
                    'tax' => number_format(getPriceAsNumber($tax), 2),
                    'discount' => number_format(getPriceAsNumber($discount), 2)
                ]);
            } else {
                return response()->json([
                    'error' => $resultMsg,
                    'total' => number_format(getPriceAsNumber($total), 2),
                    'tax' => number_format(getPriceAsNumber($tax), 2),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => trans('common.Operation Failed')]);
        }
    }

    private function membershipCoupon($coupon)
    {
        if (!isModuleActive('Membership')) {
            return false;
        }
        $tracking = SubscriptionCart::where('user_id', Auth::id())->first()->tracking;
        $checkout = SubscriptionCheckout::where('tracking', $tracking)->first();
        if (empty($checkout)) {
            $checkout = new SubscriptionCheckout();
        }
        $checkTrackingId = SubscriptionCheckout::where('tracking', $tracking)->where('coupon_id', $coupon)->first();
    }

    public function CheckOut(Request $request)
    {
        if (onlySubscription()) {
            return redirect('/');
        }


        try {
            $carts = Cart::where('user_id', Auth::id())->count();
            $user = Auth::user();
            $certificate_order = session()->get('order_type');
            $invoice = session()->get('invoice');
            if ($carts == 0 && (!$certificate_order || !$invoice)) {
                return redirect('/');
            }

            //            if (isModuleActive('Org')) {
            //                $carts = Cart::where('user_id', Auth::id())->with('program', 'program.user')->get();
            //                $total = Cart::where('user_id', Auth::user()->id)->sum('price');
            //                if ($total == 0) {
            //                    foreach ($carts as $cart) {
            //                        if (!$cart->program->isLoginUserEnrolled) {
            //                            $enroll = new CourseEnrolled();
            //                            $enroll->user_id = \auth()->id();
            //                            $enroll->tracking = 1;
            //                            $enroll->program_id = $cart->program->id;
            //                            $enroll->purchase_price = 0;
            //                            $enroll->coupon = null;
            //                            $enroll->discount_amount = 0;
            //                            $enroll->status = 1;
            //                            $enroll->save();
            //                            $program = $cart->program;
            //                            $program->total_enrolled = $program->total_enrolled + 1;
            //                            $program->save();
            //
            ////                            if (isModuleActive('Chat')) {
            ////                                event(new OneToOneConnection($program->user, $user, $program));
            ////                            }
            ////                            if (isModuleActive('Survey')) {
            ////                                $hasSurvey = Survey::where('course_id', $program->id)->get();
            ////                                foreach ($hasSurvey as $survey) {
            ////                                    $surveyController = new SurveyController();
            ////                                    $surveyController->assignSurvey($survey, $user);
            ////                                }
            ////                            }
            ////                            if (isModuleActive('Affiliate')) {
            ////                                if ($user->isReferralUser) {
            ////                                    Event::dispatch(new ReferralPayment($user->id, $course->id, $course->price));
            ////                                }
            ////                            }
            //                        }
            //                        $cart->delete();
            //                    }
            //
            //                    Toastr::success(trans('org.Enrolled Successfully'), trans('common.Success'));
            //                    if (Session::exists('back')) {
            //                        return redirect(Session::get('back'));
            //                    } else {
            //                        return redirect()->route('studentDashboard');
            //                    }
            //                }
            //            }

            return view(theme('pages.checkout'), compact('request'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function removeProfilePic()
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        try {
            $user = User::find(Auth::user()->id);
            $user->image = '';
            $user->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function getCertificate($id, $slug, Request $request)
    {
        $course = Course::findOrFail($id);
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

        if (!$certificate) {
            Toastr::error(trans('certificate.Right Now You Cannot Download The Certificate'));
            return back();
        }

        if (!$course->isLoginUserEnrolled) {
            Toastr::error(trans('certificate.You Are Not Already Enrolled This course. Please Enroll It First'));
            return back();
        }
        if ($course->type == 1) {
            $percentage = round($course->loginUserTotalPercentage);
            if ($percentage < 100) {
                Toastr::error(trans('certificate.Please Complete The Course First'));
                return back();
            }
        } elseif ($course->type == 2) {
            $quiz = QuizTest::where('course_id', $course->id)->where('pass', 1)->first();
            if (!$quiz) {
                Toastr::error(trans('certificate.You must pass the quiz'));
                return back();
            }
        } else {
            $certificateCanDownload = false;
            $totalClass = $course->class->total_class;
            $completeClass = ClassComplete::where('course_id', $course->id)->where('class_id', $course->class->id)->count();
            if ($totalClass == $completeClass) {
                $hasCertificate = $course->certificate_id;
                if (!empty($hasCertificate)) {
                    $certificate = Certificate::find($hasCertificate);
                    if ($certificate) {
                        $certificateCanDownload = true;
                    }
                } else {
                    $certificate = Certificate::where('for_class', 1)->first();
                    if ($certificate) {
                        $certificateCanDownload = true;
                    }
                }
            }
            if (!$certificateCanDownload) {
                Toastr::error(trans('certificate.You must attend live class'));
                return back();
            }
        }


        $title = "{$course->slug}-certificate-for-" . Auth::user()->name . ".jpg";

        $downloadFile = new CertificateController();
        $websiteController = new WebsiteController();
        try {
            $certificate_record = $websiteController->getCertificateRecord($course->id);

            $request->certificate_id = $certificate_record->certificate_id;
            $request->course = $course;
            $request->user = Auth::user();
            $certificate = $downloadFile->makeCertificate($certificate->id, $request)['image'] ?? '';


            if (Settings('frontend_active_theme') == 'tvt' && empty(\request('download'))) {
                $url = $certificate->encode('data-url');
                return view(theme('pages.certificate-preview'), compact('url', 'course'));
            }


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

    public function submitReview(Request $request)
    {
        Session::flash('selected_tab', 'review');
        $this->validate($request, [
            'review' => 'required',
            'rating' => 'required'
        ]);

        try {
            $user_id = Auth::user()->id;

            $review = CourseReveiw::where('user_id', $user_id)->where('course_id', $request->course_id)->first();

            if (is_null($review)) {

                $newReview = new CourseReveiw();
                $newReview->user_id = $user_id;
                $newReview->course_id = $request->course_id;
                $newReview->comment = $request->review;
                $newReview->star = $request->rating;
                $newReview->save();

                $course = Course::find($request->course_id);
                $total = CourseReveiw::where('course_id', $course->id)->sum('star');
                $count = CourseReveiw::where('course_id', $course->id)->where('status', 1)->count();
                $average = $total / $count;
                $course->reveiw = $average;
                $course->total_rating = $average;
                $course->save();


                $course_user = User::findOrFail($course->user_id);
                $user_courses = Course::where('user_id', $course_user->id)->get();
                $user_total = 0;
                $user_rating = 0;
                foreach ($user_courses as $u_course) {
                    $total = CourseReveiw::where('course_id', $u_course->id)->sum('star');
                    $count = CourseReveiw::where('course_id', $u_course->id)->where('status', 1)->count();
                    if ($total != 0) {
                        $user_total = $user_total + 1;
                        $average = $total / $count;
                        $user_rating = $user_rating + $average;
                    }
                }
                if ($user_total != 0) {
                    $user_rating = $user_rating / $user_total;
                }
                $course_user->total_rating = $user_rating;
                $course_user->save();

                $total = CourseReveiw::where('course_id', $course->id)->sum('star');
                $count = CourseReveiw::where('course_id', $course->id)->where('status', 1)->count();
                $average = $total / $count;
                $course->reveiw = $average;
                $course->total_rating = $average;
                $course->save();

                checkGamification('each_review', 'rating', $course_user);

                if (UserEmailNotificationSetup('Course_Review', $course->user)) {
                    SendGeneralEmail::dispatch($course->user, 'Course_Review', [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'review' => $newReview->comment,
                        'star' => $newReview->star,
                    ]);
                }
                if (UserBrowserNotificationSetup('Course_Review', $course->user)) {
                    send_browser_notification(
                        $course->user,
                        'Course_Review',
                        [
                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $course->title,
                            'review' => $newReview->comment,
                            'star' => $newReview->star,
                        ],
                        trans('common.View'),
                        courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                    );
                }

                if (UserMobileNotificationSetup('Course_Review', $course->user) && !empty($course->user->device_token)) {
                    send_mobile_notification($course->user, 'Course_Review', [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'review' => $newReview->comment,
                        'star' => $newReview->star,
                    ]);
                }
                if (isModuleActive('Org')) {
                    addOrgRecentActivity(\auth()->id(), $course->id, 'Review');
                }
                Toastr::success(trans('student.Review Submit Successfully'), trans('common.Success'));
                return redirect()->back();
            } else {

                Toastr::error(trans('student.Invalid Action'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function submitTutorReview(Request $request)
    {
        Session::flash('selected_tab', 'review');
        $this->validate($request, [
            'review' => 'required',
            'rating' => 'required'
        ]);

        try {
            $user_id = Auth::user()->id;

            $review = TutorReveiws::where('user_id', $user_id)->where('instructor_id', $request->tutor_id)->first();

            if (is_null($review)) {

                $newReview = new TutorReveiws();
                $newReview->user_id = $user_id;
                $newReview->instructor_id = $request->tutor_id;
                $newReview->comment = $request->review;
                $newReview->status = 1;
                $newReview->star = $request->rating;
                $newReview->save();

                $tutor = User::find($request->tutor_id);
                $total = TutorReveiws::where('instructor_id', $request->tutor_id)->sum('star');
                $count = TutorReveiws::where('instructor_id', $request->tutor_id)->where('status', 1)->count();
                $average = $total / $count;
                $tutor->total_tutor_rating = $average;
                $tutor->save();


//                $course_user = User::findOrFail($course->user_id);
//                $user_courses = Course::where('user_id', $course_user->id)->get();
//                $user_total = 0;
//                $user_rating = 0;
//                foreach ($user_courses as $u_course) {
//                    $total = CourseReveiw::where('course_id', $u_course->id)->sum('star');
//                    $count = CourseReveiw::where('course_id', $u_course->id)->where('status', 1)->count();
//                    if ($total != 0) {
//                        $user_total = $user_total + 1;
//                        $average = $total / $count;
//                        $user_rating = $user_rating + $average;
//                    }
//                }
//                if ($user_total != 0) {
//                    $user_rating = $user_rating / $user_total;
//                }
//                $course_user->total_rating = $user_rating;
//                $course_user->save();
//
//                $total = CourseReveiw::where('course_id', $course->id)->sum('star');
//                $count = CourseReveiw::where('course_id', $course->id)->where('status', 1)->count();
//                $average = $total / $count;
//                $course->reveiw = $average;
//                $course->total_rating = $average;
//                $course->save();
//
//                checkGamification('each_review', 'rating', $course_user);
//
//                if (UserEmailNotificationSetup('Course_Review', $course->user)) {
//                    SendGeneralEmail::dispatch($course->user, 'Course_Review', [
//                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
//                        'course' => $course->title,
//                        'review' => $newReview->comment,
//                        'star' => $newReview->star,
//                    ]);
//                }
//                if (UserBrowserNotificationSetup('Course_Review', $course->user)) {
//                    send_browser_notification(
//                        $course->user,
//                        'Course_Review',
//                        [
//                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
//                            'course' => $course->title,
//                            'review' => $newReview->comment,
//                            'star' => $newReview->star,
//                        ],
//                        trans('common.View'),
//                        courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
//                    );
//                }
//
//                if (UserMobileNotificationSetup('Course_Review', $course->user) && !empty($course->user->device_token)) {
//                    send_mobile_notification($course->user, 'Course_Review', [
//                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
//                        'course' => $course->title,
//                        'review' => $newReview->comment,
//                        'star' => $newReview->star,
//                    ]);
//                }
//                if (isModuleActive('Org')) {
//                    addOrgRecentActivity(\auth()->id(), $course->id, 'Review');
//                }
                Toastr::success(trans('student.Review Submit Successfully'), trans('common.Success'));
                return redirect()->back();
            } else {

                Toastr::error(trans('student.Invalid Action'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function myReports(Request $request)
    {
        try {
            return view(theme('pages.myReports'), compact('request'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function enrollmentCancellation(Request $request)
    {
        try {
            return view(theme('pages.enrollmentCancellation'), compact('request'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function enrollmentCancellationSubmit(Request $request)
    {
        $this->validate($request, [
            'course' => 'required',
        ]);

        $adminController = new AdminController();
        $adminController->enrollDelete($request->course, $request);


        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function leaderboard(Request $request)
    {
        try {
            $type = $request->type;
            $limit = $request->get('limit');

            $query = User::select('id', 'name', 'image', 'gamification_points', 'gamification_total_points', 'user_level');
            if ($limit) {
                $query->limit($limit);
                $data['modal'] = 1;
            } else {
                $data['modal'] = 0;
            }

            if ($type == 'level') {
            } elseif ($type == 'badge') {
                $query->withCount('userBadges');
            } elseif ($type == 'courses') {
                $query->withCount('studentCourses');
            } elseif ($type == 'certificate') {
                $query->withCount('certificateRecords');
            }
            $data['students'] =
                $query->where('status', 1)
                ->where('role_id', 3)
                ->where('teach_via', 1)
                ->orderBy('gamification_total_points', 'desc')
                ->get();

            if ($type == 'show_badge') {
                $data['student'] =
                    User::select('id', 'name', 'image', 'gamification_points', 'gamification_total_points', 'user_level')
                    ->whereHas('userBadges.badge', function ($q) {
                        $q->where('status', 1);
                    })
                    ->with('userBadges', 'userBadges.badge')
                    ->withCount('userBadges')
                    ->where('id', $request->id)->first();
            }
            $data['type'] = $type;
            return view(theme('partials._leaderboard'), $data);
        } catch (\Exception $exception) {
            return '';
        }
    }

    public function rewardPontConvert()
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        if (Settings('gamification_status') && Settings('gamification_reward_point_conversion_status') && Settings('gamification_reward_status')) {
            $user = Auth::user();
            $total = $user->gamification_total_points;
            $spent = $user->gamification_total_spent_points;
            $current = $total - $spent;

            if ($current < 1) {
                Toastr::error(trans('frontend.Insufficient Point'), trans('common.Failed'));
                return redirect()->back();
            }

            $user->gamification_total_spent_points = $spent + $current;

            $user->save();

            UserGamificationPoint::create([
                'user_id' => $user->id,
                'type' => 'convert',
                'badge_type' => 'reward',
                'point' => $current,
                'status' => 2,
            ]);


            $balance = $current / Settings('gamification_reward_point_conversion_rate');

            $tran = new OfflinePayment();
            $new = $user->balance + $balance;
            $tran->user_id = $user->id;
            $tran->role_id = $user->role_id;
            $tran->amount = $balance;
            $tran->status = 1;
            $tran->type = 'Reward';
            $tran->after_bal = $new;
            $tran->save();
            $user->balance = $new;
            $user->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        } else {
            Toastr::error(trans('common.Something Went Wrong'), trans('common.Failed'));
        }


        return redirect()->back();
    }
}
