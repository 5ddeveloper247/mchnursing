<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Modules\FrontendManage\Entities\FrontPage;

class FrontPageController extends Controller
{
    use ImageStore;


    public function index()
    {

        $query = FrontPage::query();
        if (!hasDynamicPage()) {
            $query->where('is_static', '=', '0');
        } else {
            $query->where('is_static', 0)->orWhere(function ($q) {
                $slugs = [
                    '/',
                    '/courses',
                    '/classes',
                    '/quizzes',
                    '/instructors',
                    '/contact-us',
                    '/about-us',
                    '/become-instructor',
                    '/blog',
                    'free-course',
                    'certificate-verification'
                ];
                $q->where('is_static', 1)->whereIn('slug', $slugs);
            });
        }

        $frontPages = $query->latest()->get();
        return view('frontendmanage::front_page.index', compact('frontPages'));
    }


    public function create()
    {
        return view('frontendmanage::front_page.create');
    }

    public function store(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }
        $code = auth()->user()->language_code;

        $rules = [
            'title.' . $code => 'required|max:255',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $frontpage = new FrontPage();

            foreach ((array)$request->title as $key => $value) {
                $frontpage->setTranslation('title', $key, $value);
            }
            foreach ((array)$request->sub_title as $key => $value) {
                $frontpage->setTranslation('sub_title', $key, $value);
            }
            if (!hasDynamicPage()) {
                foreach ($request->details as $key => $value) {
                    $frontpage->setTranslation('details', $key, $value);
                }
            }


            $frontpage->is_static = 0;
            $frontpage->save();

            if ($request->banner != null) {
                $frontpage->banner = $this->saveImage($request->banner);
                $frontpage->is_static = 0;
            }

            $frontpage->name = $frontpage->title;
            if ($this->checkUrl($request->slug)) {
                Toastr::error(trans('common.URL Already Exist'), trans('common.Error'));
                return redirect()->back();

            }

            $frontpage->slug = $this->createSlug(empty($request->slug) ? $frontpage->title : $request->slug);
            $frontpage->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('frontend.page.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function show($id)
    {
        $row = FrontPage::find($id);
        if (!$row) {
            abort(404);
        }

        $active = request('lang', auth()->user()->language_code);
        app()->setLocale($active);
        $data['row'] = $row;
        $data['details'] = $row->details;
        return view('aorapagebuilder::pages.design', $data, compact('active'));
    }


    public function edit($id)
    {
        $data['editData'] = FrontPage::findOrFail($id);
        return view('frontendmanage::front_page.create', $data);

    }

    public function update(Request $request, $id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $page = FrontPage::findOrFail($id);

        $code = auth()->user()->language_code;

        $rules = [
            'title.' . $code => 'required|max:255',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            foreach ((array)$request->title as $key => $value) {
                $page->setTranslation('title', $key, $value);
            }
            foreach ((array)$request->sub_title as $key => $value) {
                $page->setTranslation('sub_title', $key, $value);
            }
            if (!hasDynamicPage()) {
                foreach ($request->details as $key => $value) {
                    $page->setTranslation('details', $key, $value);
                }
            }

            $page->name = $page->title;

            if ($this->checkUrl($request->slug)) {
                Toastr::error(trans('common.URL Already Exist'), trans('common.Error'));
                return redirect()->back();
            }

            if ($page->is_static == 1 && !empty($request->slug)) {
                $page->slug = $this->createSlug($request->slug);
            }

            if ($request->banner != null) {
                $page->banner = $this->saveImage($request->banner);
            }

            $page->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('frontend.page.index');
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
            $page = FrontPage::where('id', $id)->first();
            if ($page->is_static != 1) {
                $page->delete();
            }
            Toastr::success('Operation done successfully.', 'Success');
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    protected function createSlug(string $title): string
    {

        $slugsFound = $this->getSlugs($title);

        $counter = 0;
        $counter += $slugsFound;

        $slug = Str::slug($title) == "" ? str_replace(' ', '-', $title) : Str::slug($title);


        if ($counter) {
            $slug = $slug . '-' . $counter;
        }
        return $slug;
    }


    protected function getSlugs($title): int
    {
        return FrontPage::select()->where('title', 'like', $title)->count();
    }

    public function changeHomepage(Request $request, $id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        FrontPage::query()->update([
            'homepage' => 0
        ]);
        FrontPage::where('id', $id)->update([
            'homepage' => 1
        ]);
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));

        return redirect()->back();
    }

    public function checkUrl($url = null)
    {
        $status = false;
        if (!empty($url)) {
            $routes = Route::getRoutes()->getRoutes();
            foreach ($routes as $r) {
                if ($r->uri() == $url) {
                    return true;
                }
            }
        }
        return $status;
    }
}
