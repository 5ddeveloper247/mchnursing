<?php

namespace Modules\SystemSetting\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class TutorSlote extends Model
{


    protected $table = 'tutor_slotes';
    protected $guarded = [];

    public function slotHiring(): HasMany
    {
        return $this->hasMany(TutorHiring::class, 'tutor_slote_id', 'id');
    }
}
