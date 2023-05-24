<?php

namespace App\Models;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class UserAuthorzIationAgreement extends Model
{
    use Tenantable;
    protected $table = 'user_authorzIation_agreement';
}
