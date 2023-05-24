<?php

namespace Modules\StudentSetting\Http\Controllers;


use App\Jobs\SendGeneralEmail;
use App\Models\UserApplication;
use App\Models\UserAuthorzIationAgreement;
use App\Models\UserSetting;
use App\Traits\ImageStore;
use Carbon\Carbon;
use App\User;
use App\Subscription;
use App\StudentCustomField;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use DrewM\MailChimp\MailChimp;
use App\Events\OneToOneConnection;
use Modules\Org\Entities\OrgBranch;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Modules\Org\Entities\OrgPosition;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Modules\Group\Entities\GroupMember;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\File;
use Modules\Payment\Entities\PaymentPlans;
use Modules\SkillAndPathway\Entities\GroupStudent;
use Modules\StudentSetting\Entities\Program;
use Yajra\DataTables\Facades\DataTables;
use Modules\CourseSetting\Entities\Course;
use Modules\Payment\Entities\InstructorPayout;
use Modules\Group\Repositories\GroupRepository;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Newsletter\Entities\NewsletterSetting;
use Modules\Newsletter\Http\Controllers\AcelleController;
use Modules\Survey\Entities\Survey;
use Modules\Survey\Http\Controllers\SurveyController;
use Modules\FrontendManage\Entities\HomePageFaq;
use Modules\Payment\Entities\Checkout;

class StudentSettingController extends Controller
{
    use ImageStore;

    public function index()
    {
        try {
            $students = [];

            if (isModuleActive('Org')) {
                $data['positions'] = OrgPosition::orderBy('order', 'asc')->get();
                $data['branches'] = OrgBranch::orderBy('order', 'asc')->get();
                return view('org::students.org_student_list', $data);
            }
            return view('studentsetting::student_list', compact('students'));
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function storeAgreementForm(Request $request)
    {
        if (empty($request->file('agreement_form'))) {
            return  $this->formUploadResponse(422, 'error', '#', 'Please Select Form !');
        }

        $extension = $request->file('agreement_form')->extension();
        $allow_ext = ['doc', 'docx', 'pdf'];

        if (!in_array(strtolower($extension), $allow_ext)) {
            return  $this->formUploadResponse(422, 'error', '#', 'Invalid File Extension, Allow Extensions (DOC, DOCS, PDF) !');
        }

        $file_path = $this->saveFile($request->file('agreement_form'));

        if (!$file_path) {
            return  $this->formUploadResponse(422, 'error', '#', 'Form Not Uploaded, Please Try Again !');
        }

        return $this->formUploadResponse(200, 'success', $file_path, 'File SuccessFully Uploaded, Thank you !');
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

    public static function saveFile($file)
    {
        if (isset($file)) {
            if (!File::isDirectory('public/student_affidavit/agreement_form')) {
                File::makeDirectory('public/student_affidavit/agreement_form', 0777, true, true);
            }
            $new_file_name = 'Agreement_file' . '.' . $file->clientExtension();
            $file_path = 'public/student_affidavit/agreement_form/' . $new_file_name;
            $file->move(public_path('student_affidavit/agreement_form/'), $new_file_name);
            return $file_path;
        } else {
            return null;
        }
    }

    public function changeStudentFormStatus(Request $request)
    {
        $user = UserAuthorzIationAgreement::where('user_id', $request->student_id)->first();
        $user->status = $request->status;
        $user->save();

        if ($user) {
            return response()->json([
                'status' => 200,
                'state' => 'success',
                'message' => 'Operation Successful !',
            ]);
        }
    }

    public function getProgram($id)
    {
        $program = Program::find($id, ['id', 'programtitle', 'totalcost']);
        return response()->json(["id" => $program->id, "programtitle" => $program->programtitle, "totalcost" => $program->totalcost], 200);
        //        return response()->json($program,200);
    }
    public function getAllProgram(Request $request)
    {

        $querys = Program::all();

        $data = [];
        $alldata = [];
        foreach ($querys as $query) {
            $data["id"] = $query->id;
            $data["programtitle"] = $query->programtitle;
            $data["totalcost"] = $query->totalcost;
            $data["duration"] = $query->duration;
            $data["allcourses"] = $query->allcourses;
            $data["user_id"] = $query->user_id;
            $data["image"] = $query->image;
            $data["status"] = $query->status;
            $alldata[$query->id] = $data;
            $data = [];
        }
        $query = $alldata;

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($query) {
                return view('studentsetting::partials._td_image_program', compact('query'));
            })
            ->editColumn('programtitle', function ($query) {
                return $query['programtitle'];
            })
            ->editColumn('totalcost', function ($query) {

                return $query['totalcost'];
            })
            ->editColumn('duration', function ($query) {

                return $query['duration'];
            })
            ->editColumn('numberofcourses', function ($query) {

                return count(json_decode($query['allcourses']));
            })
            ->addColumn('status', function ($query) {
                $data = (object)[];
                $data->id = $query['id'];
                $data->status = $query['status'];
                $query = $data;
                $route = 'student.change_status';
                return view('backend.partials._td_status', compact('query', 'route'));
            })
            ->addColumn('action', function ($query) {

                return view('studentsetting::partials._td_action_program', compact('query'));
            })
            ->rawColumns(['programtitle'])
            ->make(true);
    }

    public function add_new()

    {
        $courses = Course::where('status', 1)->where('type', 1)->get();
        $faqs = HomePageFaq::orderBy('order', 'asc')->where('status', 1)->get();
        return view('studentsetting::All_program', compact('courses', 'faqs'));
    }


    public function addprogram(Request $request)
    {

        $rules = [
            'ProgramTitle' => 'required|max:15|unique:programs',
            'subtitle' => 'required|max:20',
            'image' => 'required',
            'totalcost' => 'required',
            'duration' => 'required',
            'requirements' => 'required',
            'description' => 'required',
            'allcourses' => 'required',
            'Payment_plan' => 'required'
        ];
        $this->validate($request, $rules, validationMessage($rules));


        $extensions = ["png", "jpg", "jpeg"];
        $result = strtolower($request->image->getClientOriginalExtension());
        if (!in_array($result, $extensions)) {
            Toastr::error('Invalid File Extension. Allow PNG,JPG,JPEG format', 'Failed');
            return redirect()->back();
        }
        try {

            DB::beginTransaction();
            $courses = (json_encode($request->allcourses) != null) ? json_encode($request->allcourses) : [];
            $faqs = (json_encode($request->faqs)  != null) ? json_encode($request->allcourses) : [];

            $programm = new Program;

            $programm->programtitle = $request->ProgramTitle;
            $programm->subtitle = $request->subtitle;
            $programm->totalcost = $request->totalcost;
            $programm->duration = $request->duration;
            $programm->requirement = $request->requirements;
            $programm->discription = $request->description;
            $programm->outcome = $request->outcome;
            $programm->numberofcourses = 0;
            $programm->allcourses = $courses;
            $programm->faqs = $faqs;
            $programm->payment_plan = $request->Payment_plan;
            $programm->user_id = Auth::id();
            $programm->status = 0;
            if ($request->file('image') != "") {
                $file = $request->file('image');
                $programm->image  = $this->saveImage($file, 920, 526);
                $programm->icon  = $this->saveImage($file, 296, 270);
            }
            $programm->save();


            DB::commit();
            Toastr::success('Operation successful', 'Success');
            return redirect()->route('regular_student_import');
        } catch (\Exception $e) {
            DB::rollBack();

            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function edit_program($id)
    {

        $progaram = Program::where('id', $id)->first();
        $courses = Course::where('status', 1)->where('type', 1)->get();
        $faqs = HomePageFaq::orderBy('order', 'asc')->where('status', 1)->get();

        return view('studentsetting::edit_program', compact('progaram', 'courses', 'faqs'));
    }


    public function updateprogram(Request $request)
    {
        // dd($request->id);

        $rules = [
            'ProgramTitle' => 'required|max:15|unique:programs,programtitle,' . $request->id,
            'subtitle' => 'required|max:20',
            'totalcost' => 'required',
            'duration' => 'required',
            'requirements' => 'required',
            'description' => 'required',
            'allcourses' => 'required',
            'Payment_plan' => 'required'
        ];
        $this->validate($request, $rules, validationMessage($rules));

        if ($request->file('image') != "") {
            $extensions = ["png", "jpg", "jpeg"];
            $result = strtolower($request->image->getClientOriginalExtension());
            if (!in_array($result, $extensions)) {
                Toastr::error('Invalid File Extension. Allow PNG,JPG,JPEG format', 'Failed');
                return redirect()->back();
            }
        }
        try {

            DB::beginTransaction();
            $courses = (json_encode($request->allcourses) != null) ? json_encode($request->allcourses) : [];
            $faqs = (json_encode($request->faqs)  != null) ? json_encode($request->allcourses) : [];

            $programm = Program::where('id', $request->id)->first();
            $programm->programtitle = $request->ProgramTitle;
            $programm->subtitle = $request->subtitle;
            $programm->totalcost = $request->totalcost;
            $programm->duration = $request->duration;
            $programm->requirement = $request->requirements;
            $programm->discription = $request->description;
            $programm->outcome = $request->outcome;
            $programm->numberofcourses = 0;
            $programm->allcourses = $courses;
            $programm->faqs = $faqs;
            $programm->payment_plan = $request->Payment_plan;
            if ($request->file('image') != "") {
                $file = $request->file('image');
                $this->deleteImage($programm->image);
                $this->deleteImage($programm->icon);
                $programm->image  = $this->saveImage($file, 920, 526);
                $programm->icon  = $this->saveImage($file, 296, 250);
            }

            $programm->save();

            DB::commit();
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();

            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function delete_program($id)
    {
        $program = Program::where('id', $id)->first();
        $related_plan = $program->programPlans()->count();
        $related_enroll = $program->totalEnrolledStudent()->count();

        if ($related_plan > 0 || $related_enroll > 0) {
            Toastr::error('Progarm has ' . $this->checkProgramRelation($related_plan, $related_enroll) . ', Please Delete ' . $this->checkProgramRelation($related_plan, $related_enroll) . ' First', 'Error');
            return redirect()->back();
        }
        if ($program) {
            $this->deleteImage($program->image);
            $result = $program->delete();
            if ($result) {
                Toastr::success('Progarm Successfully Deleted', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Something went wrong', trans('common.Failed'));
                return redirect()->back();
            }
        }
        // $result= DB::table('programs')->delete($id);

        // if($result){
        //      Toastr::success('progarm deleted Successfully', 'Success');
        //     return redirect()->back();
        // }else{
        //  Toastr::error('Something went wrong', trans('common.Failed'));
        //     return redirect()->back();
        // }

    }
    public function checkProgramRelation($related_plan = '', $related_enroll = '')
    {
        return (!empty($related_plan) ? 'Plans' : '') . (!empty($related_enroll) ? ' and Enrollment' : '');
    }




    public function store(Request $request)
    {


        if (saasPlanCheck('student')) {
            Toastr::error('You have reached student limit', trans('common.Failed'));
            return redirect()->back();
        }
        Session::flash('type', 'store');

        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'name' => 'required',
            'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:5|unique:users,phone,' . Auth::user()->lms_id,
            'password' => 'required|min:8|confirmed',
        ];

        if (isModuleActive('Org')) {
            $rules['position'] = 'required';
            $rules['branch'] = 'required';
            $rules['email'] = 'nullable|email|required_without:username|unique:users,email';
            $rules['username'] = 'nullable|required_without:email|unique:users,username';
        } else {
            $rules['email'] = 'required|email|unique:users,email';
        }

        $this->validate($request, $rules, validationMessage($rules));

        try {

            $success = trans('lang.Student') . ' ' . trans('lang.Added') . ' ' . trans('lang.Successfully');


            $user = new User;
            $user->name = $request->name;
            $user->password = bcrypt($request->password);
            $user->about = $request->about;

            if (empty($request->email)) {
                $user->email = null;
            } else {
                $user->email = $request->email;
            }
            if (empty($request->username)) {
                $user->username = null;
            } else {
                $user->username = $request->username;
            }

            if (empty($request->phone)) {
                $user->phone = null;
            } else {
                $user->phone = $request->phone;
            }

            $user->dob = getPhpDateFormat($request->dob);
            $user->facebook = $request->facebook;
            $user->twitter = $request->twitter;
            $user->linkedin = $request->linkedin;
            $user->youtube = $request->youtube;
            $user->gender = $request->gender;
            $user->company = $request->company;

            if (isModuleActive('Org')) {
                $user->org_position_code = $request->position;
                $branch = $request->branch;
                $branch = explode('/', $branch);
                $user->org_chart_code = end($branch);
                $user->start_working_date = getPhpDateFormat($request->start_working_date);
                $user->employee_id = $request->employee_id;
            }

            $user->language_id = Settings('language_id');
            $user->language_code = Settings('language_code');
            $user->language_name = Settings('language_name');
            $user->language_rtl = Settings('language_rtl');
            $user->country = Settings('country_id');
            $user->teach_via = 1;

            if (isModuleActive('LmsSaas')) {
                $user->lms_id = app('institute')->id;
            } else {
                $user->lms_id = 1;
            }
            $user->added_by = Auth::user()->id;
            $user->email_verify = 1;
            $user->email_verified_at = now();
            $user->referral = Str::random(10);


            if ($request->file('image') != "") {
                $file = $request->file('image');
                $user->image = $this->saveImage($file);
            }

            $user->role_id = 3;

            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $user->organization_id = Auth::id();
            }

            $user->save();
            applyDefaultRoleToUser($user);
            if (Schema::hasTable('users') && Schema::hasTable('chat_statuses')) {
                if (isModuleActive('Chat')) {
                    userStatusChange($user->id, 0);
                }
            }
            $mailchimpStatus = saasEnv('MailChimp_Status') ?? false;
            $getResponseStatus = saasEnv('GET_RESPONSE_STATUS') ?? false;
            $acelleStatus = saasEnv('ACELLE_STATUS') ?? false;
            if (hasTable('newsletter_settings')) {
                $setting = NewsletterSetting::getData();

                if ($setting->student_status == 1) {
                    $list = $setting->student_list_id;
                    if ($setting->student_service == "Mailchimp") {

                        if ($mailchimpStatus) {
                            try {
                                $MailChimp = new MailChimp(saasEnv('MailChimp_API'));
                                $MailChimp->post("lists/$list/members", [
                                    'email_address' => $user->email,
                                    'status' => 'subscribed',
                                ]);
                            } catch (\Exception $e) {
                            }
                        }
                    } elseif ($setting->student_service == "GetResponse") {
                        if ($getResponseStatus) {

                            try {
                                $getResponse = new \GetResponse(saasEnv('GET_RESPONSE_API'));
                                $getResponse->addContact(array(
                                    'email' => $user->email,
                                    'campaign' => array('campaignId' => $list),
                                ));
                            } catch (\Exception $e) {
                            }
                        }
                    } elseif ($setting->instructor_service == "Acelle") {
                        if ($acelleStatus) {

                            try {
                                $email = $user->email;
                                $make_action_url = '/subscribers?list_uid=' . $list . '&EMAIL=' . $email;
                                $acelleController = new AcelleController();
                                $response = $acelleController->curlPostRequest($make_action_url);
                            } catch (\Exception $e) {
                            }
                        }
                    } elseif ($setting->student_service == "Local") {
                        try {
                            $check = Subscription::where('email', '=', $user->email)->first();
                            if (empty($check)) {
                                $subscribe = new Subscription();
                                $subscribe->email = $user->email;
                                $subscribe->type = 'Student';
                                $subscribe->save();
                            } else {
                                $check->type = "Student";
                                $check->save();
                            }
                        } catch (\Exception $e) {
                        }
                    }
                }
            }

            SendGeneralEmail::dispatch($user, 'New_Student_Reg', [
                'time' => Carbon::now()->format('d-M-Y, g:i A'),
                'name' => $user->name
            ]);

            Toastr::success($success, 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function field()
    {
        $field = StudentCustomField::getData();

        return view('studentsetting::field_setting', compact('field'));
    }

    public function fieldStore(Request $request)
    {


        try {
            $entry = StudentCustomField::first();
            if ($entry) {
                $entry->delete();
            }

            $request = $this->editableConfig($request);


            StudentCustomField::create($request->all());

            Toastr::success('Student custom field updated!', trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function editableConfig(Request $request): Request
    {
        $request['editable_company'] = $request->editable_company ? 1 : 0;
        $request['editable_gender'] = $request->editable_gender ? 1 : 0;
        $request['editable_student_type'] = $request->editable_student_type ? 1 : 0;
        $request['editable_identification_number'] = $request->editable_identification_number ? 1 : 0;
        $request['editable_job_title'] = $request->editable_job_title ? 1 : 0;
        $request['editable_dob'] = $request->editable_dob ? 1 : 0;
        $request['editable_name'] = $request->editable_name ? 1 : 0;
        $request['editable_phone'] = $request->editable_phone ? 1 : 0;

        $request['show_company'] = $request->show_company ? 1 : 0;
        $request['show_gender'] = $request->show_gender ? 1 : 0;
        $request['show_student_type'] = $request->show_student_type ? 1 : 0;
        $request['show_identification_number'] = $request->show_identification_number ? 1 : 0;
        $request['show_job_title'] = $request->show_job_title ? 1 : 0;
        $request['show_dob'] = $request->show_dob ? 1 : 0;
        $request['show_name'] = $request->show_name ? 1 : 0;
        $request['show_phone'] = $request->show_phone ? 1 : 0;

        $request['required_company'] = $request->required_company ? 1 : 0;
        $request['required_gender'] = $request->required_gender ? 1 : 0;
        $request['required_student_type'] = $request->required_student_type ? 1 : 0;
        $request['required_identification_number'] = $request->required_identification_number ? 1 : 0;
        $request['required_job_title'] = $request->required_job_title ? 1 : 0;
        $request['required_dob'] = $request->required_dob ? 1 : 0;
        $request['required_name'] = $request->required_name ? 1 : 0;
        $request['required_phone'] = $request->required_phone ? 1 : 0;
        return $request;
    }


    public function update(Request $request)
    {
        Session::flash('type', 'update');

        if (demoCheck()) {
            return redirect()->back();
        }


        $rules = [
            'name' => 'required',
            'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users,phone,' . $request->id,
            'password' => 'bail|nullable|min:8|confirmed',

        ];

        if (isModuleActive('Org')) {
            $rules['email'] = 'nullable|email|required_without:username|unique:users,email,' . $request->id;
            $rules['username'] = 'nullable|required_without:email|unique:users,username,' . $request->id;
        } else {
            $rules['email'] = 'required|email|unique:users,email,' . $request->id;
        }

        $this->validate($request, $rules, validationMessage($rules));

        try {
            if (Config::get('app.app_sync')) {
                Toastr::error('For demo version you can not change this !', 'Failed');
                return redirect()->back();
            } else {
                // $success = trans('lang.Student') .' '.trans('lang.Updated').' '.trans('lang.Successfully');

                $user = User::find($request->id);
                $user->name = $request->name;
                if (empty($request->email)) {
                    $user->email = null;
                } else {
                    $user->email = $request->email;
                }
                if (empty($request->username)) {
                    $user->username = null;
                } else {
                    $user->username = $request->username;
                }
                if (empty($request->phone)) {
                    $user->phone = null;
                } else {
                    $user->phone = $request->phone;
                }
                $user->dob = getPhpDateFormat($request->dob);
                $user->facebook = $request->facebook;
                $user->twitter = $request->twitter;
                $user->linkedin = $request->linkedin;
                $user->youtube = $request->youtube;
                $user->about = $request->about;
                if (isModuleActive('Org')) {
                    $user->org_position_code = $request->position;
                    //                    $user->org_chart_code = $request->branch;
                    $user->start_working_date = getPhpDateFormat($request->start_working_date);
                    $user->employee_id = $request->employee_id;
                }
                $user->email_verify = 1;
                $user->gender = $request->gender;
                $user->company = $request->company;
                if ($request->password) {
                    $user->password = bcrypt($request->password);
                }
                if ($request->file('image') != "") {
                    $file = $request->file('image');
                    $user->image = $this->saveImage($file);
                }
                $user->role_id = 3;
                $user->save();
            }

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function destroy(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'id' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));

        $user = User::where('id', $request->id)->first();
        $user_courses = $user->enrollCourse()->count();
        $user_program = $user->enrollProgrom()->count();
        $user_checkout = $user->checkouts()->count();

        if ($user_courses > 0 || $user_program > 0) {
            Toastr::error('Student has ' . $this->checkStudentRelation($user_courses, $user_program) . ', Please Delete ' . $this->checkStudentRelation($user_courses, $user_program) . ' First then Delete Student', 'Error');
            return redirect()->back();
        }

        try {
            $success = trans('lang.Student') . ' ' . trans('lang.Deleted') . ' ' . trans('lang.Successfully');
            if ($user_checkout > 0) {
                Checkout::where('user_id', $user->id)->delete();
            }
            //          delete Operation
            $exception = DB::transaction(function () use ($request, $user) {
                //                user
                $user->delete();
                //                UserSetting
                UserSetting::where('user_id', $request->id)->delete();
                //                  UserApplication
                UserApplication::where('user_id', $request->id)->delete();
                //              UserAuthorzIationAgreement
                UserAuthorzIationAgreement::where('user_id', $request->id)->delete();
            });

            if (!is_null($exception)) {
                Toastr::success('Some Database Error', 'Error');
                return redirect()->back();
            }

            Toastr::success($success, 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function checkStudentRelation($user_courses = '', $user_program = '')
    {
        return (!empty($user_courses) ? 'Enrolled Courses' : '') . (!empty($user_program) ? ' and Programs' : '');
    }


    public function getAllStudentData(Request $request)
    {
        $user = Auth::user();
        $query = User::query();

        if (isModuleActive('LmsSaas')) {
            $query->where('lms_id', app('institute')->id);
        } else {
            $query->where('lms_id', 1);
        }
        if (isModuleActive('UserType')) {
            $query->whereHas('userRoles', function ($q) {
                $q->where('role_id', 3);
            });
        } else {
            $query->where('role_id', 3);
        }
        if (isModuleActive('Organization') && $user->isOrganization()) {
            $query->where('organization_id', $user->id);
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($query) {
                return view('backend.partials._td_image', compact('query'));
            })->editColumn('name', function ($query) {
                return $query->name;
            })->editColumn('email', function ($query) {
                return $query->email;
            })
            ->editColumn('phone', function ($query) {
                return $query->phone;
            })
            ->editColumn('gender', function ($query) {
                return ucfirst($query->gender);
            })
            ->editColumn('dob', function ($query) {
                return showDate($query->dob);
            })
            ->addColumn('start_working_date', function ($query) {
                if (isModuleActive('Org')) {
                    return showDate($query->start_working_date);
                } else {
                    return '';
                }
            })
            ->editColumn('country', function ($query) {
                return $query->userCountry->name;
            })
            ->addColumn('status', function ($query) {
                $route = 'student.change_status';
                return view('backend.partials._td_status', compact('query', 'route'));
            })->addColumn('course_count', function ($query) {
                return view('studentsetting::partials._td_course_count', compact('query'));
            })->addColumn('program_count', function ($query) {
                return view('studentsetting::partials._td_program_count', compact('query'));
            })->addColumn('action', function ($query) {
                return view('studentsetting::partials._td_action', compact('query'));
            })->rawColumns(['status', 'image', 'course_count', 'program_count', 'action'])
            ->make(true);
    }

    public function studentAssignedCourses($id)
    {
        try {
            $user = User::find($id);
            $courses = $user->enrollCourse;
            $instance = $user->enCoursesInstance->load('course.user');
            $notEnrolled = Course::where('status', 1)->whereNotIn('id', $courses->pluck('id')->toArray())->get();
            return view('studentsetting::student_courses', compact('courses', 'instance', 'user', 'notEnrolled'));
        } catch (\Throwable $th) {
            GettingError($th->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
    public function studentAssignedPrograms($id)
    {
        try {
            $user = User::find($id);
            $courses = $user->enrollCourse;
            $instance = $user->enProgramsInstance->load('program.user');
            $notEnrolled = Course::where('status', 1)->whereNotIn('id', $courses->pluck('id')->toArray())->get();
            return view('studentsetting::student_programs', compact('courses', 'instance', 'user', 'notEnrolled'));
        } catch (\Throwable $th) {
            GettingError($th->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function enrolled_students($program_id)
    {
        try {
            $program = Program::find($program_id);
            $students = [];
            return view('studentsetting::program_students', compact('students', 'program'));
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function getAllProgramStudent(Request $request, $program_id)
    {

        $program = Program::find($program_id);
        $query = $program->enrollUsers;

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($query) {
                return " <div class=\"profile_info\"><img src='" . getStudentImage($query->image) . "'   alt='" . $query->name . " image'></div>";
            })->addColumn('student_name', function ($query) {
                return '<a class="dropdown-item" target="_blank" href="' . route('student.courses', $query->id) . '" data-id="' . $query->id . '" type="button">' . $query->name . '</a>';
            })->editColumn('email', function ($query) {
                return $query->email;
            })
            ->editColumn('phone', function ($query) {
                return $query->phone;
            })
            ->addColumn('progressbar', function ($query) use ($program) {
                return "  <div class='progress_percent flex-fill text-right'>
                                                    <div class='progress theme_progressBar '>
                                                        <div class='progress-bar' role='progressbar'
                                                             style='width:" . round($program->userTotalPercentage($query->id, $program->id)) . "%'
                                                             aria-valuenow='25'
                                                             aria-valuemin='0' aria-valuemax='100'></div>
                                                    </div>
                                                    <p class='font_14 f_w_400'>" . round($program->userTotalPercentage($query->id, $program->id)) . "% Complete</p>
                                                </div>";
            })
            ->editColumn('dob', function ($query) {
                return showDate($query->dob);
            })
            ->addColumn('start_working_date', function ($query) {
                if (isModuleActive('Org')) {
                    return showDate($query->start_working_date);
                } else {
                    return '';
                }
            })
            ->editColumn('country', function ($query) {
                return $query->userCountry->name;
            })
            ->addColumn('status', function ($query) {

                $checked = $query->status == 1 ? "checked" : "";
                $view = '<label class="switch_toggle" for="active_checkbox' . $query->id . '">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           id="active_checkbox' . $query->id . '" value="' . $query->id . '"
                                                             ' . $checked . '><i class="slider round"></i></label>';

                return $view;
            })->addColumn('notify_user', function ($query) use ($program) {
                if (round($program->userTotalPercentage($query->id, $program->id)) < 100) {
                    $link = '<a class="" href="' . route('program.programStudentNotify', [$program->id, $query->id]) . '" data-id="' . $query->id . '" type="button">Notify</a>';
                } else {
                    $link = '';
                }
                return $link;
            })->rawColumns(['status', 'progressbar', 'image', 'notify_user', 'action', 'student_name'])
            ->make(true);
    }
    public function programStudentNotify($program_id, $student_id)
    {
        try {
            $program = Program::find($program_id);
            $user = User::find($student_id);
            $percentage = round($program->userTotalPercentage($student_id, $program_id));

            $message = "You have complete " . $percentage . "% of " . $program->programtitle . ". Please complete as soon as possible";
            $details = [
                'title' => 'Incomplete program reminder',
                'body' => $message,
                'actionText' => 'Visit',
                'actionURL' => route('programs.detail', $program->id),
            ];
            Notification::send($user, new GeneralNotification($details));
            Toastr::success('Operation Done Successfully', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function newEnroll()
    {

        try {

            $query = Program::where('status', 1);

            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $query->whereHas('user', function ($q) {
                    $q->where('organization_id', Auth::id());
                });
            }

            $programs = $query->select('id', 'programtitle')->get();

            $query = User::where('status', 1)->select('id', 'name');
            if (isModuleActive('LmsSaas')) {
                $query->where('lms_id', app('institute')->id);
            } else {
                $query->where('lms_id', 1);
            }
            if (isModuleActive('UserType')) {
                $query->whereHas('userRoles', function ($q) {
                    $q->where('role_id', 3);
                });
            } else {
                $query->where('role_id', 3);
            }
            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $query->where('organization_id', Auth::id());
            }
            $students = $query->get();
            return view('studentsetting::new_enroll', compact('programs', 'students'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function newEnrollSubmit(Request $request)
    {


        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'student' => 'required|array',
            'program' => 'required'

        ];

        $this->validate($request, $rules, validationMessage($rules));
        try {
            $students = $request->student;

            foreach ($students as $student) {

                $user = User::find($student);
                if ($user) {
                    $program = Program::findOrFail($request->program);
                    $instractor = User::findOrFail($program->user_id);

                    $check = CourseEnrolled::where('user_id', $user->id)->where('program_id', $request->program)->first();
                    if ($check) {
                        Toastr::error($user->name . ' has already been enrolled to this Program', 'Success');
                    } else {
                        //                        if (isModuleActive('Group')) {
                        //                            if ($course->isGroupCourse) {
                        //                                $groupRepo = new GroupRepository();
                        //                                $group = $groupRepo->find($course->isGroupCourse->id);
                        //
                        //                                $studentLimit = true;
                        //                                if ($group->maximum_enroll) {
                        //                                    $studentLimit = $group->maximum_enroll > $group->members->where('user_role_id', 3)->count();
                        //                                }
                        //
                        //                                if ($group && $studentLimit) {
                        //                                    GroupMember::create([
                        //                                        'group_id' => $course->isGroupCourse->id,
                        //                                        'user_id' => $user->id,
                        //                                        'user_role_id' => 3,
                        //                                    ]);
                        //                                    if ($group->maximum_enroll <= $group->members->where('user_role_id', 3)->count() || $studentLimit == true) {
                        //                                        $group->update(['quota_status' => 1]);
                        //                                    } else {
                        //                                        $group->update(['quota_status' => 0]);
                        //                                    }
                        //                                    Toastr::success('User Add To Group Successfully');
                        //                                } else {
                        //                                    Toastr::warning("Group Member Can't exceed Maximum Limit");
                        //                                }
                        //
                        //                            }
                        //                        }


                        $enrolled = $program->total_enrolled;
                        $program->total_enrolled = ($enrolled + 1);
                        $enrolled = new CourseEnrolled();
                        $enrolled->user_id = $user->id;
                        $enrolled->program_id = $request->program;
                        $enrolled->purchase_price = $program->discount_price != null ? $program->discount_price : $program->totalcost;
                        $enrolled->save();


                        $itemPrice = $enrolled->purchase_price;


                        //                        if (!is_null($program->special_commission) && $program->special_commission != 0) {
                        //                            $commission = $program->special_commission;
                        //                            $reveune = ($itemPrice * $commission) / 100;
                        //                            $enrolled->reveune = $reveune;
                        //                        } else
                        if (!is_null($instractor->special_commission) && $instractor->special_commission != 0) {
                            $commission = $instractor->special_commission;
                            $reveune = ($itemPrice * $commission) / 100;
                            $enrolled->reveune = $reveune;
                        } else {
                            $commission = 100 - Settings('commission');
                            $reveune = ($itemPrice * $commission) / 100;
                            $enrolled->reveune = $reveune;
                        }

                        $payout = new InstructorPayout();
                        $payout->instructor_id = $program->user_id;
                        $payout->reveune = $reveune;
                        $payout->status = 0;
                        $payout->save();

                        $codes = [
                            'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $program->programtitle,
                            'currency' => $user->currency->symbol ?? '$',
                            'price' => ($user->currency->conversion_rate * $itemPrice),
                            'instructor' => $program->user->name,
                            'gateway' => 'Offline',
                        ];

                        if (UserEmailNotificationSetup('Course_Enroll_Payment', $user)) {
                            SendGeneralEmail::dispatch($user, 'Course_Enroll_Payment', $codes);
                        }
                        if (UserBrowserNotificationSetup('Course_Enroll_Payment', $user)) {

                            send_browser_notification(
                                $user,
                                'Course_Enroll_Payment',
                                $codes,
                                trans('common.View'),
                                //                                courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                            );
                        }

                        if (UserMobileNotificationSetup('Course_Enroll_Payment', $user) && !empty($user->device_token)) {
                            send_mobile_notification($user, 'Course_Enroll_Payment', $codes);
                        }


                        $codes2 = [
                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $program->title,
                            'currency' => $instractor->currency->symbol ?? '$',
                            'price' => ($instractor->currency->conversion_rate * $itemPrice),
                            'rev' => @$reveune,
                        ];

                        if (UserEmailNotificationSetup('Enroll_notify_Instructor', $instractor)) {
                            SendGeneralEmail::dispatch($instractor, 'Enroll_notify_Instructor', $codes2);
                        }
                        if (UserBrowserNotificationSetup('Enroll_notify_Instructor', $instractor)) {

                            send_browser_notification(
                                $instractor,
                                'Enroll_notify_Instructor',
                                $codes2,
                                trans('common.View'),
                                //                                courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                            );
                        }

                        if (UserMobileNotificationSetup('Course_Enroll_Payment', $instractor) && !empty($instractor->device_token)) {
                            send_mobile_notification($instractor, 'Course_Enroll_Payment', $codes2);
                        }


                        $enrolled->save();

                        //                        $course->reveune = (($course->reveune) + ($enrolled->reveune));
                        //
                        //                        $course->save();


                        if (isModuleActive('Chat')) {
                            event(new OneToOneConnection($instractor, $user, $program));
                        }

                        //                        if (isModuleActive('Survey')) {
                        //                            $hasSurvey = Survey::where('course_id', $program->id)->get();
                        //                            foreach ($hasSurvey as $survey) {
                        //                                $surveyController = new SurveyController();
                        //                                $surveyController->assignSurvey($survey, $user);
                        //                            }
                        //                        }

                        //start email subscription
                        if ($instractor->subscription_api_status == 1) {
                            try {
                                //                                if ($instractor->subscription_method == "Mailchimp") {
                                //                                    $list = $course->subscription_list;
                                //                                    $MailChimp = new MailChimp($instractor->subscription_api_key);
                                //                                    $MailChimp->post("lists/$list/members", [
                                //                                        'email_address' => Auth::user()->email,
                                //                                        'status' => 'subscribed',
                                //                                    ]);
                                //
                                //                                } elseif ($instractor->subscription_method == "GetResponse") {
                                //
                                //                                    $list = $course->subscription_list;
                                //                                    $getResponse = new \GetResponse($instractor->subscription_api_key);
                                //                                    $getResponse->addContact(array(
                                //                                        'email' => Auth::user()->email,
                                //                                        'campaign' => array('campaignId' => $list),
                                //
                                //                                    ));
                                //                                }
                            } catch (\Exception $exception) {
                                GettingError($exception->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);
                            }
                        }
                        Toastr::success($user->name . ' Successfully Enrolled this Program', 'Success');
                    }
                }
            }


            return redirect()->to(route('admin.enrollLogs'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function Skill_group($id)
    {
        if (isModuleActive('SkillAndPathway')) {
            $group = GroupStudent::where('student_id', $id)->with('group')->get();
            return view('skillandpathway::group.student-group', compact('group'));
        }
        return null;
    }
}
