<?php

namespace Modules\CourseSetting\Entities;

use App\LessonComplete;
use App\User;
use Carbon\Carbon;
use App\BillingDetails;
use App\Traits\Tenantable;
use Illuminate\Support\Facades\Auth;
use Modules\OrgSubscription\Entities\OrgCourseSubscription;
use Modules\Payment\Entities\Checkout;
use Illuminate\Database\Eloquent\Model;
use Modules\Payment\Entities\PaymentPlans;
use Modules\Quiz\Entities\QuizTest;
use Modules\StudentSetting\Entities\Program;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Illuminate\Database\Eloquent\Relations;

class CourseEnrolled extends Model
{

    use Tenantable;

    protected $fillable = ['user_id', 'course_id', 'program_id', 'user_id', 'purchase_price'];

    protected $appends = ['enrolledDate'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id')->withDefault();
    }
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id')->withDefault();
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    /**
     * Get the user associated with the CourseEnrolled
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function plan()
    {
        return $this->belongsTo(PaymentPlans::class, 'plan_id', 'id');
    }

    public function getenrolledDateAttribute()
    {
        return Carbon::parse($this->created_at)->isoformat('Do MMMM Y H:ss a');
    }
    public function getCourseEnrolledCountAttribute()
    {
        return CourseEnrolled::where('course_id',$this->course_id)->where('course_type',$this->course_type)->count();
    }
    public function scopeEnrollStudent($query)
    {
        return $query->whereHas('course', function ($query) {
            $query->where('user_id', Auth::id());
        });
    }

    public function checkout()
    {
        return $this->belongsTo(Checkout::class, 'tracking', 'tracking')->withDefault();
    }

    public function bill()
    {
        return $this->belongsTo(BillingDetails::class, 'tracking', 'tracking_id')->withDefault();
    }

    public function completeLessons()
    {
        return $this->hasMany(LessonComplete::class, 'course_id', 'course_id')->where('user_id', $this->user_id)->orderBy('id');
    }

    public function getUserTotalPercentageAttribute()
    {
        $percentage = 0;
        if ($this->course->type == 1) {
            $countCourse = count($this->completeLessons->where('status', 1));
            if ($countCourse != 0) {
                $percentage = ceil($countCourse / count($this->course->lessons) * 100);
            } else {
                $percentage = 0;
            }
            if ($percentage > 100) {
                $percentage = 100;
            }
        } else {
            $givenQuiz = $this->quizCompletes;
            if (count($givenQuiz) != 0) {
                $percentage = 50;
                foreach ($givenQuiz as $q) {
                    if ($q->pass == 1) {
                        $percentage = 100;
                    }
                }
            }
        }

        return $percentage;
    }

    public function quizCompletes()
    {
        return $this->hasMany(QuizTest::class, 'course_id', 'course_id')->where('user_id', $this->user_id)->orderBy('id');
    }

    public function getUserCompleteDateAttribute()
    {
        if ($this->course->type == 1) {
            $date = $this->completeLessons[0]->created_at ?? "";
        } else {
            $date = $this->quizCompletes[0]->created_at ?? "";
        }
        return showDate($date);
    }

    public function orgSubscriptionPlan()
    {
        return $this->belongsTo(OrgCourseSubscription::class, 'org_subscription_plan_id')->withDefault();
    }
}
