<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class student_department_controller extends Controller
{

    public function student(){
        //educational 學制
        $educational = request()->input("value");
        //$schoolname 學校名稱
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
        // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
        //$nowyear 資料庫最新資料年
        $year= request()->input("year");
        if(is_null($year)){
        $nowyear = DB::Table('STU_DEP')
                     ->where('SCH_NAME','=',$schoolname)
                     ->max("AD_YEAR");
        }else{
          $nowyear=$year;
        }

        
        //$educational ='學士班(日間)';
        if ($educational == "總人數"){
            $NUM = DB::select(DB::raw("SET NOCOUNT ON;
                                       EXEC dbo.StudentDepartmentAll $nowyear,
                                                                    '$schoolname'
                                      ")); 
        }elseif($educational == "五專"){
            $NUM = DB::select(DB::raw("SET NOCOUNT ON;
                                       EXEC dbo.StudentDepartmentFive $nowyear,
                                                                     '$educational',
                                                                     '$schoolname'
                                      ")); 
        }else{
            $NUM = DB::select(DB::raw("SET NOCOUNT ON;
                                       EXEC dbo.StudentDepartment $nowyear,
                                                                 '$educational',
                                                                 '$schoolname'
                                     ")); 
        }
        
        //dd($NUM);
        return view("student.student_department",compact('educational','NUM','nowyear'));
    }
    public function suspension(){
        //educational 學制
        $educational = request()->input("value");
        //$schoolname 學校名稱
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
        // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
        //$nowyear 資料庫最新資料年
        $year= request()->input("year");
        if(is_null($year)){
        $nowyear = DB::Table('SP_DEP_NEW')
                     ->where('SCH_NAME','=',$schoolname)
                     ->max("AD_YEAR");
        }else{
          $nowyear=$year;
        }

        //$educational ='學士班(日間)';
        
        if ($educational == "總人數"){
            $NUM = DB::select(DB::raw("SET NOCOUNT ON;
                                       EXEC dbo.StudentDepartmentSuspensionAll $nowyear,
                                                                              '$schoolname'
                                      "));
        }else{
            $NUM = DB::select(DB::raw("SET NOCOUNT ON;
                                       EXEC dbo.StudentDepartmentSuspension $nowyear,
                                                                           '$educational',
                                                                           '$schoolname'
                                      "));
        }
        //dd($NUM);
        return view("student.s_suspension_department",compact('educational','NUM','nowyear'));
    }
    public function dropout(){
        //educational 學制
        $educational = request()->input("value");
        //$schoolname 學校名稱
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
      // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
        //$nowyear 資料庫最新資料年
        $year= request()->input("year");
        
        if(is_null($year)){
        $nowyear = DB::Table('DP_DEP_NEW')
                     ->where('SCH_NAME','=',$schoolname)
                     ->max("AD_YEAR");
        }else{
          $nowyear=$year;
        }
        // $nowyear = 106;
        //$educational ='學士班(日間)';
        if ($educational == "總人數"){
            $NUM = DB::select(DB::raw("SET NOCOUNT ON;
                                       EXEC dbo.StudentDepartmentDropoutAll $nowyear,
                                                                           '$schoolname'
                                      "));
        }else{
            $NUM = DB::select(DB::raw("SET NOCOUNT ON;
                                       EXEC dbo.StudentDepartmentDropout $nowyear,
                                                                        '$educational',
                                                                        '$schoolname'
                                      "));
        }
        //dd($NUM);
return view("student.s_dropout_department",compact('educational','NUM','nowyear'));
    }
}
