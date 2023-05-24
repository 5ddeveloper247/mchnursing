<?php


namespace Modules\StudentSetting\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;


class TutorReveiws extends Model
{

    protected $table = 'tutor_reveiws';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select('id', 'role_id', 'name','image')->withDefault();
    }

}
