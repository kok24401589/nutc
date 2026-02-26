<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class Group_Pred extends Model
{
    //
         protected $table ='group_predictions';
     public $timestamps = false;
     protected $fillable=[
                'group_id',
                'group_name',
                'year',
                'predicted_count',
                'model_version',


     ];



public static function Export(){
    $records = DB::table('group_predictions')
                    ->get()
                    ->toarray();
   
    }
}
