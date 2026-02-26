<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PT_TCH_DEP extends Model
{
         protected $table ='PT_TCH_DEP';
     public $timestamps = false;
     protected $fillable =[
     	         'AD_YEAR',
                 'PUB_OR_PRI',
                 'SCH_CTG',
                 'SCH_CODE',
                 'SCH_NAME',
                 'UNIT_CODE',
                 'DEP_NAME',
                 'TCH_SUM',
                 'TCH_MALE',
                 'TCH_FEMALE',
                 'PFS_MALE',
                 'PFS_FEMALE',
                 'ASCPFS_MALE',
                 'ASCPFS_FEMALE',
                 'ASTPFS_MALE',
                 'ASTPFS_FEMALE',
                 'LT_MALE',
                 'LT_FEMALE',
                 'OT_TCH_MALE',
                 'OT_TCH_FEMALE',
                 'PT_ASTPFS_UP',
                 'PT_ASTPFS_UP_MALE',
                 'PT_ASTPFS_UP_FEMALE',
                 'PT_LT_UP',
                 'PT_LT_UP_MALE',
                 'PT_LT_UP_FEMALE'

     ];
       public static function Export()
    {
    $records = DB::table('PT_TCH_DEP')
                    ->get()
                    ->toarray();
   
    }

}
