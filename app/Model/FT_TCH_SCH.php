<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class FT_TCH_SCH extends Model
{
     protected $table ='FT_TCH_SCH';
     public $timestamps = false;
     protected $fillable =[
     	            'AD_YEAR',
                  'PUB_OR_PRI',
                  'SCH_CTG',
                  'SCH_CODE',
                  'SCH_NAME',
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
                  'FT_ASTPFS_UP',
                  'FT_ASTPFS_UP_MALE',
                  'FT_ASTPFS_UP_FEMALE',
                  'FT_LT_UP',
                  'FT_LT_UP_MALE',
                  'FT_LT_UP_FEMALE'

     ];
       public static function Export()
    {
    $records = DB::table('FT_TCH_SCH')
                    ->get()
                    ->toarray();
   
    }
}
