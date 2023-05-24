<?php

namespace Modules\FrontendManage\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class HomePageFaq extends Model
{
    use Tenantable;
    use HasTranslations;

    public $translatable = ['question','answer'];
    protected $fillable = [];
}
