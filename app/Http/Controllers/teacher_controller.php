<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
class teacher_controller extends Controller
{

    //教師校
     public function teacher(){
     $year = request()->input("year");
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
      // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
      //最新年度
      if(is_null($year)){
           $nowyear = DB::Table('FT_TCH_SCH')
                    ->where('SCH_NAME','=',$schoolname)
                    ->max("AD_YEAR");}
      else{
             $nowyear=$year;
                   }
//---------------------專任教師--------------------------------------
    	$FT_TCH_SCH = DB::table('FT_TCH_SCH')        
    	->where("FT_TCH_SCH.SCH_NAME",$schoolname)
    	->where("FT_TCH_SCH.AD_YEAR",$nowyear)
    	->select("TCH_SUM",
    			 "PFS_MALE","PFS_FEMALE",
				 "ASCPFS_MALE","ASCPFS_FEMALE",
				 "ASTPFS_MALE","ASTPFS_FEMALE",
				 "LT_MALE","LT_FEMALE",
				 "OT_TCH_MALE","OT_TCH_FEMALE"
				)->first();	
//--------------------------兼任教師----------------------------------
     $PT_TCH_SCH = DB::table('PT_TCH_SCH')           
        ->where("PT_TCH_SCH.SCH_NAME",$schoolname)
        ->where("PT_TCH_SCH.AD_YEAR",$nowyear)
        ->select("TCH_SUM",
                 "PFS_MALE","PFS_FEMALE",
                 "ASCPFS_MALE","ASCPFS_FEMALE",
                 "ASTPFS_MALE","ASTPFS_FEMALE",
                 "LT_MALE","LT_FEMALE",
                 "OT_TCH_MALE","OT_TCH_FEMALE"
                )->first(); 
//-----------------------------------------------------------------------
 $test=DB::table('STU_SCH')
            ->select(DB::raw("sum(STU_SUM) as PFS"))
            ->where('SCH_NAME','=',$schoolname)
            ->where("AD_YEAR",$nowyear)
            ->get()
            ;


     	return view("teacher.teacher",compact('FT_TCH_SCH','PT_TCH_SCH','test','nowyear'));
    }
//教師院-----------------------------------------------------------------------
     public function teacher_college(){
            $year = request()->input("year");
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
      // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
                    //最新年度
            if(is_null($year)){
           $nowyear = DB::Table('FT_TCH_DEP')
                    ->where('SCH_NAME','=',$schoolname)
                    ->max("AD_YEAR");}
        else{
             $nowyear=$year;
                   }
                   
      return view("teacher.teacher_college",compact('nowyear'));
    }
 //教師api
        public function teacher_college_api()
    {
        
        $ad_year = request()->input("ab");
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
      
        $PT= DB::table("PT_TCH_DEP")
          ->join("Teacher_System",
            "PT_TCH_DEP.UNIT_CODE","=","Teacher_System.department_code")
          ->where("SCH_NAME",$schoolname)
          ->where("PT_TCH_DEP.AD_YEAR",$ad_year)
          ->where("Teacher_System.AD_YEAR",$ad_year)
          ->select("college",
                   DB::raw("sum(PFS_MALE+PFS_FEMALE) as PFS"),
                   DB::raw("sum(ASCPFS_MALE+ASCPFS_FEMALE) as ASCPFS"),
                   DB::raw("sum(ASTPFS_MALE+ASTPFS_FEMALE) as ASTPFS"),
                   DB::raw("sum(LT_MALE+LT_FEMALE) as LT"),
                   DB::raw("sum(OT_TCH_MALE+OT_TCH_FEMALE) as OT_TCH")
               )
          ->groupby("college")
          ->groupby("collegecode")
          ->orderby("Collegecode")
          ->get();
          
          $FT= DB::table("FT_TCH_DEP")
                 ->select("college",
                   DB::raw("sum(PFS_MALE+PFS_FEMALE) as PFS"),
                   DB::raw("sum(ASCPFS_MALE+ASCPFS_FEMALE) as ASCPFS"),
                   DB::raw("sum(ASTPFS_MALE+ASTPFS_FEMALE) as ASTPFS"),
                   DB::raw("sum(LT_MALE+LT_FEMALE) as LT"),
                   DB::raw("sum(OT_TCH_MALE+OT_TCH_FEMALE) as OT_TCH")

               )
          ->join("Teacher_System",
            "FT_TCH_DEP.UNIT_CODE","=","Teacher_System.department_code")
          ->where("SCH_NAME",$schoolname)
          ->where("FT_TCH_DEP.AD_YEAR",$ad_year)
          ->where("Teacher_System.AD_YEAR",$ad_year)
          // ->where("UNIT_CODE","department_code")
          ->groupby("college")
          ->groupby("Collegecode")
          ->orderby("Collegecode")
          ->get();  //SELECT MAX(AD_YEAR) as year FROM FT_TCH_DEP  where SCH_NAME = '國立臺中科技大學','year'=>$year
          $year = DB::table("FT_TCH_DEP")
                  ->select(DB::raw("MAX(AD_YEAR)as year"))
                  ->where("SCH_NAME",$schoolname)
                  ->get();

        return response()->json(['dataPT' => $PT,'dataFT' => $FT,'year'=>$year],Response::HTTP_OK);
    }
    //教師系
    function teacher_department(){
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
      $Colrow = DB::table("Teacher_System")
                  ->SELECT("college")
                  ->groupby("college")
                  ->groupby("Collegecode")
                  ->orderby("Collegecode")
                  ->get();
      $year = request()->input("year");
      //菜單連結
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
      $link_EnrollmentAnalysis =DB::Table('進入本校學生入學管道')
                 ->max("入學學年期");
      $link_treemap=DB::Table('入學前地區')
                 ->max("入學學年期");

      $link_tpr =DB::Table('生師比_校')
                 ->where('學校名稱','=',$schoolname)
                 ->max("學年度");
                    //最新年度
      if(is_null($year)){
           $nowyear = DB::Table('PT_TCH_DEP')
                    ->where('SCH_NAME','=',$schoolname)
                    ->max("AD_YEAR");}
        else{
             $nowyear=$year;
                   }

      $Col_DEP = DB::Table('College_System')
                   ->select('College','DEP_SIMPLE')
                   ->where('AD_YEAR',$year)
                   ->groupby('College')
                   ->groupby('DEP_SIMPLE')
                   ->groupby('COL_NUM')
                   ->orderby('COL_NUM')
                   ->get();
      
      $numrow = DB::select(DB::raw("SET NOCOUNT ON;
                                    EXEC dbo.NumOfTeachers $nowyear, 
                                                          '$schoolname'"));
      // dd($numrow);
      $numrowPK = DB::select(DB::raw("SET NOCOUNT ON;
                                      EXEC dbo.NumOfTeachersPK $nowyear,
                                                              '$schoolname'"));
      // dd($numrowPK);
      // $t = DB::select(DB::raw("SET NOCOUNT ON;EXEC dbo.NumOfTeachersPK"))
      //         ->where("department","資訊工程系")
      //         ->get();

      // dd($t);
    	return view("teacher.teacher_department",compact('Colrow',
                                                       'numrow',
                                                       'numrowPK',
                                                       'nowyear',
                                                       'link_student',
                                                       'link_s_suspension',
                                                       'link_s_dropout',
                                                       'link_teacher',
                                                       'link_teacherHour',
                                                       'link_tpr',
                                                       'link_EnrollmentAnalysis',
                                                       'Col_DEP',
                                                       'link_treemap'));
    }
}
