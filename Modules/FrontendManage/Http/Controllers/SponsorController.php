<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Modules\FrontendManage\Entities\Sponsor;

class SponsorController extends Controller
{
    use ImageStore;

    public function index()
    {
        try {
            $sponsors = Sponsor::all();
            return view('frontendmanage::sponsors', compact('sponsors'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function create()
    {
        return view('frontendmanage::create');
    }

    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $code = auth()->user()->language_code;

        $rules = [
            'title.' . $code => 'required|max:255',
            'image' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $sponsor = new Sponsor();
            foreach ($request->title as $key => $title) {
                $sponsor->setTranslation('title', $key, $title);
            }
            if ($request->file('image') != "") {
                $sponsor->image = $this->saveImage($request->image);
            }
            $sponsor->save();
            Toastr::success(trans('sponsor.Sponsor Saved Successfully'));
            return back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function show($id)
    {
        return view('frontendmanage::show');
    }

    public function edit($id)
    {
        try {
            $sponsors = Sponsor::all();

            $sponsor = Sponsor::findOrFail($id);
            return view('frontendmanage::sponsors', compact('sponsors', 'sponsor'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $code = auth()->user()->language_code;

        $rules = [
            'title.' . $code => 'required|unique:sponsors,title,' . $request->id,
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $sponsor = Sponsor::find($request->id);
            foreach ($request->title as $key => $title) {
                $sponsor->setTranslation('title', $key, $title);
            }
            if ($request->file('image') != "") {
                $sponsor->image = $this->saveImage($request->image);
            }
            $sponsor->save();
            Toastr::success(trans('sponsor.Sponsor Updated Successfully'));
            return redirect()->route('frontend.sponsors.index');
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
            Sponsor::destroy($id);
            Toastr::success(trans('sponsor.Sponsor Deleted Successfully'));
            return redirect()->route('frontend.sponsors.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
