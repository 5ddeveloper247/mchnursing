<?php

namespace Modules\Payment\Entities;

use App\Traits\Tenantable;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Modules\StudentSetting\Entities\Program;

class StudentProgramPaymentPlans extends Model
{
    use Tenantable;
    protected $fillable = ['amount','sdate','edate','type','program_id','user_id'];
    protected $table = 'student_program_payment_plans';

    public function program()
    {

        return $this->belongsTo(Program::class, 'program_id')->withDefault();
    }
    public function plan()
    {
        return $this->belongsTo(PaymentPlans::class, 'plan_id')->withDefault();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
}
