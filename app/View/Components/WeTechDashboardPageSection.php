<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Blog\Entities\Blog;
use Modules\CourseSetting\Entities\Course;
use Modules\FrontendManage\Entities\Slider;
use Modules\Org\Entities\OrgRecentActivity;

class WeTechDashboardPageSection extends Component
{


    public function render()
    {
        $sliders = Slider::where('status', 1)->get();
        $query = Blog::where('status', 1);

        if (isModuleActive('Org')) {
            $query->where(function ($q) {
                $q->where('audience', 1)
                    ->orWhere(function ($q) {
                        $q->where('audience', 2);
                        if (Auth::check()) {
                            if (Auth::user()->role_id != 1) {
                                $q->whereHas('branches', function ($q) {
                                    $q->whereIn('branch_id', getAllChildCodeIds(Auth::user()->branch, [Auth::user()->branch->id]));
                                });
                            }
                        } else {
                            $q->whereHas('branches', function ($q) {
                                $q->where('branch_id', 0);
                            });
                        }
                    });
            });

            $query->where(function ($q) {
                $q->where('position_audience', 1)
                    ->orWhere(function ($q) {
                        $q->where('position_audience', 2);
                        if (Auth::check()) {
                            if (Auth::user()->role_id != 1) {
                                $q->whereHas('positions', function ($q) {
                                    $q->whereIn('position_id', getAllChildCodeIds(Auth::user()->position, [Auth::user()->position->id]));
                                });
                            }
                        } else {
                            $q->whereHas('positions', function ($q) {
                                $q->where('position_id', 0);
                            });
                        }
                    });
            });
        }
        $blogs = $query->limit(3)->latest()->get();
        $activities = OrgRecentActivity::with('user', 'course', 'user.position')->whereHas('user')->latest()->get();
        $open_courses = Course::where('required_type', 0)
            ->orderBy('updated_at', 'desc')
            ->where('status', 1)
            ->where('type', 1)
            ->get();
        return view(theme('components.we-tech-dashboard-page-section'), compact('sliders', 'blogs', 'activities', 'open_courses'));
    }
}
