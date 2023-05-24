<?php

use App\AboutPage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Modules\FrontendManage\Entities\BecomeInstructor;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\FrontendManage\Entities\HomeContent;
use Modules\FrontendManage\Entities\WorkProcess;
use Modules\Setting\Http\Controllers\UpdateController;


class AddDefaultPageDesign extends Migration
{
    public function up()
    {

        $update = new UpdateController();
        $update->allClear();


        View::composer(['frontend.*'], function ($view) {
            $data['frontendContent'] = $data['homeContent'] = json_decode(json_encode($this->homeContents()));

            $data['about_page'] = AboutPage::first();
            $data['become_instructor'] = BecomeInstructor::all();
            $data['work_progress'] = WorkProcess::select('title', 'description')->where('status', 1)->get();
            $view->with($data);
        });


        $link = base_path('resources/views/frontend/infixlmstheme/snippets/pages/*.blade.php');
        $pages = glob($link);
        foreach ($pages as $page) {
            $filename = Str::of($page)->basename('.blade.php');
            if ($filename == 'affiliate' || $filename == 'appointment') {
                continue;
            }

            $banner = $this->addBanner($filename);

            $content = \response()->view('frontend.infixlmstheme.snippets.pages.' . $filename)->content();;


            try {
                $dom = new DomDocument();
                libxml_use_internal_errors(true);
                $dom->loadHTML($content);
                libxml_clear_errors();
                $finder = new DomXPath($dom);
                $classname = "full-page";
                $nodes = $finder->query("//*[contains(@class, '$classname')]");
//                $tmp_dom = new DOMDocument();
                foreach ($nodes as $node) {
                    $node->parentNode->removeChild($node);
//                }
//                    $tmp_dom->appendChild($tmp_dom->importNode($node, true));
                }
                $content = trim($dom->saveHTML());

                $content = str_replace('&#xE2;&#x80;&#x99;', "'", $content);
                $content = str_replace('&acirc;&#128;&#153;', "'", $content);


            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }


            $slug = '';
            if ($filename == 'home') {
                $slug = '/';
            } elseif ($filename == 'about-us') {
                $slug = '/about-us';
            } elseif ($filename == 'become-instructor') {
                $slug = '/become-instructor';
            } elseif ($filename == 'blogs') {
                $slug = '/blogs';
            } elseif ($filename == 'certificate-verification') {
                $slug = 'certificate-verification';
            } elseif ($filename == 'classes') {
                $slug = '/classes';
            } elseif ($filename == 'contact') {
                $slug = '/contact-us';
            } elseif ($filename == 'courses') {
                $slug = '/courses';
            } elseif ($filename == 'free') {
                $slug = 'free-course';
            } elseif ($filename == 'home') {
                $slug = '/';
            } elseif ($filename == 'instructors') {
                $slug = '/instructors';
            } elseif ($filename == 'quizzes') {
                $slug = '/quizzes';
            }


            $page = FrontPage::where('slug', $slug)->first();

            if ($page) {
                if ($page->slug == '/blogs') {
                    $page->slug = '/blog';
                    $page->name = 'Blog';
                    $page->title = 'Blog';
                }
                $page->details = '<div class="row"> <div class="col-sm-12 ui-resizable" data-type="container-content">' . $banner . $content . '</div></div>';
                $page->save();
            }

        }

        $dynamic_pages = FrontPage::where('is_static', 0)->get();
        $search = '<div class="row"><div class="col-sm-12 ui-resizable" data-type="container-content"><div data-type="component-text" data-aoraeditor-title="Text block" data-aoraeditor-categories="Text">';
        foreach ($dynamic_pages as $page) {
            if (!str_starts_with($page->details, $search)) {
                $page->details = $search . $page->details . '</div></div></div>';
            }
            $page->save();
        }
    }

    public function down()
    {
        //
    }

    private function homeContents()
    {
        return HomeContent::select(['key', 'value'])->get()->pluck('value', 'key');
    }

    private function addBanner($page)
    {
        try {
            $frontendContent = $this->homeContents();
            if ($page == "about-us") {
                $data['banner'] = $frontendContent['about_page_banner'];
                $data['title'] = $frontendContent['about_page_title'];
                $data['sub_title'] = 'sub title';
            } elseif ($page == "become-instructor") {
                $data['banner'] = $frontendContent['become_instructor_page_banner'];
                $data['title'] = $frontendContent['become_instructor_page_title'];
                $data['sub_title'] = $frontendContent['become_instructor_page_sub_title'];
            } elseif ($page == "blogs") {
                $data['banner'] = $frontendContent['blog_page_banner'];
                $data['title'] = $frontendContent['blog_page_title'];
                $data['sub_title'] = $frontendContent['blog_page_sub_title'];
            } elseif ($page == "blogs") {
                $data['banner'] = $frontendContent['blog_page_banner'];
                $data['title'] = $frontendContent['blog_page_title'];
                $data['sub_title'] = $frontendContent['blog_page_sub_title'];
            } elseif ($page == "classes") {
                $data['banner'] = $frontendContent['class_page_banner'];
                $data['title'] = $frontendContent['class_page_title'];
                $data['sub_title'] = $frontendContent['class_page_sub_title'];
            } elseif ($page == "courses") {
                $data['banner'] = $frontendContent['course_page_banner'];
                $data['title'] = $frontendContent['course_page_title'];
                $data['sub_title'] = $frontendContent['course_page_sub_title'];
            } elseif ($page == "quizzes") {
                $data['banner'] = $frontendContent['quiz_page_banner'];
                $data['title'] = $frontendContent['quiz_page_title'];
                $data['sub_title'] = $frontendContent['quiz_page_sub_title'];
            } elseif ($page == "free") {
                $data['banner'] = $frontendContent['course_page_banner'];
                $data['title'] = $frontendContent['course_page_title'];
                $data['sub_title'] = $frontendContent['course_page_sub_title'];
            } elseif ($page == "instructors") {
                $data['banner'] = $frontendContent['instructor_page_banner'];
                $data['title'] = $frontendContent['instructor_page_title'];
                $data['sub_title'] = $frontendContent['instructor_page_sub_title'];
            } elseif ($page == "contact") {
                $data['banner'] = $frontendContent['contact_page_banner'];
                $data['title'] = $frontendContent['contact_page_title'];
                $data['sub_title'] = $frontendContent['contact_sub_title'];
            } else {
                return '';
            }

            $content = \response()->view('frontend.infixlmstheme.components.breadcrumb', $data)->content();
            $content = '<div data-type="component-text">' . $content . '</div>';
        } catch (\Exception $exception) {
            $content = '';
        }
        return $content;
    }

}
