<?php

namespace Modules\CourseSetting\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Rennokki\QueryCache\Traits\QueryCacheable;

class CourseReveiw extends Model
{


    protected $guarded = ['id'];

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id', 'id')->select('id', 'role_id', 'name','image')->withDefault();
    }

    public function course()
    {

        $this->belongsTo(Course::class, 'course_id')->withDefault();
    }


}
