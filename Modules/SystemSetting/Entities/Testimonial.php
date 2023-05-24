<?php

namespace Modules\SystemSetting\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Testimonial extends Model
{
    use Tenantable;

    protected $fillable = [];

    use HasTranslations;

    public $translatable = ['body', 'author', 'profession'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('TestimonialList_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('TestimonialList_');
            }
        });
        self::deleted(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('TestimonialList_');
            }
        });
    }

}
