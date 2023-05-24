<?php

namespace Modules\Payment\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class PaymentPlanDetails extends Model
{
    use Tenantable;
    protected $fillable = ['amount','sdate','edate','type','payment_plan_id'];
    protected $table = 'payment_plan_details';



    //    functions

    public function getMatchingTenureForPlanDetial($id,$payment_plan_id,$start_date,$end_date)
    {

        return self::where('payment_plan_id',$payment_plan_id)
            ->where('id','!=',$id)
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
