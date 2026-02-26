<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class DP_SCH extends Model
{
    //
     protected $table ='DP_SCH';
     public $timestamps = false;
     protected $fillable=[
     	'AD_YEAR',
        'SMST',
        'PUB_OR_PRI',
        'SCH_CTG',
        'SCH_CODE',
        'SCH_NAME',
        'SCH_SYS',
        'GENDER',
        'STU_SUM',
        'DP_SUM',
        'DP_SCORE',
        'DP_CONDUCT',
        'DP_INTERESTS',
        'DP_OVEFDUE',
        'DP_NORETURN',
        'DP_PREGNANT',
        'DP_BABY',
        'DP_SICK',
        'DP_WORK',
        'DP_MONEY',
        'DP_PLAN',
        'DP_OTHER'
     ];



public static function Export(){
    $records = DB::table('DP_SCH')
                    ->get()
                    ->toarray();
   
    }
}
