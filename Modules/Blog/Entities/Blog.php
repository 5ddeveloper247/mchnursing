<?php

namespace Modules\Blog\Entities;

use App\User;
use App\Traits\Tenantable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Modules\Org\Entities\OrgBlogBranch;
use Modules\Org\Entities\OrgBlogPosition;
use Spatie\Translatable\HasTranslations;

class Blog extends Model
{

    use Tenantable;

    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at', 'authored_date_time'];

    use HasTranslations;

    public $translatable = ['title', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class)->withDefault();
    }


    public function comments()
    {
        return $this->hasMany(BlogComment::class)->where('type', 1)->orderByDesc('id');
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->updateingDateTime($model);
        });
        self::updating(function ($model) {
            $model->updateingDateTime($model);
        });
        self::created(function ($model) {
            saasPlanManagement('blog_post', 'create');
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('BlogPosList_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('BlogPosList_');
            }
        });
        self::deleted(function ($model) {
            saasPlanManagement('blog_post', 'delete');
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('BlogPosList_');
            }
        });
    }

    public function branches()
    {
        return $this->hasMany(OrgBlogBranch::class, 'blog_id');
    }

    public function positions()
    {
        return $this->hasMany(OrgBlogPosition::class, 'blog_id');
    }

    public function updateingDateTime($model): void
    {

        try {
            $dateTime = Carbon::parse($model->authored_date . ' ' . $model->authored_time);
        } catch (\Exception $exception) {
            $dateTime = null;
        }

        $model->authored_date_time = $dateTime;
    }

    public function userRead()
    {
        return $this->hasOne(UserBlog::class, 'blog_id')->where('user_id', Auth::id());
    }
}
