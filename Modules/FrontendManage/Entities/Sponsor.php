<?php

namespace Modules\FrontendManage\Entities;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Sponsor extends Model
{
    use Tenantable;
    use HasTranslations;

    public $translatable = ['title'];

    protected $fillable = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('SponsorList_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('SponsorList_');
            }
        });
        self::deleted(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('SponsorList_');
            }
        });
    }
}
