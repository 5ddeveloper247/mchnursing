<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CloverController;
use App\Http\Controllers\Controller;
use App\Models\UserApplication;
use App\Models\UserAuthorzIationAgreement;
use App\Models\UserSetting;
use App\Repositories\UserRepositoryInterface;
use App\StudentCustomField;
use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\FrontendManage\Entities\LoginPage;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use ImageStore;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //    protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/register2';
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if (saasEnv('nocaptcha_for_reg')) {
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'g-recaptcha-response' => 'required|captcha'
            ];
        } else {
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'phone' => 'required|nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'f_name' => 'required',
                'l_name' => 'required',
                'dob' => 'required',
                'SS' => 'required',
                'city' => 'required',
                'state' => 'required',
                'Zip' => 'required',
                'mailing_address' => 'required',
                'program_review' => 'required',
                'student_signature' => 'required',
                'student_signature_date' => 'required',

            ];
        }

        if (isset($data['is_lms_signup'])) {
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'institute_name' => ['required', 'string', 'max:255'],
                'domain' => ['required', 'string', 'max:20', 'unique:lms_institutes'],
            ];
        }
        if (isset($data['type']) && $data['type'] == "Instructor") {
            $rules = [
                'instructor_position_id' => 'required',
                'instructor_hear_id' => 'required',
                //                'start_date' => 'required',
                'first_name' => 'required',
                //                'middle_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'date_of_birth' => 'required',
                'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'cell' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|string',
                //                'work' => 'required',
                'address' => 'required',
                'high_school' => 'required',
                'school_years_attended' => 'required',
                'school_year_graduate' => 'required',
                'school_degree' => 'required',
                'college' => 'required',
                'college_email' => 'required',
                'college_graduate' => 'required',
                'trade_school' => 'required',
                'trade_degree' => 'required',
                'trade_years_attended' => 'required',
                'trade_year_graduate' => 'required',
                //                'current_position' => 'required',
                //                'Teach_phone' => 'required',
                //                'employee_name' => 'required',
                //                'date_employer' => 'required',
                //                'supervisor_name' => 'required',
                'upload_resume' => 'required',
                'cover' => 'required',
                //                'employer_address' => 'required',

            ];
        }
        if (currentTheme() == 'tvt') {
            $rules['level'] = ['required'];
        }
        return Validator::make(
            $data,
            $rules,
            validationMessage($rules)
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $status = 1;
        if (isset($data['type']) && $data['type'] == "Instructor") {
            $status = 0;
            $role = 2;
        } else {
            $role = 3;
        }
        if (isset($data['is_lms_signup'])) {
            $role = 1;
        }

        if (empty($data['phone'])) {
            $data['phone'] = null;
        }
        $password = null;
        if (isset($data['password'])) {
            $password = Hash::make($data['password']);
        }

        return $this->userRepository->create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'role_id' => $role,
            'dob' => $data['dob'] ?? null,
            'gender' => $data['gender'] ?? null,
            'student_type' => $data['student_type'] ?? null,
            'job_title' => $data['job_title'] ?? null,
            'identification_number' => $data['identification_number'] ?? null,
            'company' => $data['company'] ?? null,
            'password' => $password,
            'language_id' => Settings('language_id') ?? '19',
            'language_name' => Settings('language_name') ?? 'English',
            'language_code' => Settings('language_code') ?? 'en',
            'language_rtl' => Settings('language_rtl') ?? '0',
            'country' => Settings('country_id'),
            'username' => null,
            'status' => $status,
            'is_lms_signup' => $data['is_lms_signup'] ?? null,
            'institute_name' => $data['institute_name'] ?? null,
            'domain' => str_replace(' ', '', $data['domain'] ?? null),
            'referral' => generateUniqueId(),
            'level' => $data['level'] ?? '',
        ]);
    }

    public function seveUserSetting(Request $request)
    {

        $program_review = json_encode($request->program_review);
        $userSetting = UserSetting::where('user_id', $request->user_id);
        if (!$userSetting->count()) {
            $userSetting = new UserSetting;
        } else {
            $userSetting = $userSetting->first();
        }
        $userSetting->f_name = $request->f_name;
        $userSetting->l_name = $request->l_name;
        $userSetting->SS = $request->SS;
        $userSetting->mailing_address = $request->mailing_address;
        $userSetting->program_review = $program_review;
        $userSetting->student_signature = $request->student_signature;
        $userSetting->student_signature_date = $request->student_signature_date;
        $userSetting->city = $request->city;
        $userSetting->state = $request->state;
        $userSetting->user_id = $request->user_id;
        $userSetting->save();
        return $userSetting;
    }

    public function RegisterForm()
    {
        abort_if(!Settings('student_reg'), 404);
        abort_if(saasPlanCheck('student'), 404);
        $page = LoginPage::getData();
        $custom_field = StudentCustomField::getData();
        return view(theme('auth.register'), compact('page', 'custom_field'));
    }

    public function RegisterForm2()
    {
        abort_if(!Settings('student_reg'), 404);
        abort_if(saasPlanCheck('student'), 404);
        if (!session()->has('user')) {
            return redirect()->to(route('register'));
        }
        $user = session()->get('user');
        $userSetting = session()->get('userSetting');
        $page = LoginPage::getData();
        return view(theme('auth.register2'), compact('page', 'user', 'userSetting'));
    }

    public function RegisterForm3()
    {
        abort_if(!Settings('student_reg'), 404);
        abort_if(saasPlanCheck('student'), 404);

        if (!session()->has('user')) {
            return redirect()->to(route('register'));
        }
        $user = session()->get('user');
        $userSetting = session()->get('userSetting');
        $payment_detials = session()->get('payment_detials');
        $page = LoginPage::getData();

        return view(theme('auth.register3'), compact('page', 'user', 'userSetting', 'payment_detials'));
    }

    public function RegisterFormPay()
    {

        abort_if(!Settings('student_reg'), 404);
        abort_if(saasPlanCheck('student'), 404);
        if (!session()->has('user')) {
            return redirect()->to(route('register'));
        }
        $clover = new CloverController();
        $pakms = $clover->getPakmsKey();

        try {
            $user = session()->get('user');
            $page = LoginPage::getData();
            return view(theme('auth.register-pay'), compact('page', 'user', 'pakms'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function LmsRegisterForm()
    {

        abort_if(!isModuleActive('LmsSaas') && !isModuleActive('LmsSaasMD'), 404);
        abort_if(SaasDomain() != 'main', 404);
        $page = LoginPage::getData();
        $custom_field = StudentCustomField::getData();
        return view(theme('auth.lms_register'), compact('page', 'custom_field'));
    }

    public function showRegistrationForm()
    {
        $page = LoginPage::getData();
        return view(theme('auth.register'), compact('page'));
    }

    public function RegisterForm2Create(Request $request)
    {

        $rules = [
            'term_one_text' => 'required',
            'invoice_date_one' => 'required',
            'invoice_date_two' => 'required',
            'term_two_text' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'fax' => 'required',
            'city' => 'required',
            'state' => 'required',
            'Zip' => 'required',
            'country' => 'required',
            'payment_type' => 'required',
            'credit_card_no' => 'required',
            'exp_date' => 'required',
            'card_appears_name' => 'required',
            'digit_on_back' => 'required',
            'dollar_amount' => 'required',
            'stgnature' => 'required',
            'paid_bill_date' => 'required',
            'paid_bill' => 'required',
            'student_signature' => 'required',
            'student_signature_date' => 'required',
            'user_id' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));
        $userApplication = UserApplication::where('user_id', $request->user_id);

        if (!$userApplication->count()) {
            $userApplication = new UserApplication;
        } else {
            $userApplication = $userApplication->first();
        }

        $userApplication->term_one_text = $request->term_one_text;
        $userApplication->invoice_date_one = $request->invoice_date_one;
        $userApplication->invoice_date_two = $request->invoice_date_two;
        $userApplication->term_two_text = $request->term_two_text;
        $userApplication->name = $request->name;
        $userApplication->phone = $request->phone;
        $userApplication->address = $request->address;
        $userApplication->fax = $request->fax;
        $userApplication->city = $request->city;
        $userApplication->state = $request->state;
        $userApplication->Zip = $request->Zip;
        $userApplication->country = $request->country;
        $userApplication->payment_type = $request->payment_type;
        $userApplication->credit_card_no = $request->credit_card_no;
        $userApplication->exp_date = $request->exp_date;
        $userApplication->card_appears_name = $request->card_appears_name;
        $userApplication->digit_on_back = $request->digit_on_back;
        $userApplication->dollar_amount = $request->f_name;
        $userApplication->stgnature = $request->stgnature;
        $userApplication->paid_bill_date = $request->paid_bill_date;
        $userApplication->paid_bill = $request->paid_bill;
        $userApplication->student_signature = $request->student_signature;
        $userApplication->student_signature_date = $request->student_signature_date;
        $userApplication->user_id = $request->user_id;
        $userApplication->save();

        session()->put('payment_detials', $userApplication);
        return redirect()->to(route('register.3'));
    }

    public function RegisterForm3Create(Request $request)
    {
        // dd($request->all());

        // $rules = [
        //     'applican_name' => 'required',
        //     'authorized_representative' => 'required',
        //     'address' => 'required',
        //     'applicant_signature' => 'required',
        //     'date' => 'required',
        //     'state' => 'required',
        //     'country' => 'required',
        //     'day' => 'required',
        //     'age' => 'required',
        //     'name' => 'required',
        //     'by' => 'required',
        //     'whose_identity' => 'required',
        //     'notary_signature' => 'required',
        //     'printed_name' => 'required',
        //     'user_id' => 'required'
        // ];
        // $this->validate($request, $rules, validationMessage($rules));

        $AuthorzIationAgreement = UserAuthorzIationAgreement::where('user_id', $request->user_id);
        if (!$AuthorzIationAgreement->count()) {
            $AuthorzIationAgreement = new UserAuthorzIationAgreement;
        } else {
            $AuthorzIationAgreement = $AuthorzIationAgreement->first();
        }

        // $AuthorzIationAgreement->applican_name = $request->applican_name;
        // $AuthorzIationAgreement->authorized_representative = $request->authorized_representative;
        // $AuthorzIationAgreement->address = $request->address;
        // $AuthorzIationAgreement->applicant_signature = $request->applicant_signature;
        // $AuthorzIationAgreement->date = $request->date;
        // $AuthorzIationAgreement->state = $request->state;
        // $AuthorzIationAgreement->country = $request->country;
        // $AuthorzIationAgreement->day = $request->day;
        // $AuthorzIationAgreement->age = $request->age;
        // $AuthorzIationAgreement->name = $request->name;
        // $AuthorzIationAgreement->by = $request->by;
        // $AuthorzIationAgreement->whose_identity = $request->whose_identity;
        // $AuthorzIationAgreement->notary_signature = $request->notary_signature;
        // $AuthorzIationAgreement->printed_name = $request->printed_name;
        $AuthorzIationAgreement->user_id = (int)$request->user_id;
        // $AuthorzIationAgreement->user_form = null;

        $AuthorzIationAgreement->save();

        return redirect()->to(route('register.pay'));
    }

    public function RegisterFormPayCreate(Request $request)
    {
        try {

            $clover = new CloverController();

            if ($clover->makePayment($request, 'student_register')) {
                session()->forget('user');
                Toastr::success('Payment Successfully Done', 'Success');
                return redirect()->to(route('login'));
            } else {
                Toastr::error('Something Went Wrong', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {

            Toastr::error('Something Went Wrong', 'Error');
            return redirect()->back();
        }
    }

    //    save instructors info
    public function saveInstructorsInfo(Request $request, $file)
    {

        $exception = DB::transaction(function () use ($request, $file) {
            //            become_instructors_form_data
            DB::table('become_instructors_form_data')->insert([
                'user_id' => $request->user_id,
                'instructor_position_id' => $request->instructor_position_id,
                'instructor_hear_id' => $request->instructor_hear_id,
                'start_date' => $request->start_date,
                'created_at' => Carbon::now(),

            ]);

            //            instructors_personal_info
            DB::table('instructors_personal_info')->insert([
                'user_id' => $request->user_id,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'email' => $request->email,
                'phone' => $request->phone,
                'cell' => $request->cell,
                'work' => $request->work,
                'address' => $request->address,
                'created_at' => Carbon::now(),
            ]);

            //            instructors_school_info
            DB::table('instructors_school_info')->insert([
                'user_id' => $request->user_id,
                'high_school' => $request->high_school,
                'school_years_attended' => $request->school_years_attended,
                'school_year_graduate' => $request->school_year_graduate,
                'school_degree' => $request->school_degree,
                'college' => $request->college,
                'email' => $request->college_email,
                'college_graduate' => $request->college_graduate,
                'trade_school' => $request->trade_school,
                'trade_degree' => $request->trade_degree,
                'trade_years_attended' => $request->trade_years_attended,
                'trade_year_graduate' => $request->trade_year_graduate,
                'created_at' => Carbon::now(),
            ]);

            //            instructors_teaching_experience
            DB::table('instructors_teaching_experience')->insert([
                'user_id' => $request->user_id,
                'current_position' => $request->current_position,
                'phone' => $request->Teach_phone,
                'employee_name' => $request->employee_name,
                'date_employer' => $request->date_employer,
                'supervisor_name' => $request->supervisor_name,
                'upload_resume' => $file,
                'cover' => $request->cover,
                'address' => $request->employer_address,
                'created_at' => Carbon::now(),
            ]);
        });
        return is_null($exception) ? true : false;
    }


    public function register(Request $request)
    {

        if (isModuleActive('LmsSaasMD')) {
            ini_set('max_execution_time', 10000);
        }
        //for student
        if (isset($request->f_name) && isset($request->l_name)) {
            $name = $request->f_name . ' ' . $request->l_name;
            $request->request->add(['name' => $name]);
        }
        //for instructors
        if (isset($request->first_name) && isset($request->last_name)) {
            $name = $request->first_name . ' ' . $request->last_name;
            $request->request->add(['name' => $name]);
        }
        //for validate and create user
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        // for student
        $request->request->add(['user_id' => $user->id]);
        if (isset($request->is_user_setting)) {
            $userSetting = $this->seveUserSetting($request);
            session()->put(['userSetting' => $userSetting]);
        }

        //for instructors
        if (isset($request->type) && $request->type == "Instructor") {
            //            save instructors info
            $file = $this->saveFile($request->file('upload_resume'));
            if ($this->saveInstructorsInfo($request, $file)) {
                Toastr::success('Data Successfully submit', 'Success');
                return redirect()->back();
            }

            unlink(asset($file));
            Toastr::success('Some Sever Error', 'Error');
            return redirect()->back();
        }

        session()->put(['user' => $user]);
        return redirect()->to(route('register.2'));


        //        if (isModuleActive('LmsSaasMD') && !empty($user->institute) && $user->institute->status == 0) {
        //            $maintain = collect();
        //            $maintain->maintenance_title = trans('saas.View Title');
        //            $maintain->maintenance_sub_title = trans('saas.View Sub Title');
        //            $maintain->maintenance_banner = HomeContents('maintenance_banner');
        //            return new response(view(theme('pages.maintenance'), compact('maintain')));
        //        }
        //        if (isModuleActive('LmsSaasMD') && !empty($user->institute) && $user->institute->domain != SaasDomain()) {
        //            if ($user->lms_id != 1) {
        //                $token = md5(uniqid());
        //                Storage::put($token, $request->email . '|' . $request->password);
        //                $url = 'http://' . $user->institute->domain . '.' . config('app.short_url') . '/login?token=' . $token;
        //                return redirect()->to($url);
        //            }
        //        }
        //        if (isModuleActive('LmsSaas') && !empty($user->institute) && $user->institute->domain != SaasDomain()) {
        //            if ($user->lms_id != 1) {
        //                $token = md5(uniqid());
        //                Storage::put($token, $request->email . '|' . $request->password);
        //                $url = 'http://' . $user->institute->domain . '.' . config('app.short_url') . '/login?token=' . $token;
        //                return redirect()->to($url);
        //            }
        //        }
        //
        //        event(new Registered($user));
        //
        //        $this->guard()->login($user);
        //        if ($user->role_id == 3) {
        //            $loginController = new LoginController();
        //            $loginController->multipleLogin($request);
        //        }


        //        if ($response = $this->registered($request, $user)) {
        //            return $response;
        //        }
        //
        //        return $request->wantsJson()
        //            ? new JsonResponse([], 201)
        //            : redirect($this->redirectPath());
    }
}
