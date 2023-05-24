<?php

namespace Modules\SystemSetting\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\SystemSetting\Entities\TutorHiring;
use Modules\SystemSetting\Entities\TutorSlote;
use Yajra\DataTables\Facades\DataTables;


class TutorsSettingController extends Controller
{
    public function hiredTutors()
    {
        try {
            $instructors = [];

            return view('systemsetting::hired_tutors', compact('instructors'));
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function tutorSlots()
    {
        try {
            $slots = TutorSlote::where('instructor_id', Auth::id())->get();

            return view('systemsetting::tutor_slots', compact('slots'));
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function setSlotTime(Request $request)
    {

        Session::flash('slot_id', $request->id);
        $rules = [
            'id' => 'required',
            'start_time' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {

            $start_time = Carbon::parse($request->start_time);
            $end_time = Carbon::parse($request->start_time)->addHour(1);

            if (!$this->checkTimeSlot(Auth::id(), $start_time, $end_time)) {

                $user = TutorSlote::findOrFail($request->id);
                $user->start_time = $start_time->toTimeString();
                $user->end_time = $end_time->toTimeString();
                $user->save();

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            }

            Toastr::error(trans('Chose another time Already set.'), trans('common.Failed'));
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function checkTimeSlot($instructor_id, $start_time, $end_time)
    {
        return TutorSlote::where('instructor_id', $instructor_id)
            ->where(function ($q) use ($start_time, $end_time) {
                $q->where(function ($q) use ($start_time, $end_time) {
                    $q->whereTime('end_time', '>', $start_time)->whereTime('end_time', '<', $end_time);
                })
                    ->orWhere(function ($q) use ($start_time, $end_time) {
                        $q->whereTime('start_time', '>', $start_time)->whereTime('start_time', '<', $end_time);
                    })
                    ->orWhere(function ($q) use ($start_time, $end_time) {
                        $q->whereTime('start_time', '=', $start_time)->whereTime('start_time', '=', $end_time);
                    });
            })
            ->exists();
    }

    public function getAllSlots()
    {

        $query = TutorHiring::query();

        $with = [];
        if (Auth::user()->role_id == 1) {
            $with[] = 'instructor';
        }else{
            $query->where('instructor_id', Auth::id());
        }
        $with[] = 'student';

        $query->with($with);


        return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('instructor', function ($query) {
                $instructor_id = '';
                if (Auth::user()->role_id == 1) {
                    $instructor_id = $query->instructor->name;
                }
                return $instructor_id;
            })->editColumn('student', function ($query) {
                return $query->student->name;
            })->editColumn('course', function ($query) {
                return $query->course->title;
            })->editColumn('date', function ($query) {
                return Carbon::parse($query->assign_date)->format('d M Y');
            })->addColumn('start_time', function ($query) {
                return $query->assign_start_time;
            })->addColumn('end_time', function ($query) {
                return $query->assign_end_time;
            })
            ->addColumn('price', function ($query) {
                return getPriceFormat($query->price);
            })->addColumn('action', function ($query) {
                if (Carbon::parse($query->assign_date)->format('d-m-Y') == Carbon::now()->format('d-m-Y')) {
                    if (Carbon::parse($query->assign_start_time)->format('H:i:s') <= Carbon::now()->format('H:i:s') && Carbon::now()->format('H:i:s') <= Carbon::parse($query->assign_end_time)->format('H:i:s')) {
                        $currentstat = 'started';
                    } elseif (Carbon::parse($query->assign_start_time)->format('H:i:s') > Carbon::now()->format('H:i:s')) {
                        $currentstat = 'waiting';
                    }else{
                        $currentstat = 'closed';
                    }
                } else {
                    $currentstat = 'closed';
                }
                if (\Carbon\Carbon::parse($query->assign_date)->format('d-m-Y') > \Carbon\Carbon::now()->format('d-m-Y')) {
                    $currentstat = 'waiting';
                }
                if($currentstat == 'started') {
                    $html =  '<a class="primary-btn small fix-gr-bg small border-0 text-white"
                                                        href="'.  $query->meeting_join_url .'"
                                                        target="_blank">Start</a>';
                }elseif($currentstat == 'waiting') {
                    $html =  '<a href="#" class="primary-btn small bg-info border-0 text-white">Waiting</a>';
                }else {
                    $html = '<a href = "#"  class="primary-btn small bg-warning border-0 text-white" > Closed</a >';
                }
                return $html;
            })->rawColumns(['action'])->make(true);

    }
}
