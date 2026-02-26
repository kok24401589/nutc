<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class Teacher_System extends Model
{
    //
     protected $table ='Teacher_System';
     public $timestamps = false;
     protected $fillable =[
     	'AD_YEAR',
     	'department_code',
     	'department'


     ];
       public static function Export()
    {
    $records = DB::table('Teacher_System')
                    ->get()
                    ->toarray();
   
    }
}
