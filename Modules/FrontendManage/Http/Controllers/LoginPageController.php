<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FrontendManage\Entities\LoginPage;

class LoginPageController extends Controller
{
    use ImageStore;

    public function index()
    {
        $page = LoginPage::getData();
        return view('frontendmanage::loginpage', compact('page'));
    }


    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $page = LoginPage::first();
        foreach ($request->title as $key => $title) {
            $page->setTranslation('title', $key, $title);
        }
        if ($request->banner != null) {

            $page->banner =  $this->saveImage($request->banner);
        }
        foreach ($request->slogan1 as $key => $slogans1) {
            $page->setTranslation('slogans1', $key, $slogans1);
        }

        foreach ($request->slogan2 as $key => $slogans2) {
            $page->setTranslation('slogans2', $key, $slogans2);
        }

        foreach ($request->slogan3 as $key => $slogan3) {
            $page->setTranslation('slogans3', $key, $slogan3);
        }

        foreach ($request->reg_title as $key => $reg_title) {
            $page->setTranslation('reg_title', $key, $reg_title);
        }
        if ($request->reg_banner != null) {

            if ($request->file('reg_banner')->extension() == "svg") {
                $file = $request->file('reg_banner');
                $fileName = md5(rand(0, 9999) . '_' . time()) . '.' . $file->clientExtension();
                $url = 'public/uploads/settings/' . $fileName;
                $file->move(public_path('uploads/settings'), $fileName);
            } else {
                $url = $this->saveImage($request->reg_banner);
            }

            $page->reg_banner = $url;
        }

        foreach ($request->reg_slogan1 as $key => $slogans1) {
            $page->setTranslation('reg_slogans1', $key, $slogans1);
        }

        foreach ($request->reg_slogan2 as $key => $slogans2) {
            $page->setTranslation('reg_slogans2', $key, $slogans2);
        }

        foreach ($request->reg_slogan3 as $key => $slogan3) {
            $page->setTranslation('reg_slogans3', $key, $slogan3);
        }


        foreach ($request->forget_title as $key => $forget_title) {
            $page->setTranslation('forget_title', $key, $forget_title);
        }
        if ($request->forget_banner != null) {

            if ($request->file('forget_banner')->extension() == "svg") {
                $file = $request->file('forget_banner');
                $fileName = md5(rand(0, 9999) . '_' . time()) . '.' . $file->clientExtension();
                $url = 'public/uploads/settings/' . $fileName;
                $file->move(public_path('uploads/settings'), $fileName);
            } else {
                $url = $this->saveImage($request->forget_banner);
            }

            $page->forget_banner = $url;
        }
        foreach ($request->forget_slogan1 as $key => $slogans1) {
            $page->setTranslation('forget_slogans1', $key, $slogans1);
        }

        foreach ($request->forget_slogan2 as $key => $slogans2) {
            $page->setTranslation('forget_slogans2', $key, $slogans2);
        }

        foreach ($request->forget_slogan3 as $key => $slogan3) {
            $page->setTranslation('forget_slogans3', $key, $slogan3);
        }
        $page->save();

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }


}
