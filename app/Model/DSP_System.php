<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class DSP_System extends Model
{
    //
     protected $table ='DSP_System';
     public $timestamps = false;
     protected $fillable =['AD_YEAR',
                           'SYSTEM_TYPE',
                           'COL',
                           'DEP_CODE',
                           'DEP_NAME',
                           'DEP_SIMPLE',
                           'SCH_SYS',
                           'DEP_COLOR',
                           'COL_COLOR',
                           'COL_ICON',
                           'DEP_ICON',
                           'ST_NUM',
                           'SS_NUM',
                           'COL_NUM'
                           ];
  public static function Export()
    {
    $records = DB::table('DSP_System')
                    ->get()
                    ->toarray();
   
    }
}
