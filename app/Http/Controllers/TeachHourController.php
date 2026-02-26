<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
class TeachHourController extends Controller
{
    function school(){
      $year = request()->input("year");
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0]; 
      // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
      if(is_null($year)){
      $nowyear = DB::Table('FT_TCH_HOURS_ONSCH')
                 ->where('SCH_NAME','=',$schoolname)
                 ->max("AD_YEAR");}
      else{
             $nowyear=$year;
                   }

    //教授授課時數校
      $PROF_hour = DB::table("FT_TCH_HOURS_ONSCH")
                  ->SELECT(DB::raw("row_number()OVER(ORDER BY AVG_TEACH_PROF DESC) as RANK"),
                           "SCH_NAME",
                           "AVG_TEACH_PROF")
                  ->where('AD_YEAR','=',$nowyear)
                  ->orderby('AVG_TEACH_PROF','DESC')
                  ->get();
      // dd($PROF_hour);
    //副教授授課時數校
      $ASCPROF_hour = DB::table("FT_TCH_HOURS_ONSCH")
                  ->SELECT(DB::raw("row_number()OVER(ORDER BY AVG_TEACH_ASCPROF DESC) as RANK"),
                           "SCH_NAME",
                           "AVG_TEACH_ASCPROF")
                  ->where('AD_YEAR','=',$nowyear)
                  ->orderby('AVG_TEACH_ASCPROF','DESC')
                  ->get();
    //助理教授授課時數校
      $ASTPROF_hour = DB::table("FT_TCH_HOURS_ONSCH")
                  ->SELECT(DB::raw("row_number()OVER(ORDER BY AVG_TEACH_ASTPROF DESC) as RANK"),
                           "SCH_NAME",
                           "AVG_TEACH_ASTPROF")
                  ->where('AD_YEAR','=',$nowyear)
                  ->orderby('AVG_TEACH_ASTPROF','DESC')
                  
                  ->get();
    //講師授課時數校
      $LT_hour = DB::table("FT_TCH_HOURS_ONSCH")
                  ->SELECT(DB::raw("row_number()OVER(ORDER BY AVG_TEACH_LT DESC) as RANK"),
                           "SCH_NAME",
                           "AVG_TEACH_LT")
                  ->where('AD_YEAR','=',$nowyear)
                  ->orderby('AVG_TEACH_LT','DESC')
                  
                  ->get();
    //其他講師授課時數校
      $OT_hour = DB::table("FT_TCH_HOURS_ONSCH")
                  ->SELECT(DB::raw("row_number()OVER(ORDER BY AVG_TEACH_OT DESC) as RANK"),
                           "SCH_NAME",
                           "AVG_TEACH_OT")
                  ->where('AD_YEAR','=',$nowyear)
                  ->orderby('AVG_TEACH_OT','DESC')
                  
                  ->get();
    	return view("teacher.TeachHour",
                   compact('PROF_hour',
                           'ASCPROF_hour',
                           'ASTPROF_hour',
                           'LT_hour',
                           'OT_hour',
                           'schoolname',
                            'nowyear'));
    }
}
