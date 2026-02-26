<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;
class Link_controller extends Controller
{
    //
    public function link(){
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];	
     $link_student = DB::Table('STU_SCH')
                    ->where('SCH_NAME','=',$schoolname)
                    ->max("AD_YEAR");
      $link_s_suspension = DB::Table('SP_SCH_NEW')
                     ->where('SCH_NAME','=',$schoolname) 
                     ->max("AD_YEAR");
      $link_s_dropout= DB::Table('DP_SCH')
                     ->where('SCH_NAME','=',$schoolname)
                     ->max("AD_YEAR");
      $link_teacher = DB::Table('FT_TCH_SCH')
                    ->where('SCH_NAME','=',$schoolname)
                    ->max("AD_YEAR");
      $link_teacherHour=DB::Table('FT_TCH_HOURS_ONSCH')
                        ->where('SCH_NAME','=',$schoolname)
                        ->max("AD_YEAR");
      $link_tpr =DB::Table('生師比_校')
                 ->where('學校名稱','=',$schoolname)
                 ->max("學年度");
      $link_EnrollmentAnalysis =DB::Table('進入本校學生入學管道')
                 ->max("入學學年期");
      $link_treemap=DB::Table('入學前地區')
                 ->max("入學學年期");
     return response()->json(['link_student' => $link_student,
     						  'link_s_suspension'=>$link_s_suspension,
     						  'link_s_dropout'=>$link_s_dropout,
     						  'link_teacher'=>$link_teacher,
     						  'link_teacherHour'=>$link_teacherHour,
     						  'link_tpr'=>$link_tpr,
     						  'link_EnrollmentAnalysis'=>$link_EnrollmentAnalysis,
     						  'link_treemap'=>$link_treemap

    						  ],Response::HTTP_OK);   	
    }


}
