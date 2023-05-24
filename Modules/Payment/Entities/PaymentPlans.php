<?php

namespace Modules\Payment\Entities;

use App\Traits\Tenantable;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\StudentSetting\Entities\Program;

class PaymentPlans extends Model
{
    use Tenantable;
    protected $fillable = ['amount','planed_amount','parent_id','type','status'];
    protected $table = 'payment_plans';

// relation
    public function programName()
    {
        return $this->hasOne(Program::class,'id','parent_id')->select(['id','programtitle','totalcost']);
    }
    public function programPalnDetail()
    {
        return $this->hasMany(PaymentPlanDetails::class,'payment_plan_id','id')->orderby('type');
    }
    public function initialProgramPalnDetail()
    {
        return $this->programPalnDetail()->where('type','0');
    }

    public function getIsProgramPlanViseEnrollAttribute()
    {
        return CourseEnrolled::where('user_id', Auth::id())->where('program_id', $this->parent_id)->where('plan_id', $this->id)->exists();

    }
    public function getProgramPlanViseEnrollCountAttribute()
    {
        return CourseEnrolled::where('program_id', $this->parent_id)->where('plan_id', $this->id)->count();
    }
//    functions

    public function getMatchingTenureForProgramPlan($parent_id,$id,$start_date,$end_date)
    {

        return self::where('type','program')
            ->where('id','!=',$id)
            ->where('parent_id',$parent_id)
            ->where(function ($q) use($start_date,$end_date){
                $q->whereBetween('sdate', [$start_date,$end_date])
                    ->orWhereBetween('edate',[$start_date,$end_date])
                    ->orWhere(function ($q) use($start_date,$end_date){
                        $q->where('sdate','<=', $start_date)->where('edate','>=', $end_date);
                    });
            })
            ->get();
    }

}
