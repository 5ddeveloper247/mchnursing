<?php

namespace Modules\Setting\Http\Controllers;

use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Entities\UserGamificationPoint;
use Yajra\DataTables\Facades\DataTables;

class GamificationHistoryController extends Controller
{
    public function index()
    {
        return view('setting::gamification.history');
    }

    public function data(Request $request)
    {

        $query = User::select('id', 'name', 'image', 'email', 'gamification_total_points', 'gamification_total_spent_points')->where('role_id', '!=', 1);


        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($query) {
                return " <div class=\"profile_info\"><img src='" . getStudentImage($query->image) . "'   alt='" . $query->name . " image'></div>";
            })->editColumn('name', function ($query) {
                return $query->name;

            })->editColumn('email', function ($query) {
                return $query->email;

            })->addColumn('gamification_total_remain_points', function ($query) {
                return $query->gamification_total_points - $query->gamification_total_spent_points;
            })
            ->addColumn('action', function ($query) {


                $details = '<button class="dropdown-item detailsHistory"
                                                                    data-id="' . $query->id . '"
                                                                    data-type="1"
                                                                    data-title="' . trans('setting.Earn History') . '"
                                                                    type="button">' . trans('setting.Earn History') . '</button>';
                $details .= '<button class="dropdown-item detailsHistory"
                                                                    data-id="' . $query->id . '"
                                                                      data-type="2"
                                                                    data-title="' . trans('setting.Spent History') . '"
                                                                    type="button">' . trans('setting.Spent History') . '</button>';


                return ' <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu' . $query->id . '" data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        ' . trans('common.Action') . '
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu' . $query->id . '">
                                                        ' . $details . '
                                                    </div>
                                                </div>';


            })->rawColumns(['image', 'action'])
            ->make(true);
    }

    public function history_details($type, $id)
    {
        $details = UserGamificationPoint::where('status', $type)->where('point', '!=', 0)->where('user_id', $id)->get();
        return view('setting::gamification._modal_history', compact('details'));
    }

}
