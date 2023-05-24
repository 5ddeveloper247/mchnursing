<?php

namespace Modules\FrontendManage\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BecomeInstructor extends Model
{
    use Tenantable;

    protected $fillable = [];

    use HasTranslations;

    public $translatable = ['section', 'title', 'description','btn_name'];
}
