<?php


namespace Modules\StudentSetting\Entities;

use App\User;
use App\LessonComplete;
use Illuminate\Database\Eloquent\Model;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Lesson;
use Modules\Payment\Entities\PaymentPlans;

class Program extends Model
{

    protected $table = 'programs';
    protected $fillable = ['programtitle', 'subtitle', 'totalcost', 'discount_price', 'duration', 'requirement', 'discription','outcome','numberofcourses','allcourses','faqs','payment_plan','total_enrolled','user_id','image','icon','status','lms_id'];
    protected $appends = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault([
            'name' => ' '
        ]);
    }
    public function programPlans()
    {
        return $this->hasMany(PaymentPlans::class,'parent_id','id')->where('type','program')->where('status',1);
    }
    public function currentProgramPlan()
    {
        return $this->programPlans()->where(function ($q){
                $q->where('sdate','<', date('Y-m-d'))->where('edate','>', date('Y-m-d'));
        });
    }
    public function enrollUsers()
    {
        return $this->belongsToMany(User::class, 'course_enrolleds', 'program_id', 'user_id')->wherePivot('plan_id', $this->currentProgramPlan[0]->id);
    }
    public function getAllCoursesDataAttribute()
    {
        return Course::whereIn('id',json_decode($this->allcourses))->where('scope', 1)->get();
    }

    public function getIsLoginUserEnrolledAttribute()
    {

        if (\auth()->user()->role_id == 1) {
            return true;
        }
//        if (isModuleActive('MyClass') && auth()->user()->role_id == 2) {
//            if ($this->hasEnrollForClass()) {
//                return true;
//            }
//        }
//        if (isModuleActive('CPD') && auth()->user()->role_id == 2) {
//            if ($this->hasEnrollForCPd()) {
//                return true;
//            }
//        }
        if (\auth()->user()->role_id == 2) {
            if ($this->user_id == \auth()->user()->id) {
                return true;
            } else {
                return false;
            }
        }
        if (auth()->user()->role_id == 4 || auth()->user()->role_id > 5) {
            if (Settings('staff_can_view_course') == 'yes') {
                return true;
            }
        }
        if (!$this->enrollUsers->where('id', \auth()->user()->id)->count()) {
            return false;
        } else {
            return true;
        }
    }

    public function userTotalPercentage($user_id, $program_id)
    {
        $course_id = json_decode(Program::find($program_id)->allcourses);
        $complete_lesson = LessonComplete::where('user_id', $user_id)->whereIn('course_id', $course_id)->where('status', 1)->get();

        $countCourse = count($complete_lesson);
        if ($countCourse != 0) {
            $percentage = ceil($countCourse / Lesson::whereIn('course_id', $course_id)->count() * 100);
        } else {
            $percentage = 0;
        }
        if ($percentage > 100) {
            $percentage = 100;
        }
        return $percentage;
    }

}
