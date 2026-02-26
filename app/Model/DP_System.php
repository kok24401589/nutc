<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class DP_System extends Model
{
    //
     protected $table ='DP_System';
     public $timestamps = false;
     protected $fillable =['AD_YEAR',
                           'DEP_CODE',
                           'DEP_NAME',
                           'SCH_SYS',
                           ];
}
