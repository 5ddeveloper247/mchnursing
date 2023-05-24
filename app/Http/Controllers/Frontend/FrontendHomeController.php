<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\Blog\Entities\Blog;
use Modules\CourseSetting\Entities\CourseReveiw;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\StudentSetting\Entities\Program;


class FrontendHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenanceMode');
    }

    public function index()
    {
        try {

            if (!\auth()->check()) {
                if (Settings('start_site') == 'loginpage') {

                    return redirect()->route('login');
                }
            }
            $check = FrontPage::select('slug', 'is_static')->where('homepage', 1)->first();
            if ($check && $check->slug != '/') {

                if ($check->is_static == 1) {
                    return redirect()->to($check->slug);
                } else {
                    return redirect()->route('frontPage', [$check->slug]);
                }
            }
            // if (hasDynamicPage()) {
            //     $row = FrontPage::where('slug', '/')->first();
            //     $details = dynamicContentAppend($row->details);
            //     return view('aorapagebuilder::pages.show', compact('row', 'details'));
            // } else {
            if (function_exists('SaasDomain')) {
                $domain = SaasDomain();
            } else {
                $domain = 'main';
            }
            $blocks = Cache::rememberForever('homepage_block_positions' . $domain, function () {
                return DB::table('homepage_block_positions')->select(['id', 'block_name', 'order'])->orderBy('order', 'asc')->get();
            });
            $lastest_programs = Program::where('status', 1)->has('currentProgramPlan')->with('currentProgramPlan')->latest()->limit(4)->get();
            $lastest_blogs = Blog::where('status', 1)->with('user')->latest()->limit(4)->get();
            $lastest_course_reveiws = CourseReveiw::where('status', 1)->with('user')->latest()->limit(4)->get();

            return view(theme('pages.index'), compact('blocks', 'lastest_programs', 'lastest_blogs', 'lastest_course_reveiws'));
            // }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function test()
    {
        dd('kamran');
        return view(theme('pages.new_test_page'));
        // return view(theme('pages.test'));
    }
}
