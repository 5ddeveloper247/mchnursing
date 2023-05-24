<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Setting\Entities\Badge;

class BadgeController extends Controller
{
    use ImageStore;

    public function index()
    {
        $types = $this->badgesTypes();
        $badges = Badge::orderBy('point', 'asc')->get();
        return view('setting::badges.index', compact('types', 'badges'));
    }

    public function store(Request $request)
    {

        $rules = [
            'title' => 'required',
            'type' => 'required',
            'point' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));
        session()->flash('type', $request->type);

        try {
            $badge = new Badge();

            $badge->title = $request->title;
            $badge->point = $request->point;
            $badge->type = $request->type;
            $badge->status = 1;

            if ($request->image) {
                $badge->image = $this->saveImage($request->image);
            }
            $badge->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('gamification.badges');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function update(Request $request)
    {
        $rules = [
            'id' => 'required',
            'title' => 'required',
            'point' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));


        $badge = Badge::findOrFail($request->id);
        try {
            $badge->title = $request->title;
            $badge->point = $request->point;

            if ($request->image) {
                $badge->image = $this->saveImage($request->image);
            }
            $badge->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('gamification.badges');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function destroy($id)
    {
        $badge = Badge::findOrFail($id);
        $badge->delete();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->route('gamification.badges');
    }

    public function badgesTypes()
    {
        $data = [
            'activity' => trans('setting.Activity badges'),
            'registration' => trans('setting.Registration badges'),
            'learning' => trans('setting.Learning badges'),
            'courses' => trans('setting.Course count badges'),
            'rating' => trans('setting.Course rating badges'),
            'sales' => trans('setting.Course sales badges'),
            'blogs' => trans('setting.Blog post badges'),
            'test' => trans('setting.Test badges'),
            'perfectionism' => trans('setting.Perfectionism badges'),
            'communication' => trans('setting.Communication badges'),
            'certification' => trans('setting.Certification badges'),
        ];
        if (isModuleActive('Assignment')) {
            $data['assignment'] = trans('setting.Assignment badges');
        }
        if (isModuleActive('Survey')) {
            $data['survey'] = trans('setting.Survey badges');
        }
        if (isModuleActive('Forum')) {
            $data['forum'] = trans('setting.Forum badges');
        }

        return $data;
    }

    public function pointType()
    {
        return [
            'each_login',
            'each_unit_complete',
            'each_course_complete',
            'each_certificate',
            'each_test_complete',
            'each_assignment_complete',
            'each_comment',
        ];
    }
}
