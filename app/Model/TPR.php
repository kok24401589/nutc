<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class TPR extends Model
{
    //
         protected $table ='生師比_校';
     public $timestamps = false;
     protected $fillable =[
'學年度',
'設立別',
'學校類別',
'學校統計處代碼',
'學校名稱',
'日間學制學生數',
'日間專任教師',
'日間生師比'


     ];
       public static function Export()
    {
    $records = DB::table('生師比_校')
                    ->get()
                    ->toarray();
   
    }
}
