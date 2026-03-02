<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class Department_GroupBaselines extends Model
{
    //
     protected $table ='department_group_baselines';
     public $timestamps = false;
     protected $fillable=[
                'group_id',
                'group_name',
                'year',
                'DEP_SIMPLE',
                'admission_type'
           


     ];



public static function Export(){
    $records = DB::table('department_group_baselines')
                    ->get()
                    ->toarray();
   
    }
}
