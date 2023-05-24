<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Payment\Entities\StudentProgramPaymentPlans;
use Modules\StudentSetting\Entities\Program;
use Modules\VirtualClass\Entities\VirtualClass;

class CronController extends Controller
{
//evey day
    public function incoming_installment()
    {
        $start_date = Carbon::tomorrow()->format('Y-m-d');
        $end_date = Carbon::tomorrow()->format('Y-m-d');
        $installments = StudentProgramPaymentPlans::with(['user', 'program', 'plan'])->where('pay_status', 'pay')->where(function ($q) use ($start_date, $end_date) {
            $q->whereBetween('sdate', [$start_date, $end_date]);
//                ->orWhereBetween('edate',[$start_date,$end_date])
//                ->orWhere(function ($q) use($start_date,$end_date){
//                    $q->where('sdate','<=', $start_date)->where('edate','>=', $end_date);
//                });
        })->get();

        foreach ($installments as $installment) {

            Log::info('program_coming_installment->send mail');
            send_email($installment->user, 'program_coming_installment', [
                'program' => $installment->program->programtitle ?? 'Delete program',
                'plan' => $installment->plan->plan_order ?? 'Delete plan',
                'amount' => $installment->amount,
                'date' => $installment->sdate,
            ]);
            echo "send mail to " . ($installment->user->name ?? 'Delete user');

        }

    }

//evey day
    public function previous_installment()
    {
        $start_date = Carbon::yesterday()->format('Y-m-d');
        $end_date = Carbon::yesterday()->format('Y-m-d');
        $installments = StudentProgramPaymentPlans::with(['user', 'program', 'plan'])->where('pay_status', 'pay')->where(function ($q) use ($start_date, $end_date) {
            $q->whereBetween('sdate', [$start_date, $end_date]);
//                ->orWhereBetween('edate',[$start_date,$end_date])
//                ->orWhere(function ($q) use($start_date,$end_date){
//                    $q->where('sdate','<=', $start_date)->where('edate','>=', $end_date);
//                });
        })->get();

        foreach ($installments as $installment) {

            Log::info('program_previous_installment->send mail');
            send_email($installment->user, 'program_previous_installment', [
                'program' => $installment->program->programtitle ?? 'Delete program',
                'plan' => $installment->plan->plan_order ?? 'Delete plan',
                'amount' => $installment->amount,
                'date' => $installment->sdate,
            ]);
            echo "send mail to " . ($installment->user->name ?? 'Delete user');

        }

    }

//evey two days
    public function classes_reminder()
    {
        $scond_day = Carbon::today()->addDays(2)->format('D');
        $next_day = Carbon::tomorrow()->format('D');

        $CLasses = VirtualClass::whereIn('class_day', [$scond_day, $next_day])->with(['course'])->get();

        foreach ($CLasses as $CLass) {
            $programs = Program::Where('allcourses', 'like', '%,"' . $CLass->course_id . '",%')->pluck('id');
            $query = CourseEnrolled::where('course_id', null)->with('user')
                ->whereHas('program', function ($query) {

                });
            $query = $query->whereIn('program_id', $programs->unique())->groupBy('program_id')->groupBy('user_id')->pluck('user_id')->toArray();
            $users = User::with('sender')->where('id', '!=', Auth::id())->whereIn('id', $query)->get();


            if (count($users)) {
                foreach ($users as $user) {
                    Log::info('class_reminder->send mail');
                    send_email($user, 'class_reminder', [
                        'course' => $CLass->course->title ?? 'Delete course',
                        'class' => $CLass->title ?? 'Delete Class',
                        'start_date' => $CLass->start_date,
                    ]);
                    echo "send mail to " . ($user->name ?? 'Delete user');

                }
            }

        }


    }
    //evey two days
    public function quiz_reminder()
    {
//        $scond_day = Carbon::today()->addDays(2)->format('D');
//        $next_day = Carbon::tomorrow()->format('D');
//
//        $CLasses = VirtualClass::whereIn('class_day', [$scond_day, $next_day])->with(['course'])->get();
//
//        foreach ($CLasses as $CLass) {
//            $programs = Program::Where('allcourses', 'like', '%,"' . $CLass->course_id . '",%')->pluck('id');
//            $query = CourseEnrolled::where('course_id', null)->with('user')
//                ->whereHas('program', function ($query) {
//
//                });
//            $query = $query->whereIn('program_id', $programs->unique())->groupBy('program_id')->groupBy('user_id')->pluck('user_id')->toArray();
//            $users = User::with('sender')->where('id', '!=', Auth::id())->whereIn('id', $query)->get();
//
//
//            if (count($users)) {
//                foreach ($users as $user) {
//                    Log::info('class_reminder->send mail');
//                    send_email($user, 'class_reminder', [
//                        'course' => $CLass->course->title ?? 'Delete course',
//                        'plan' => $CLass->title ?? 'Delete Class',
//                        'start_date' => $CLass->start_date,
//                    ]);
//                    echo "send mail to " . ($user->name ?? 'Delete user');
//
//                }
//            }
//
//        }


    }
}
