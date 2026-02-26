<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class SP_SCH extends Model
{
    //
     protected $table ='SP_SCH_NEW';
     public $timestamps = false;
     protected $fillable =['AD_YEAR',
                           'PUB_OR_PRI',
                           'SCH_CTG',
                           'SCH_CODE',
                           'SCH_NAME',
                           'SCH_SYS',
                           'GENDER',
                           'STU_SUM',
                           'SP_ED_SUM',
                           'SP_ED_SICK',
                           'SP_ED_MONEY',
                           'SP_ED_SCORE',
                           'SP_ED_INTERESTS',
                           'SP_ED_WORK',
                           'SP_ED_PREGNANT',
                           'SP_ED_BABY',
                           'SP_ED_MILITARY',
                           'SP_ED_TRAVEL',
                           'SP_ED_PAPER',
                           'SP_ED_MALADAPTIVE',
                           'SP_ED_FAMILY',
                           'SP_ED_EXAM',
                           'SP_ED_REGISTERED',
                           'SP_ED_OTHER'
                       ];
  public static function Export()
    {
    $records = DB::table('SP_SCH_NEW')
                    ->get()
                    ->toarray();
   
    }
}
