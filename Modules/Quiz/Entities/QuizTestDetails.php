<?php

namespace Modules\Quiz\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class QuizTestDetails extends Model
{
    use Tenantable;
    protected $guarded = ['id'];

    public function answers()
    {
        return $this->hasMany(QuizTestDetailsAnswer::class, 'quiz_test_details_id');
    }
}
