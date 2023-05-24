<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Modules\CourseSetting\Entities\Course;
use Modules\FrontendManage\Entities\Slider;

class SliderController extends Controller
{
    use ImageStore;

    public function index()
    {
        try {
            $sliders = Slider::all();
            $data = [];
            if (Settings('frontend_active_theme') == 'tvt') {
                $data['courses'] = Course::select('id', 'title')->where('status', 1)->get();
            }
            return view('frontendmanage::sliders', $data, compact('sliders'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function store(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'image' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $slider = new Slider();
            $slider->course_id = $request->course_id ?? '';
            $slider->title = $request->title;
            $slider->sub_title = $request->sub_title;

            $slider->btn_title1 = $request->btn_title1;
            $slider->btn_link1 = $request->btn_link1;


            $slider->btn_title2 = $request->btn_title2;
            $slider->btn_link2 = $request->btn_link2;

            if ($request->has('image')) {
                $slider->image = $this->saveImage($request->image);
            }

            if ($request->has('btn_image1')) {
                $slider->btn_image1 = $this->saveImage($request->btn_image1);
            }

            if ($request->has('btn_image2')) {
                $slider->btn_image2 = $this->saveImage($request->btn_image2);
            }

            if ($request->btn_type1 == 1) {
                $slider->btn_type1 = 1;
            } else {
                $slider->btn_type1 = 0;
            }

            if ($request->btn_type2 == 1) {
                $slider->btn_type2 = 1;
            } else {
                $slider->btn_type2 = 0;
            }
            $slider->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function edit($id)
    {
        try {
            $sliders = Slider::all();
            $slider = Slider::findOrFail($id);
            $data = [];
            if (Settings('frontend_active_theme') == 'tvt') {
                $data['courses'] = Course::select('id', 'title')->where('status', 1)->get();
            }
            return view('frontendmanage::sliders', $data, compact('sliders', 'slider'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }


        try {
            $slider = Slider::find($request->id);
            $slider->course_id = $request->course_id ?? '';
            $slider->title = $request->title;
            $slider->sub_title = $request->sub_title;

            $slider->btn_title1 = $request->btn_title1;
            $slider->btn_link1 = $request->btn_link1;


            $slider->btn_title2 = $request->btn_title2;
            $slider->btn_link2 = $request->btn_link2;

            if ($request->has('image')) {
                $slider->image = $this->saveImage($request->image);
            }

            if ($request->has('btn_image1')) {
                $slider->btn_image1 = $this->saveImage($request->btn_image1);
            }

            if ($request->has('btn_image2')) {
                $slider->btn_image2 = $this->saveImage($request->btn_image2);
            }

            if ($request->btn_type1 == 1) {
                $slider->btn_type1 = 1;
            } else {
                $slider->btn_type1 = 0;
            }

            if ($request->btn_type2 == 1) {
                $slider->btn_type2 = 1;
            } else {
                $slider->btn_type2 = 0;
            }
            $slider->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function destroy($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            Slider::destroy($id);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function setting()
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $home_content = app('getHomeContent');
            return view('frontendmanage::slider_setting', compact('home_content'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function settingSubmit(Request $request)
    {
        if (hasDynamicPage()) {
            if ($request->slider_banner != null) {
                UpdateHomeContent('slider_banner', $this->saveImage($request->slider_banner));
            }

            UpdateHomeContent('show_menu_search_box', $request->show_menu_search_box == 1 ? 1 : 0);
            UpdateHomeContent('show_banner_search_box', $request->show_banner_search_box == 1 ? 1 : 0);

        }

        UpdateGeneralSetting('slider_transition_time', $request->slider_transition_time ?? 5);
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }
}
