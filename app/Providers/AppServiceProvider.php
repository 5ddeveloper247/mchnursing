<?php

namespace App\Providers;

use App\AboutPage;
use App\OAuth\GoogleDriveProvider;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Chat\Entities\Status;
use Modules\FrontendManage\Entities\BecomeInstructor;
use Modules\FrontendManage\Entities\HomeContent;
use Modules\FrontendManage\Entities\WorkProcess;
use Modules\RolePermission\Entities\Permission;
use Modules\Setting\Entities\Badge;
use Modules\SidebarManager\Entities\PermissionSection;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Console\KeysCommand;
use Laravel\Passport\Console\ClientCommand;
use Laravel\Passport\Console\InstallCommand;
use Modules\CourseSetting\Entities\Category;
use Modules\FrontendManage\Entities\HeaderMenu;
use stdClass;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {

        if (isModuleActive('Chat')) {
            $this->app->singleton('general_settings', function () {
                return Valuestore::make((base_path() . '/general_settings.json'));
            });
        }
    }

    public function boot()
    {
        if (isModuleActive('LmsSaas') || isModuleActive('LmsSaasMD')) {
            $domain = SaasDomain();
        } else {
            $domain = 'main';
        }
        if (isModuleActive('LmsSaasMD')) {
            if (!Storage::has('saas_db.json')) {
                $path = Storage::path('saas_db.json');
                $data = \App\Models\LmsInstitute::get(['db_database', 'db_username', 'db_password', 'domain']);
                $content = [];
                foreach ($data as $row) {
                    $content[$row->domain] = [
                        "DB_DATABASE" => $row->domain == 'main' ? env('DB_DATABASE') : $row->db_database,
                        "DB_USERNAME" => $row->domain == 'main' ? env('DB_USERNAME') : $row->db_username,
                        "DB_PASSWORD" => $row->domain == 'main' ? env('DB_PASSWORD') : $row->db_password,
                    ];
                }
                file_put_contents($path, json_encode($content, JSON_PRETTY_PRINT));
            }
        }


        if (empty(SaasInstitute())) {
            redirect(env('APP_URL'))->send();
        }

        session()->put('domain', $domain);

        Paginator::useBootstrap();


        if (env('FORCE_HTTPS')) {
            URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);
        $this->commands([
            InstallCommand::class,
            ClientCommand::class,
            KeysCommand::class,
        ]);

        try {
            if (isModuleActive('Chat')) {
                $datatable = DB::connection()->getDatabaseName();
                if ($datatable) {
                    if (Schema::hasTable('chat_notifications')) {
                        view()->composer([
                            'backend.partials.menu',
                            theme('partials._dashboard_master'),
                            theme('partials._dashboard_menu'),
                            theme('pages.fullscreen_video'),
                        ], function ($view) {
                            $notifications = DB::table('chat_notifications')->where('notifiable_id', auth()->id())
                                ->where('read_at', null)
                                ->get();

                            foreach ($notifications as $notification) {
                                $notification->data = json_decode($notification->data);
                            }
                            $notifications = $notifications->sortByDesc('created_at');

                            $view->with(['notifications_for_chat' => $notifications]);
                        });
                    }

                    view()->composer('*', function ($view) {

                        $seed = session()->get('user_status_seedable');
                        if (isModuleActive('Chat') && auth()->check() && is_null($seed)) {
                            $users = User::all();
                            foreach ($users as $user) {
                                if (Schema::hasTable('chat_statuses')) {
                                    Status::firstOrCreate([
                                        'user_id' => $user->id,
                                    ], [
                                        'user_id' => $user->id,
                                        'status' => 0
                                    ]);
                                }

                            }

                            session()->put('user_status_seedable', 'false');
                        }
                    });

                    view()->composer('*', function ($view) {
                        if (auth()->check()) {
                            $this->app->singleton('extend_view', function ($app) {
                                if (auth()->user()->role_id == 3) {
                                    return theme('layouts.dashboard_master');
                                } else {
                                    return 'backend.master';
                                }
                            });
                        }
                    });

                }
            }

            if (Settings('frontend_active_theme')) {
                $this->app->singleton('topbarSetting', function () {
                    $topbarSetting = DB::table('topbar_settings')
                        ->first();
                    return $topbarSetting;
                });
            }

            View::composer(['backend.partials.sidebar'], function ($view) {

                $check = Permission::whereColumn('route', 'parent_route')->get();
                if (count($check) > 0) {
                    foreach ($check as $c) {
                        $c->parent_route = null;
                        $c->save();
                    }
                }
                if (Schema::hasTable('permission_sections')) {
                    $query = PermissionSection::query();
                    if (!showEcommerce()) {
                        $query->where('ecommerce', '!=', 1);
                    }
                    $data['sections'] = $query->with('permissions')->orderBy('position')->get();
                } else {
                    $data['sections'] = [];
                }
                $view->with($data);
            });

            View::composer([
                theme('partials._dashboard_menu'),
                theme('pages.fullscreen_video'),
                theme('pages.index'),
                theme('pages.courses'),
                theme('pages.free_courses'),
                theme('partials._menu'),
                theme('pages.quizzes'),
                theme('pages.classes'),
                theme('pages.search'),
                theme('components.we-tech-dashboard-page-section'),
                theme('layouts.dashboard_master'),
                theme('components.home-page-course-section')
            ], function ($view) use ($domain) {

                $data['categories'] = Cache::rememberForever('categories_' . app()->getLocale() . $domain, function () {
                    return Category::select('id', 'name', 'title', 'description', 'image', 'thumbnail', 'parent_id')
                        ->where('status', 1)
                        ->whereNull('parent_id')
                        ->withCount('courses')
                        ->orderBy('position_order', 'ASC')->with('activeSubcategories', 'childs', 'subcategories')
                        ->get();
                });


                $data['languages'] = Cache::rememberForever('languages_' . app()->getLocale() . $domain, function () {
                    if (isModuleActive('LmsSaasMD')) {
                        return DB::connection('mysql')->table('languages')->select('id', 'name', 'code', 'rtl', 'status', 'native')
                            ->where('status', 1)
                            ->get();
                    } else {
                        return DB::table('languages')->select('id', 'name', 'code', 'rtl', 'status', 'native')
                            ->where('status', 1)
                            ->where('lms_id', SaasInstitute()->id)
                            ->get();
                    }

                });
                $data['menus'] = Cache::rememberForever('menus_' . app()->getLocale() . $domain, function () {
                    try {
                        return HeaderMenu::orderBy('position', 'asc')
                            ->select('id', 'type', 'element_id', 'title', 'link', 'parent_id', 'position', 'show', 'is_newtab', 'mega_menu', 'mega_menu_column')
                            ->with('childs')
                            ->get();
                    } catch (\Exception $e) {
                        return collect();
                    }
                });
                $view->with($data);
            });
            View::composer([
                'frontend.*',
                'frontend.infixlmstheme.components.breadcrumb'
            ], function ($view) {
                $data['frontendContent'] = $data['homeContent'] = (object)$this->homeContents();
                $data['about_page'] = AboutPage::first();
                $data['become_instructor'] = BecomeInstructor::all();
                $data['work_progress'] = WorkProcess::select('title', 'description')->where('status', 1)->get();
                $view->with($data);
            });

            View::composer([
                'frontend.infixlmstheme.partials._sidebar',
                'backend.partials.sidebar'
            ], function ($view) {
//                $data = [];
//                if (Schema::hasTable('badges')) {
//                    $data['reg_badges'] = Badge::select('title', 'image', 'point')->where('type', 'registration')->where(function ($query) {
//                        $totalDay = 0;
//                        if (Auth::check()) {
//                            $created = new Carbon(Auth::user()->created_at);
//                            $now = Carbon::now();
//                            $totalDay = $now->diffInDays($created);
//                        }
//                        $query->where('point', '<=', $totalDay);
//                    })->orderBy('point', 'asc')->get();
//                }
//                $view->with($data);
            });
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
        $this->bootGoogleDriveSocialite();


    }

    private function bootGoogleDriveSocialite()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'google-drive',
            function ($app) use ($socialite) {
                $config = $app['config']['services.google-drive'];
                return $socialite->buildProvider(GoogleDriveProvider::class, $config);
            }
        );
    }


    private function homeContents()
    {
        if (function_exists('SaasDomain')) {
            $domain = SaasDomain();
        } else {
            $domain = 'main';
        }
        return Cache::rememberForever('homeContents_' . app()->getLocale() . $domain, function () {
            return HomeContent::select(['key', 'value'])->get()->pluck('value', 'key')->toArray();
        });
    }
}
