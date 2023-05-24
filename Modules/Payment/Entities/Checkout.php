<?php

namespace Modules\Payment\Entities;

use App\User;
use Carbon\Carbon;
use App\BillingDetails;
use App\Traits\Tenantable;
use Modules\Coupons\Entities\Coupon;
use Illuminate\Database\Eloquent\Model;
use Modules\CourseSetting\Entities\Package;
use Modules\SystemSetting\Entities\TutorHiring;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Modules\CourseSetting\Entities\CourseEnrolled;

class Checkout extends Model
{

use Tenantable;

    protected $fillable = ['status'];

    protected $appends = ['dateFormat'];


    public function coupon()
    {

        return $this->belongsTo(Coupon::class, 'coupon_id')->withDefault();
    }
    public function studentIstallment()
    {

        return $this->belongsTo(StudentProgramPaymentPlans::class, 'installment_id')->withDefault();
    }
    public function package()
    {

        return $this->belongsTo(Package::class, 'package_id')->withDefault();
    }

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function getdateFormatAttribute()
    {
        return Carbon::parse($this->created_at)->isoformat('Do MMMM Y');
    }

    public function courses()
    {
        return $this->hasMany(CourseEnrolled::class, 'tracking', 'tracking');
    }
    public function tutorHirings()
    {
        return $this->hasMany(TutorHiring::class, 'tracking_id', 'tracking');
    }


    public function bill()
    {
        return $this->belongsTo(BillingDetails::class, 'tracking', 'tracking_id')->withDefault();

    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'tracking', 'tracking');
    }

    public function billing()
    {
        return $this->belongsTo(BillingDetails::class,'billing_detail_id');
    }
}
