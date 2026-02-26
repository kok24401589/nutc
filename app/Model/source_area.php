<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class source_area extends Model
{
     protected $table ='入學前地區';
     public $timestamps = false;
     protected $fillable =[
'學制',
'科系',
'入學前學校所在城市',
'入學前學歷',
'入學前學校',
'入學前學校科組',
'入學方式',
'入學學年期'


     ];




     public static function Export(){
    $records = DB::table('入學前地區')
                    ->get()
                    ->toarray();
   
    }
}
