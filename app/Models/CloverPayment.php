<?php

namespace App\Models;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class CloverPayment extends Model
{
    use Tenantable;
    protected $table = 'clover_payments';
}
