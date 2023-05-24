<?php

namespace Modules\FrontendManage\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Translatable\HasTranslations;

class WorkProcess extends Model
{
    use Tenantable;

    protected $guarded = [];

    use HasTranslations;

    public $translatable = ['title', 'description'];
}
