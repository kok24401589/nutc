<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class EnrollmentAnalysis extends Model
{
    //
         protected $table ='進入本校學生入學管道';
     public $timestamps = false;
     protected $fillable=[
'學制',
'科系',
'年級',
'目前班級',
'入學前學校所在城市',
'入學前學歷',
'入學前學校',
'入學前學校科組',
'入學方式',
'在學狀態',
'入學日期',
'入學學年期',
'入學其他分類'

     ];



public static function Export(){
    $records = DB::table('進入本校學生入學管道')
                    ->get()
                    ->toarray();
   
    }
}
