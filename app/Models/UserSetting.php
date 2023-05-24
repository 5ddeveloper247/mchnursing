<?php

namespace App\Models;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use Tenantable;
    protected $table = 'user_settings';
}
