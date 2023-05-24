<?php

namespace Modules\CourseSetting\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;


class TimeTableList extends Model
{
    protected $table = 'time_table_lists';

    public function getWeekWiseDaysAttribute(){
       return self::where('week',$this->week)->where('time_table_id',$this->time_table_id)->with('instructor')->orderBy('day')->get();
    }

    public function instructor(){
        return $this->belongsTo(User::class,'Instructor_id','id');
    }
}
