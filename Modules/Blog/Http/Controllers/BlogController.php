<?php

namespace Modules\Blog\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Entities\BlogCategory;
use Modules\Org\Entities\OrgBlogBranch;
use Modules\Org\Entities\OrgBlogPosition;
use Modules\Org\Entities\OrgBranch;


class BlogController extends Controller
{
    use ImageStore;

    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $query = Blog::with('user');
            if ($user->role_id == 2) {
                $query->where('user_id', $user->id);
            } else {
                if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                    $query->whereHas('user', function ($q) {
                        $q->where('organization_id', Auth::id());
                        $q->orWhere('user_id', Auth::id());
                    });
                }
            }
            if ($request->category) {
                $query->where('category_id', $request->category);
            }
            $blogs = $query->latest()->get();
            $query2 = BlogCategory::with('user');
            if ($user->role_id == 2) {
                $query2->where('user_id', $user->id);
            }
            $categories = $query2->where('status', 1)->orderBy('position_order', 'asc')->get();
            return view('blog::index', compact('blogs', 'categories'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function create()
    {
        $user = Auth::user();
        $query2 = BlogCategory::with('user');
        if ($user->role_id == 2) {
            $query2->where('user_id', $user->id);
        }
        $categories = $query2->where('status', 1)->orderBy('position_order')->get();
        $data = [];
        if (isModuleActive('Org')) {
            $data['codes'] = [];
            $data['position_ids'] = [];
        }
        return view('blog::create', $data, compact('categories'));
    }

    public function store(Request $request)
    {
        if (saasPlanCheck('blog_post')) {
            Toastr::error('You have reached blog post limit', trans('common.Failed'));
            return redirect()->back();
        }
        if (demoCheck()) {
            return redirect()->back();
        }


        $rules = [
            'title' => 'required',
            'category' => 'required',
            'slug' => ['required', Rule::unique('blogs', 'slug')->when(isModuleActive('LmsSaas'), function ($q) {
                return $q->where('lms_id', app('institute')->id);
            })]
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {
            $blog = new Blog;
            foreach ($request->title as $key => $name) {
                $blog->setTranslation('title', $key, $name);
            }
            foreach ($request->description as $key => $description) {
                $blog->setTranslation('description', $key, $description);
            }
            $blog->slug = $request->slug;
            $blog->category_id = $request->category;
            $blog->tags = $request->tags;
            $blog->user_id = Auth::id();


            $blog->authored_date = !empty($request->publish_date) ? getPhpDateFormat($request->publish_date) : date('m/d/y');
            $blog->authored_time = !empty($request->publish_time) ? $request->publish_time : date('H:i:s');

            if ($request->image) {
                $blog->image = $this->saveImage($request->image);
                $blog->thumbnail = $this->saveImage($request->image);
            }
            $blog->save();

            checkGamification('each_blog_post', 'blogs');

            if (isModuleActive('Org')) {
                $blog->audience = $request->audience;
                $blog->position_audience = $request->position_audience;
                $blog->save();
                $this->saveOrgBlogBranch($blog, $request->branch);
                $this->saveOrgBlogPosition($blog, $request->position);

            }
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('blogs.index');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }


    public function edit($id)
    {
        $user = Auth::user();

        $query2 = BlogCategory::with('user');
        if ($user->role_id == 2) {
            $query2->where('user_id', $user->id);
        }
        $categories = $query2->where('status', 1)->orderBy('position_order')->get();
        $blog = Blog::findOrFail($id);
        $data = [];
        if (isModuleActive('Org')) {
            $branches = OrgBranch::orderBy('order', 'asc')->with('assignBranchInGroupPolicy');
            $org_policy_branch = OrgBlogBranch::where('blog_id', $blog->id)->pluck('branch_id')->toArray();
            $data['codes'] = $branches->whereIn('id', $org_policy_branch)->pluck('code')->toArray();
            $data['position_ids'] = OrgBlogPosition::where('blog_id', $blog->id)->pluck('position_id')->toArray();
        }

        return view('blog::edit', $data, compact('blog', 'categories'));
    }

    public function update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'title' => 'required',
            'id' => 'required',
            'category' => 'required',
            'slug' => ['required', Rule::unique('blogs', 'slug')->ignore($request->slug, 'slug')->when(isModuleActive('LmsSaas'), function ($q, $request) {
                return $q->where('lms_id', app('institute')->id)->where('id', '!=', $request->id);
            })],
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {


            $blog = Blog::find($request->id);
            foreach ($request->title as $key => $name) {
                $blog->setTranslation('title', $key, $name);
            }
            foreach ($request->description as $key => $description) {
                $blog->setTranslation('description', $key, $description);
            }
            $blog->slug = $request->slug;
            $blog->user_id = Auth::id();
            $blog->authored_date = !empty($request->publish_date) ? getPhpDateFormat($request->publish_date) : date('m/d/y');
            $blog->authored_time = !empty($request->publish_time) ? $request->publish_time : date('H:i:s');


            $blog->tags = $request->tags;
            $blog->category_id = $request->category;
            if ($request->image) {
                $blog->image = $this->saveImage($request->image);
                $blog->thumbnail = $this->saveImage($request->image);
            }
            $blog->save();
            if (isModuleActive('Org')) {
                OrgBlogBranch::where('blog_id', $blog->id)->delete();
                OrgBlogPosition::where('blog_id', $blog->id)->delete();

                $blog->audience = $request->audience;
                $blog->position_audience = $request->position_audience;
                $blog->save();
                $this->saveOrgBlogBranch($blog, $request->branch);
                $this->saveOrgBlogPosition($blog, $request->position);
            }

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('blogs.index');

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    public function saveOrgBlogBranch($blog, $branches): void
    {
        if ($blog->audience != 1) {
            if (!empty($branches)) {
                foreach ($branches as $key => $branch) {
                    if ($branch == 1) {
                        $branch = new OrgBlogBranch();
                        $branch->blog_id = $blog->id;
                        $branch->branch_id = $key;
                        $branch->save();
                    }
                }
            }
        }
    }

    public function saveOrgBlogPosition($blog, $positions): void
    {
        if ($blog->position_audience != 1) {
            if (!empty($positions)) {
                foreach ($positions as $key => $position) {
                    if ($position == 1) {
                        $branch = new OrgBlogPosition();
                        $branch->blog_id = $blog->id;
                        $branch->position_id = $key;
                        $branch->save();
                    }
                }
            }
        }
    }


    public function destroy(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'id' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $blog = Blog::findOrFail($request->id);

            if (isModuleActive('Org')) {
                OrgBlogBranch::where('blog_id', $blog->id)->delete();
            }
            $blog->delete();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }
}
