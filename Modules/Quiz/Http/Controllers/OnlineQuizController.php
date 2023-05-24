<?php

namespace Modules\Quiz\Http\Controllers;

use App\Exports\OnlineQuizReport;
use App\Jobs\SendGeneralEmail;
use App\User;
use App\TableList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Org\Entities\OrgBranch;
use Modules\Org\Entities\OrgPosition;
use Modules\Quiz\Entities\QuizTest;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Course;
use Modules\Quiz\Entities\OnlineExamQuestionAssign;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\Quiz\Entities\QuizeSetup;
use Modules\Quiz\Entities\QuizMarking;
use Modules\Quiz\Entities\QuestionBank;
use Modules\Quiz\Entities\QuestionGroup;
use Modules\CourseSetting\Entities\Lesson;
use Modules\Quiz\Entities\QuizTestDetails;
use Modules\CourseSetting\Entities\Chapter;
use Modules\Quiz\Entities\StudentTakeOnlineQuiz;
use Modules\StudentSetting\Entities\Program;
use Yajra\DataTables\Facades\DataTables;

class OnlineQuizController extends Controller
{
    public function index()
    {

        try {
            $user = Auth::user();
            $query = OnlineQuiz::with('subCategory', 'category')->latest();
            if ($user->role_id == 2) {
                $quiz_ids = [];
                if (isModuleActive('OrgInstructorPolicy')) {
                    $ids = $user->policy->course_assigns->pluck('course_id')->toArray();
                    $course_quiz_ids = Course::select('quiz_id')->whereNotNull('quiz_id')->whereIn('id', $ids)->get()->pluck('quiz_id')->toArray();
                    $lesson_quiz_ids = Lesson::select('quiz_id')->whereNotNull('quiz_id')->whereIn('id', $ids)->get()->pluck('quiz_id')->toArray();
                    $quiz_ids = array_merge($course_quiz_ids, $lesson_quiz_ids);
                }
                $query->where('created_by', $user->id)->orWhereIn('id', $quiz_ids);
            } else {
                if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                    $query->whereHas('user', function ($q) {
                        $q->where('organization_id', Auth::id());
                        $q->orWhere('created_by', Auth::id());
                    });
                }
            }


            $online_exams = $query->get();


            $categories = Category::orderBy('position_order', 'asc')->get();
            $groups = QuestionGroup::select('title', 'id')->where('active_status', 1)->latest()->pluck('title', 'id');
            $present_date_time = date("Y-m-d H:i:s");
            $present_time = date("H:i:s");
            $quiz_setup = QuizeSetup::getData();


            return view('quiz::online_quiz', compact('quiz_setup', 'online_exams', 'categories', 'present_date_time', 'present_time', 'groups'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function CourseQuizStore(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        if ($request->type == 2) {
            $rules = [
                'title' => 'required',
                'category' => 'required',
                'percentage' => 'required',
                'instruction' => 'required'
            ];
            $this->validate($request, $rules, validationMessage($rules));
            // return OnlineQuiz::get();
            try {
                DB::beginTransaction();
                $sub = $request->sub_category;
                if (empty($sub)) {
                    $sub = null;
                }
                $online_exam = new OnlineQuiz();

                foreach ($request->title as $key => $title) {
                    $online_exam->setTranslation('title', $key, $title);
                }
                foreach ($request->instruction as $key => $instruction) {
                    $online_exam->setTranslation('instruction', $key, $instruction);
                }


                $online_exam->category_id = $request->category;
                $online_exam->sub_category_id = $sub;
                $online_exam->course_id = $request->course_id;
                $online_exam->percentage = $request->percentage;
                $online_exam->status = 1;
                $online_exam->created_by = Auth::id();

                $setup = QuizeSetup::getData();
                $online_exam->random_question = $setup->random_question == 1 ? 1 : 0;
                $online_exam->question_time_type = $setup->set_per_question_time == 1 ? 0 : 1;
                $online_exam->question_time = $setup->set_per_question_time == 1 ? $setup->time_per_question : $setup->time_total_question;
                $online_exam->question_review = $setup->question_review == 1 ? 1 : 0;
                $online_exam->show_result_each_submit = $setup->show_result_each_submit == 1 ? 1 : 0;
                $online_exam->multiple_attend = $setup->multiple_attend == 1 ? 1 : 0;
                $online_exam->show_ans_with_explanation = $setup->show_ans_with_explanation == 1 ? 1 : 0;
                $online_exam->start_date = $request->start_date;

                $online_exam->save();

                $user = Auth::user();
                if ($user->role_id == 2) {
                    $course = Course::where('id', $request->course_id)->where('user_id', Auth::id())->first();
                } else {
                    $course = Course::where('id', $request->course_id)->first();
                }
                $chapter = Chapter::find($request->chapterId);

                if (isset($course) && isset($chapter)) {

                    $lesson = new Lesson();
                    $lesson->course_id = $request->course_id;
                    $lesson->chapter_id = $request->chapterId;
                    $lesson->quiz_id = $online_exam->id;
                    $lesson->is_quiz = $request->is_quiz;
                    $lesson->is_lock = $request->lock;
                    $lesson->save();
                    $quiz = OnlineQuiz::find($online_exam->id);

                    $codes = [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'chapter' => $chapter->name,
                        'quiz' => $quiz->title,
                    ];
                    $act = 'Course_Quiz_Added';

                    $query = CourseEnrolled::where('course_id', null)->with('user')
                        ->whereHas('program', function ($query) {
                        });
                    $programs = Program::Where('allcourses', 'like', '%,"' . $request->course_id . '",%')->pluck('id');
                    $query = $query->whereIn('program_id', $programs->unique())->groupBy('program_id')->groupBy('user_id')->pluck('user_id')->toArray();
                    $users = User::where('id', '!=', Auth::id())->whereIn('id', $query)->get();

                    if (isset($users) && !empty($users)) {
                        foreach ($users as $user) {
                            if (UserEmailNotificationSetup($act, $user)) {
                                SendGeneralEmail::dispatch($user, $act, $codes);
                            }
                            if (UserBrowserNotificationSetup($act, $user)) {

                                send_browser_notification(
                                    $user,
                                    $act,
                                    $codes,
                                    trans('common.View'),
                                    courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                                );
                            }

                            if (UserMobileNotificationSetup($act, $user) && !empty($user->device_token)) {
                                send_mobile_notification($user, $act, $codes);
                            }
                        }
                    }

                    //                    $courseUser = $course->user;
                    //                    if (UserEmailNotificationSetup($act, $courseUser)) {
                    //                        SendGeneralEmail::dispatch($courseUser, $act, $codes);
                    //                    }
                    //                    if (UserBrowserNotificationSetup($act, $courseUser)) {
                    //
                    //                        send_browser_notification(
                    //                            $courseUser,
                    //                            $act,
                    //                            $codes,
                    //                            trans('common.View'),
                    //                            courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                    //                        );
                    //                    }
                    //                    if (UserMobileNotificationSetup($act, $courseUser) && !empty($courseUser->device_token)) {
                    //                        send_mobile_notification($courseUser, $act, $codes);
                    //                    }

                    DB::commit();
                    Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                    return redirect()->back();
                } else {
                    Toastr::error('Invalid Access !', 'Failed');
                    return redirect()->back();
                }
            } catch (\Exception $e) {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }
        } else {
            $rules = [
                'quiz' => 'required',
                'lock' => 'required',

            ];
            $this->validate($request, $rules, validationMessage($rules));
            try {
                $user = Auth::user();
                if ($user->role_id == 2) {
                    $course = Course::where('id', $request->course_id)->where('user_id', Auth::id())->first();
                } else {
                    $course = Course::where('id', $request->course_id)->first();
                }
                $chapter = Chapter::find($request->chapterId);

                if (isset($course) && isset($chapter)) {

                    $lesson = new Lesson();
                    $lesson->course_id = $request->course_id;
                    $lesson->chapter_id = $request->chapterId;
                    $lesson->quiz_id = $request->quiz;
                    $lesson->is_quiz = $request->is_quiz;
                    $lesson->is_lock = $request->lock;
                    $lesson->save();
                    $quiz = OnlineQuiz::find($request->quiz);


                    $act = 'Course_Quiz_Added';
                    $codes = [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'chapter' => $chapter->name,
                        'quiz' => $quiz->title,
                    ];
                    if (isset($course->enrollUsers) && !empty($course->enrollUsers)) {
                        foreach ($course->enrollUsers as $user) {
                            if (UserEmailNotificationSetup($act, $user)) {
                                SendGeneralEmail::dispatch($user, $act, $codes);
                            }
                            if (UserBrowserNotificationSetup($act, $user)) {
                                send_browser_notification(
                                    $user,
                                    $act,
                                    $codes,
                                    trans('common.View'),
                                    courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                                );
                            }

                            if (UserMobileNotificationSetup($act, $user) && !empty($user->device_token)) {
                                send_mobile_notification($user, $act, $codes);
                            }
                        }
                    }
                    $courseUser = $course->user;
                    if (UserEmailNotificationSetup($act, $courseUser)) {
                        SendGeneralEmail::dispatch($courseUser, $act, $codes);
                    }
                    if (UserBrowserNotificationSetup($act, $courseUser)) {

                        send_browser_notification(
                            $courseUser,
                            $act,
                            $codes,
                            trans('common.View'),
                            courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                        );
                    }

                    if (UserMobileNotificationSetup($act, $courseUser) && !empty($courseUser->device_token)) {
                        send_mobile_notification($courseUser, $act, $codes);
                    }
                    Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                    return redirect()->back();
                }

                Toastr::error('Invalid Access !', 'Failed');
                return redirect()->back();
            } catch (\Exception $e) {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }
        }
    }

    public function CourseQuizUpdate(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'title' => 'required',
            'category' => 'required',
            'percentage' => 'required',
            'instruction' => 'required'
        ];
        $this->validate($request, $rules, validationMessage($rules));

        DB::beginTransaction();
        try {
            $sub = $request->sub_category;
            if (empty($sub)) {
                $sub = null;
            }
            $online_exam = OnlineQuiz::find($request->quiz_id);
            foreach ((array)$request->title as $key => $title) {
                $online_exam->setTranslation('title', $key, $title);
            }
            foreach ((array)$request->instruction as $key => $instruction) {
                $online_exam->setTranslation('instruction', $key, $instruction);
            }
            $online_exam->category_id = $request->category;
            $online_exam->sub_category_id = $sub;
            $online_exam->percentage = $request->percentage;

            $online_exam->status = 0;
            $online_exam->created_by = Auth::user()->id;
            $result = $online_exam->save();


            DB::commit();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('courseDetails', $request->course_id);
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }


        $code = auth()->user()->language_code;


        $rules = [
            'title.' . $code => 'required|max:255',
            'instruction.' . $code => 'required',
            'category' => 'required',
            'percentage' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));


        try {
            DB::beginTransaction();
            $sub = $request->sub_category;
            if (empty($sub)) {
                $sub = null;
            }
            $group = $request->group_id;
            if (empty($group)) {
                $group = null;
            }
            $online_exam = new OnlineQuiz();
            foreach ($request->title as $key => $title) {
                $online_exam->setTranslation('title', $key, $title);
            }
            foreach ($request->instruction as $key => $instruction) {
                $online_exam->setTranslation('instruction', $key, $instruction);
            }
            $online_exam->group_id = $group;
            $online_exam->category_id = $request->category;
            $online_exam->sub_category_id = $sub;
            $online_exam->course_id = $request->course;
            $online_exam->percentage = $request->percentage;
            $online_exam->status = 1;
            $online_exam->created_by = Auth::user()->id;


            if ($request->change_default_settings == 0) {
                $setup = QuizeSetup::getData();
                $online_exam->random_question = $setup->random_question == 1 ? 1 : 0;
                $online_exam->question_time_type = $setup->set_per_question_time == 1 ? 0 : 1;
                $online_exam->question_time = $setup->set_per_question_time == 1 ? $setup->time_per_question : $setup->time_total_question;
                $online_exam->question_review = $setup->question_review == 1 ? 1 : 0;
                $online_exam->show_result_each_submit = $setup->show_result_each_submit == 1 ? 1 : 0;
                $online_exam->multiple_attend = $setup->multiple_attend == 1 ? 1 : 0;
                $online_exam->show_ans_with_explanation = $setup->show_ans_with_explanation == 1 ? 1 : 0;
                $online_exam->losing_focus_acceptance_number = $setup->losing_focus_acceptance_number ?? 0;
                $online_exam->losing_type = $setup->losing_type;

                if ($setup->show_ans_sheet != 1) {
                    $show_ans_sheet = 0;
                } else {
                    $show_ans_sheet = $setup->show_ans_sheet;
                }
                $online_exam->show_ans_sheet = $show_ans_sheet;
            } else {
                $online_exam->random_question = $request->random_question == 1 ? 1 : 0;
                $online_exam->question_time_type = $request->type == 1 ? 1 : 0;
                $online_exam->question_time = $request->question_time;
                $online_exam->question_review = $request->question_review == 1 ? 1 : 0;
                $online_exam->show_result_each_submit = $request->show_result_each_submit == 1 ? 1 : 0;
                $online_exam->multiple_attend = $request->multiple_attend == 1 ? 1 : 0;
                $online_exam->show_ans_with_explanation = $request->show_ans_with_explanation == 1 ? 1 : 0;
                if ($request->losing_focus_acceptance_number_check != 1) {
                    $losing_focus_acceptance_number = 0;
                } else {
                    $losing_focus_acceptance_number = $request->losing_focus_acceptance_number;
                }
                $online_exam->losing_focus_acceptance_number = $losing_focus_acceptance_number;
                $online_exam->losing_type = $request->losing_type ?? 1;

                if ($request->show_ans_sheet != 1) {
                    $show_ans_sheet = 0;
                } else {
                    $show_ans_sheet = $request->show_ans_sheet;
                }
                $online_exam->show_ans_sheet = $show_ans_sheet;
            }

            $result = $online_exam->save();

            if ($request->set_random_question == 1) {
                $total = $request->random_question;

                $query = QuestionBank::query();
                if (Auth::user()->role_id == 2) {
                    $query->where('user_id', Auth::user()->id);
                }
                if (!empty($request->category)) {
                    $query->where('category_id', $request->category);
                }
                if (!empty($sub)) {
                    $query->where('sub_category_id', $sub);
                }

                if (!empty($group)) {
                    $query->where('q_group_id', $group);
                }
                $questions = $query->inRandomOrder()->limit($total)->get();

                foreach ($questions as $question) {
                    $assign = new OnlineExamQuestionAssign();
                    $assign->online_exam_id = $online_exam->id;
                    $assign->question_bank_id = $question->id;
                    $assign->save();
                }
            }


            if ($result) {

                DB::commit();
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            } else {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function edit($id)
    {
        try {
            $user = Auth::user();
            if ($user->role_id == 2) {
                $online_exams = OnlineQuiz::latest()->get();
            } else {
                $online_exams = OnlineQuiz::where('created_by', $user->id)->latest()->get();
            }

            $categories = Category::orderBy('position_order', 'asc')->get();
            $online_exam = OnlineQuiz::find($id);
            $groups = QuestionGroup::select('title', 'id')->where('active_status', 1)->latest()->pluck('title', 'id');

            $present_date_time = date("Y-m-d H:i:s");
            $present_time = date("H:i:s");
            $quiz_setup = QuizeSetup::getData();

            return view('quiz::online_quiz', compact('groups', 'quiz_setup', 'online_exams', 'categories', 'online_exam', 'present_date_time', 'present_time'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function update(Request $request, $id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $code = auth()->user()->language_code;

        $rules = [
            'title.' . $code => 'required|max:255',
            'instruction.' . $code => 'required',
            'category' => 'required',
            'percentage' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        DB::beginTransaction();
        try {

            $sub = $request->sub_category;
            if (empty($sub)) {
                $sub = null;
            }
            $group = $request->group_id;
            if (empty($group)) {
                $group = null;
            }
            $online_exam = OnlineQuiz::find($id);
            foreach ($request->title as $key => $title) {
                $online_exam->setTranslation('title', $key, $title);
            }
            foreach ($request->instruction as $key => $instruction) {
                $online_exam->setTranslation('instruction', $key, $instruction);
            }
            $online_exam->category_id = $request->category;
            $online_exam->sub_category_id = $sub;
            $online_exam->group_id = $group;
            $online_exam->course_id = $request->course;
            $online_exam->percentage = $request->percentage;


            $online_exam->random_question = $request->random_question == 1 ? 1 : 0;
            $online_exam->question_time_type = $request->type == 1 ? 1 : 0;
            $online_exam->question_time = $request->question_time;
            $online_exam->question_review = $request->question_review == 1 ? 1 : 0;
            $online_exam->show_result_each_submit = $request->show_result_each_submit == 1 ? 1 : 0;
            $online_exam->multiple_attend = $request->multiple_attend == 1 ? 1 : 0;
            $online_exam->show_ans_with_explanation = $request->show_ans_with_explanation == 1 ? 1 : 0;
            if ($request->losing_focus_acceptance_number_check != 1) {
                $losing_focus_acceptance_number = 0;
            } else {
                $losing_focus_acceptance_number = $request->losing_focus_acceptance_number;
            }
            $online_exam->losing_focus_acceptance_number = $losing_focus_acceptance_number;
            $online_exam->losing_type = $request->losing_type ?? 1;

            if ($request->show_ans_sheet != 1) {
                $show_ans_sheet = 0;
            } else {
                $show_ans_sheet = $request->show_ans_sheet;
            }
            $online_exam->show_ans_sheet = $show_ans_sheet;


            $result = $online_exam->save();
            if ($result) {

                DB::commit();
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            } else {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function delete(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $id_key = 'online_exam_id';

            $tables = TableList::getTableList($id_key, $request->id);

            try {
                if ($tables == null) {
                    $delete_query = OnlineQuiz::destroy($request->id);

                    if ($delete_query) {
                        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                        return redirect()->back();
                    } else {
                        Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                        return redirect()->back();
                    }
                } else {
                    $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                    Toastr::error($msg, 'Failed');
                    return redirect()->back();
                }
            } catch (\Illuminate\Database\QueryException $e) {
                $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                Toastr::error($msg, 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function manageOnlineExamQuestion($id, Request $request)
    {

        try {
            $user = Auth::user();
            $online_exam = OnlineQuiz::findOrFail($id);
            $online_exam->total_marks = $online_exam->totalMarks() ?? 0;
            $online_exam->total_questions = $online_exam->totalQuestions() ?? 0;


            if (!empty($online_exam->group_id)) {
                $request->merge([
                    'group' => $online_exam->group_id
                ]);
            }

            if (empty($request->get('group'))) {
                $searchGroup = '';
                $query = QuestionBank::where('category_id', $online_exam->category_id);
                if ($online_exam->sub_category_id != null) {
                    $query->where('sub_category_id', $online_exam->sub_category_id);
                }

                if ($user->role_id == 2) {
                    $query->where('user_id', $user->id);
                }

                $question_banks = $query->with('questionGroup', 'questionMu')->get();
            } else {
                $searchGroup = $request->get('group');
                $query = QuestionBank::where('category_id', $online_exam->category_id);
                if ($online_exam->sub_category_id != null) {
                    $query->where('sub_category_id', $online_exam->sub_category_id);
                }
                if ($user->role_id == 2) {
                    $query->where('user_id', $user->id);
                }
                $question_banks = $query->where('q_group_id', $request->get('group'))
                    ->with('questionGroup', 'questionMu')
                    ->get();
            }

            if ($user->role_id == 2) {
                $groups = QuestionGroup::where('user_id', $user->id)->where('active_status', 1)->latest()->get();
            } else {
                $groups = QuestionGroup::where('active_status', 1)->latest()->get();
            }
            $assigned_questions = OnlineExamQuestionAssign::with('questionBank')->where('online_exam_id', $id)->get();
            $already_assigned = [];
            foreach ($assigned_questions as $assigned_question) {
                $already_assigned[] = $assigned_question->question_bank_id;
            }



            return view('quiz::manage_quiz', compact('searchGroup', 'groups', 'online_exam', 'question_banks', 'already_assigned'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function onlineExamPublish($id)
    {
        try {
            $publish = OnlineQuiz::find($id);
            $publish->status = 1;
            $publish->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function quizSetup()
    {
        $quiz_setup = QuizeSetup::getData();
        return view('quiz::quiz_setup', compact('quiz_setup'));
    }

    public function SaveQuizSetup(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {

            if ($request->set_per_question_time == 1) {
                if (empty($request->set_time_per_question)) {
                    Toastr::error('Per question time required', trans('common.Failed'));
                    return redirect()->back();
                }
            } else {
                if (empty($request->set_time_total_question)) {
                    Toastr::error('Total questions time required', trans('common.Failed'));
                    return redirect()->back();
                }
            }

            $setup = QuizeSetup::firstOrCreate(['id' => 1]);
            $setup->random_question = $request->random_question;
            $setup->set_per_question_time = $request->set_per_question_time;
            $setup->multiple_attend = $request->multiple_attend ?? 0;
            $setup->show_ans_with_explanation = $request->show_ans_with_explanation ?? 0;
            if ($request->set_per_question_time == 1) {
                $setup->time_per_question = $request->set_time_per_question;
                $setup->time_total_question = null;
            } else {
                $setup->time_per_question = null;
                $setup->time_total_question = $request->set_time_total_question;
            }
            $setup->question_review = $request->question_review;
            if ($request->question_review == 1) {
                $setup->show_result_each_submit = null;
            } else {
                $setup->show_result_each_submit = $request->show_result_each_submit;
            }

            $setup->losing_type = $request->losing_type ?? 1;


            if ($request->show_ans_sheet != 1) {
                $show_ans_sheet = 0;
            } else {
                $show_ans_sheet = $request->show_ans_sheet;
            }
            $setup->show_ans_sheet = $show_ans_sheet;

            if ($request->losing_focus_acceptance_number_check != 1) {
                $losing_focus_acceptance_number = 0;
            } else {
                $losing_focus_acceptance_number = $request->losing_focus_acceptance_number;
            }

            $setup->losing_focus_acceptance_number = $losing_focus_acceptance_number;

            $setup->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function onlineExamMarksRegister($id)
    {
        try {
            $online_exam_question = OnlineQuiz::find($id);
            $students = User::where('role_id', 3)->get();
            $present_students = [];
            foreach ($students as $student) {
                $take_exam = StudentTakeOnlineQuiz::where('student_id', $student->id)->where('online_exam_id', $online_exam_question->id)->first();
                if ($take_exam != "") {
                    $present_students[] = $student->id;
                }
            }

            return view('quiz::online_exam_marks_register', compact('online_exam_question', 'students', 'present_students'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function onlineExamQuestionAssign(Request $request)
    {
        try {
            OnlineExamQuestionAssign::where('online_exam_id', $request->online_exam_id)->delete();
            if (isset($request->questions)) {
                foreach ($request->questions as $question) {
                    $assign = new OnlineExamQuestionAssign();
                    $assign->online_exam_id = $request->online_exam_id;
                    $assign->question_bank_id = $question;
                    $assign->save();
                }
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            }
            Toastr::error('No question is assigned', 'Failed');
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function onlineExamQuestionAssignByAjax(Request $request)
    {
        try {

            $online_exam = OnlineQuiz::findOrFail($request->online_exam_id);

            if (saasPlanCheck('quiz', $online_exam->totalQuestions())) {
                return response()->json([
                    'success' => 'You have no permission to add more quiz',
                    'totalQus' => $online_exam->total_marks,
                    'totalMarks' => $online_exam->total_questions,
                ], 200);
            }
            OnlineExamQuestionAssign::where('online_exam_id', $request->online_exam_id)->delete();

            if (isset($request->questions)) {
                foreach ($request->questions as $question) {
                    $assign = new OnlineExamQuestionAssign();
                    $assign->online_exam_id = $request->online_exam_id;
                    $assign->question_bank_id = $question;
                    $assign->save();
                }

                $totalMarks = $online_exam->total_marks = $online_exam->totalMarks() ?? 0;
                $totalQus = $online_exam->total_questions = $online_exam->totalQuestions() ?? 0;
                return response()->json([
                    'success' => 'Operation successful',
                    'totalQus' => $totalQus,
                    'totalMarks' => $totalMarks,
                ], 200);
            }

            return response()->json([
                'success' => 'Operation successful',
                'totalQus' => 0,
                'totalMarks' => 0,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something Went Wrong'], 500);
        }
    }

    public function viewOnlineQuestionModal($id)
    {

        try {
            $question_bank = QuestionBank::find($id);
            return view('quiz::online_eaxm_question_view_modal', compact('question_bank'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function quizResult(Request $request)
    {
        $category = $request->get('category');
        $sub_category = $request->get('sub_category');
        $quiz_id = $request->get('quiz');


        try {

            $categories = Category::orderBy('position_order', 'asc')->get();

            if ($request->category) {
                $category_search = $request->category;
            } else {
                $category_search = '';
            }

            if ($request->sub_category) {
                $subcategory_search = $request->sub_category;
            } else {
                $subcategory_search = '';
            }

            if ($request->course) {
                $course_search = $request->course;
            } else {
                $course_search = '';
            }


            $query = QuizTest::with('details', 'user');

            if (Auth::user()->role_id != 1 && isModuleActive('OrgInstructorPolicy')) {

                //                $quiz =Auth::user()->policy->course_assigns;
                //                $ids = [];
                //                $code = [];
                //                $user_qurey = DB::table('users')->where('role_id', 3)->where('teach_via', 1);
                //                if (Auth::user()->policy) {
                //                    $branches = Auth::user()->policy->branches;
                //                    foreach ($branches as $branch) {
                //                        $code[] = $branch->branch->code;
                //                    }
                //                    $user_qurey->whereIn('org_chart_code', $code);
                //                }
                //                $ids = $user_qurey->select('id')->pluck('id');
                //
                //
                //                $query->whereIn('user_id', $ids);
            } elseif (Auth::user()->role_id == 2) {
                $query->whereHas('course', function ($q) {
                    $q->where('user_id', Auth::id());
                });
            }

            $allReports = $query->latest()->get();


            $reports = [];
            foreach ($allReports as $key => $report) {
                $quiz = OnlineQuiz::with('category', 'subCategory')->where('id', $report->quiz_id)->first();
                if ($quiz) {
                    if ((empty($category) || $quiz->category_id == $category) &&
                        (empty($sub_category) || $quiz->sub_category_id == $sub_category) &&
                        (empty($quiz_id) || $quiz->id == $quiz_id)
                    ) {

                        $reports[$key]['date'] = showDate($report->start_at) ?? "";
                        $reports[$key]['status'] = $report->publish ?? "";
                        $reports[$key]['pass'] = $report->pass ?? "";
                        $reports[$key]['user_name'] = $report->user->name ?? "";
                        $reports[$key]['category'] = $quiz->category->name ?? "";
                        $reports[$key]['subCategory'] = $quiz->subCategory->name ?? "";
                        $reports[$key]['quiz'] = $quiz->title ?? "";


                        $totalCorrect = $report->details->where('status', 1)->sum('mark');
                        $totalMark = $quiz->totalMarks();

                        $reports[$key]['totalMarks'] = $totalMark;
                        $reports[$key]['marks'] = $totalCorrect;
                    }
                }
            }
            $data = [];
            if (isModuleActive('Org')) {
                $data['positions'] = OrgPosition::orderBy('order', 'asc')->get();
                $data['branches'] = OrgBranch::where('parent_id', 0)->orderBy('order', 'asc')->get();
            }

            return view('quiz::online_exam_report', $data, compact('course_search', 'subcategory_search', 'category_search', 'categories', 'reports'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function quizMarkingStore(Request $request)
    {

        try {
            $test = QuizTest::where('id', $request->quizTestId)->with('details', 'user')->first();

            if ($test->publish == 1) {
                Toastr::error('Marks Already Given', trans('common.Failed'));
                return redirect()->back();
            }
            DB::beginTransaction();

            foreach ($request->question as $key => $question) {
                if ($request->mark[$question] > $request->question_marks[$question]) {
                    Toastr::error('Given Marks Should not greater than question marks', trans('common.Failed'));
                    return redirect()->back();
                } else {
                    $quizDetails = QuizTestDetails::where('quiz_test_id', $test->id)->where('qus_id', $question)->first();
                    if (!empty($quizDetails) && $request->mark[$question] > 0) {
                        $quizDetails->status = 1;
                    }
                    if (!empty($quizDetails) && $request->question_type[$question] != 'M') {
                        $quizDetails->mark = $request->mark[$question];
                        $quizDetails->save();
                    }
                }
            }
            $question_given_marks = QuizTestDetails::where('quiz_test_id', $test->id)->sum('mark');
            $quiz_marking = QuizMarking::where('quiz_test_id', $test->id)->where('student_id', $test->user_id)->where('quiz_id', $test->quiz_id)->first();
            if ($quiz_marking) {
                $quiz_marking->marked_by = Auth::user()->id ?? 1;
                $quiz_marking->marking_status = 1;
                $quiz_marking->marks = $question_given_marks;
                $quiz_marking->save();
            }


            $quiz = OnlineQuiz::find($test->quiz_id);
            $totalScore = totalQuizMarks($quiz->id);


            $result['passMark'] = $quiz->percentage ?? 0;
            $result['mark'] = $question_given_marks > 0 ? number_format($question_given_marks / $totalScore * 100, 1) : 0;
            $result['status'] = $result['mark'] >= $result['passMark'] ? "Passed" : "Failed";
            $result['text_color'] = $result['mark'] >= $result['passMark'] ? "success_text" : "error_text";
            $test->pass = $result['mark'] >= $result['passMark'] ? "1" : "0";
            $test->publish = 1;
            $test->save();
            DB::commit();

            if (UserEmailNotificationSetup('QUIZ_RESULT_TEMPLATE', $test->user)) {
                SendGeneralEmail::dispatch($test->user, 'QUIZ_RESULT_TEMPLATE', [
                    'quiz' => $quiz->title,
                    'mark' => $question_given_marks,
                    'total' => $totalScore,
                    'status' => $test->pass == 1 ? 'Passed' : 'Failed',
                ]);
            }
            if (UserBrowserNotificationSetup('QUIZ_RESULT_TEMPLATE', $test->user)) {
                send_browser_notification(
                    $test->user,
                    'QUIZ_RESULT_TEMPLATE',
                    [
                        'quiz' => $quiz->title,
                        'mark' => $question_given_marks,
                        'total' => $totalScore,
                        'status' => $test->pass == 1 ? 'Passed' : 'Failed',
                    ],
                    '', //actionText
                    '' //actionUrl
                );
            }

            if (UserMobileNotificationSetup('Course_Chapter_Added', $test->user) && !empty($test->user->device_token)) {
                send_mobile_notification($test->user, 'Course_Chapter_Added', [
                    'quiz' => $quiz->title,
                    'mark' => $question_given_marks,
                    'total' => $totalScore,
                    'status' => $test->pass == 1 ? 'Passed' : 'Failed',
                ]);
            }
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect('quiz/quiz-enrolled-student/' . $test->quiz_id);
        } catch (\Exception $e) {
            DB::rollback();
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function enrolledStudent($id, Request $request)
    {
        try {
            $quiz_type = '';
            if ($request->type) {
                $type = $request->type;
                if ($type == "Course") {
                    $quiz_type = 1;
                } elseif ($type == "Quiz") {
                    $quiz_type = 2;
                }
            } else {
                $type = '';
            }

            $quiz = OnlineQuiz::find($id);
            if (empty($quiz_type)) {
                $quizTests = QuizTest::where('quiz_id', $quiz->id)->with('details', 'quiz', 'user')->get();
            } else {
                $quizTests = QuizTest::where('quiz_id', $quiz->id)->where('quiz_type', $quiz_type)->with('details', 'quiz', 'user')->get();
            }
            $student_details = [];
            if (isModuleActive('OrgInstructorPolicy')) {
                $user = Auth::user();
                if ($user->role_id != 1) {
                    $ids = $user->policy->course_assigns->pluck('course_id')->toArray();
                    $quizTests = $quizTests->whereIn('course_id', $ids);
                }
            }

            foreach ($quizTests as $key => $test) {
                $student_details[$key]['id'] = $test->user->id;
                $student_details[$key]['role_id'] = $test->user->role_id;
                $student_details[$key]['date'] = showDate($test->start_at);
                $student_details[$key]['name'] = $test->user->name;
                if (isModuleActive('Org')) {
                    $student_details[$key]['branch_name'] = $test->user->branch->group;
                }
                $student_details[$key]['quiz_id'] = $id;
                $student_details[$key]['course_id'] = $test->course_id;
                $student_details[$key]['status'] = $test->publish;
                $student_details[$key]['pass'] = $test->pass;
                $student_details[$key]['duration'] = $test->duration;
                $student_details[$key]['test_id'] = $test->id;
                $student_details[$key]['quizDetails'] = $test->details;
                $student_details[$key]['focus_lost'] = $test->focus_lost;
            }
            return view('quiz::online_exam_enrolled', compact('type', 'quiz', 'student_details'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function markingScript($quiz_test_id)
    {
        try {
            $quizTest = QuizTest::where('id', $quiz_test_id)->with('details', 'user')->first();
            $data = [];

            $user = $quizTest->user->id;

            $questions = [];
            if (Auth::check() && $quizTest->user_id == $user) {

                $quizSetup = QuizeSetup::getData();

                $course = Course::with('quiz')
                    ->where('courses.id', $quizTest->course_id)->first();

                $quiz = OnlineQuiz::with('assign', 'assign.questionBank', 'assign.questionBank.questionMu')->findOrFail($quizTest->quiz_id);

                foreach (@$quiz->assign as $key => $assign) {

                    $questions[$key]['qus_id'] = $assign->questionBank->id;
                    $questions[$key]['qus'] = $assign->questionBank->question;
                    $questions[$key]['type'] = $assign->questionBank->type;
                    $questions[$key]['image'] = $assign->questionBank->image;
                    $questions[$key]['question_marks'] = $assign->questionBank->marks;
                    $test_answer = QuizTestDetails::where('quiz_test_id', $quizTest->id)->where('qus_id', $assign->questionBank->id)->first();
                    if ($test_answer) {
                        $test_ans_mark = $test_answer->mark;
                        $test_ans_answer = $test_answer->answer;
                    } else {
                        $test_ans_mark = 0;
                        $test_ans_answer = '';
                    }

                    $questions[$key]['mark'] = $test_ans_mark;
                    if ($assign->questionBank->type != 'M') {
                        $questions[$key]['answer'] = $test_ans_answer;
                    } else {
                        foreach (@$assign->questionBank->questionMuInSerial as $key2 => $option) {
                            $questions[$key]['option'][$key2]['title'] = $option->title;
                            $questions[$key]['option'][$key2]['right'] = $option->status == 1 ? true : false;
                        }

                        $test = QuizTestDetails::where('quiz_test_id', $quizTest->id)->where('qus_id', $assign->questionBank->id)->first();
                        if ($test) {
                            $questions[$key]['isSubmit'] = true;
                            if ($test->status == 0) {
                                $questions[$key]['option'][$key2]['wrong'] = $test->status == 0 ? true : false;
                                $questions[$key]['isWrong'] = true;
                            }
                        }
                    }
                }
                return view('quiz::online_exam_marking', compact('questions', 'quizSetup', 'course', 'data', 'quizTest'));
            } else {
                Toastr::error('Permission Denied', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function getTotalQuizNumbers(Request $request)
    {
        if (Auth::check()) {
            $query = QuestionBank::query();
            if (Auth::user()->role_id == 2) {
                $query->where('user_id', Auth::user()->id);
            }
            if (!empty($request->category_id)) {
                $query->where('category_id', $request->category_id);
            }
            if (!empty($request->subcategory_id)) {
                $query->where('sub_category_id', $request->subcategory_id);
            }
            if (!empty($request->group_id)) {
                $query->where('q_group_id', $request->group_id);
            }
            return $query->count();
        } else {
            return 0;
        }
    }

    public function query()
    {
        $query = QuizTest::with(['course', 'quiz', 'user']);

        if (\request('student_status')) {
            $query->whereHas('user', function ($q) {
                return $q->where('status', \request('student_status'));
            });
        }

        if (\request('category')) {
            $category = Category::find(request('category'));
            if ($category) {

                $ids = $category->getAllChildIds($category, [$category->id]);

                $query->whereHas('quiz', function ($q) use ($ids) {
                    $q->whereIn('category_id', $ids);
                    $q->orWhereIn('sub_category_id', $ids);
                });
            }
        }
        if (\request('type')) {
            $query->where('quiz_type', \request('type'));
        }

        if (isModuleActive('Org')) {
            if (\request('required_type')) {
                $query->whereHas('course', function ($q) {
                    return $q->where('required_type', \request('required_type'));
                });
            }
            if (\request('mode_of_delivery')) {
                $query->whereHas('course', function ($q) {
                    return $q->where('mode_of_delivery', \request('mode_of_delivery'));
                });
            }
            if (\request('org_branch')) {
                $query->whereHas('user', function ($q) {
                    return $q->where('org_chart_code', \request('org_branch'));
                });
            }
            if (\request('job_position')) {
                $query->whereHas('user', function ($q) {

                    return $q->where('org_position_code', \request('job_position'));
                });
            }

            if (isModuleActive('OrgInstructorPolicy')) {
                $user = Auth::user();
                if ($user->role_id != 1) {

                    $course_ids = $user->policy->course_assigns->pluck('course_id')->toArray();
                    $query->whereIn('course_id', $course_ids);
                }
            }
        }


        return $query;
    }

    public function quizResultData()
    {
        $query = $this->query();
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('student_name', function ($query) {
                return $query->user->name;
            })
            ->addColumn('employee_id', function ($query) {
                return $query->user->employee_id;
            })
            ->addColumn('org_chart_code', function ($query) {
                return $query->user->org_chart_code;
            })
            ->addColumn('org_position_code', function ($query) {
                return $query->user->org_position_code;
            })
            ->addColumn('course_name', function ($query) {
                return $query->course->title;
            })
            ->addColumn('quiz_name', function ($query) {
                return $query->quiz->title;
            })
            ->addColumn('percentage', function ($query) {
                return $query->quiz->percentage . '%';
            })
            ->editColumn('start_at', function ($query) {
                return showDate($query->start_at) . ' ' . Carbon::parse($query->start_at)->format('h:i A');
            })
            ->editColumn('end_at', function ($query) {
                return showDate($query->end_at) . ' ' . Carbon::parse($query->end_at)->format('h:i A');
            })
            ->addColumn('marks', function ($query) {
                $totalCorrect = $query->details->where('status', 1)->sum('mark');
                $totalMark = $query->quiz->totalMarks();

                return $totalCorrect . '/' . $totalMark;
            })->editColumn('duration', function ($query) {
                if ($query->duration == 0) {
                    return 0;
                } else {
                    return $query->duration;
                }
            })->addColumn('status', function ($query) {
                if ($query->pass == 1) {
                    return trans('common.Pass');
                } else {
                    return trans('common.Fail');
                }
            })
            ->addColumn('result', function ($query) {
                $totalCorrect = $query->details->where('status', 1)->sum('mark');
                $totalMark = $query->quiz->totalMarks();

                if ($totalCorrect == 0) {
                    $result = 0;
                } else {
                    $result = number_format(($totalCorrect / $totalMark) * 100, 1);
                }
                return $result . '%';
            })
            ->make(true);
    }

    public function quizResultExport()
    {
        return Excel::download(new OnlineQuizReport(), 'quiz-report.xlsx');
    }

    public function quizReTest($id)
    {
        $test = QuizTest::find($id);
        if ($test) {
            $details = $test->details;
            foreach ($details as $item) {
                $ans = $item->answers;
                foreach ($ans as $a) {
                    $a->delete();
                }
                $item->delete();
            }
            $test->delete();
        }
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }
}
