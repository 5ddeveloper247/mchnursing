<?php

namespace Modules\CourseSetting\Http\Controllers;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Chapter;
use Modules\CourseSetting\Entities\TimeTable;
use Modules\CourseSetting\Entities\TimeTableList;
use Yajra\DataTables\Facades\DataTables;

class TimeTableController extends Controller
{

    public function index()
    {
        return view('coursesetting::timetable.timetables');
    }

    public function store(Request $request)
    {
        Session::flash('Addtime', 1);
        $request->validate([
            'name' => 'required',
        ]);

        try {
            $time_table = new TimeTable();
            $time_table->name = $request->name;
            $time_table->save();

            for ($weeks=1; $weeks <= 6; $weeks++){
                for ($days=1; $days <= 7; $days++){
//                        echo $weeks .' '. $days .'<br>';
                    $time_table_list = new TimeTableList();
                    $time_table_list->week = $weeks;
                    $time_table_list->day = $days;
                    $time_table_list->time_table_id = $time_table->id;
                    $time_table_list->save();
                }
            }
            Toastr::success(trans('Time Table successfully created'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error(trans('Operation failed'), trans('Error'));
            return redirect()->back();
        }
    }


    public function getAllTimeTable()
    {
        $query = TimeTable::all();
        return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('name', function ($query) {
                return $query->name;
            })->addColumn('status', function ($query) {
                $route = 'student.change_status';
                return view('backend.partials._td_status', compact('query', 'route'));
            })->addColumn('action', function ($query) {
                return view('coursesetting::components._td_timetable_action', compact('query'));
            })->rawColumns(['status', 'action'])->make(true);
    }

    public function delete($id)
    {

        try {

            $delete = TimeTable::find($id);

            TimeTableList::where('time_table_id',$id)->delete();

            $delete->delete();

            Toastr::success(trans('Time Table successfully deleted'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error(trans('Operation failed'), trans('Error'));
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $time_table = TimeTable::find($id);
        $time_tables = TimeTableList::where('time_table_id',$id)->groupBy('week')->orderBy('week')->get();
        $instructors= User::where('role_id', 2)->where('status', '1')->get(['id','name']);
        return view('coursesetting::timetable.time_table_list',compact('time_tables','instructors','time_table'));
    }
    public function saveList(Request $request)
    {
//        Session::flash('Addtime', 1);
//        $request->validate([
//            'date' => 'required',
//            'Instructor_id' => 'required',
//            'comment' => 'required',
//        ]);

        try {

                $time_table_list = TimeTableList::find($request->id);
                $time_table_list->date = (empty($request->Instructor_id) && empty($request->comment)) ? null: Carbon::parse($request->date)->format('Y-m-d') ;
                $time_table_list->Instructor_id = (int)$request->Instructor_id;
                $time_table_list->comment = $request->comment;
                $time_table_list->save();

            Toastr::success(trans('Time Table successfully created'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error(trans('Operation failed'), trans('Error'));
            return redirect()->back();
        }
    }

}
