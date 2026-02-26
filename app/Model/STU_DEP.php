<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class STU_DEP extends Model
{
     protected $table ='STU_DEP';
     public $timestamps = false;
     protected $fillable =['AD_YEAR',
                           'PUB_OR_PRI',
                           'SCH_CTG',
                           'SCH_CODE',
                           'SCH_NAME',
                           'DEP_CODE',
                           'DEP_NAME',
                           'SCH_SYS',
                           'STU_SUM',
                           'STU_MALE',
                           'STU_FEMALE'];
  public static function Export()
    {
    $records = DB::table('STU_DEP')
                    ->select('AD_YEAR',
                           'PUB_OR_PRI',
                           'SCH_CTG',
                           'SCH_CODE',
                           'SCH_NAME',
                           'DEP_CODE',
                           'DEP_NAME',
                           'SCH_SYS',
                           'STU_SUM',
                           'STU_MALE',
                           'STU_FEMALE')
                    ->get()
                    ->toarray();
   
    }
}
