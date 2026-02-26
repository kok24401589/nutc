<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
class TprController extends Controller
{
    function school(){
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
      
      // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
      
      $year = request()->input("year");
      if(is_null($year)){
      $nowyear = DB::Table('生師比_校')
                 ->where('學校名稱','=',$schoolname)
                 ->max("學年度");}
      else{
             $nowyear=$year;
                   }
      $StudentTeacherRatio = DB::Table('生師比_校')
                               ->SELECT('學校名稱',
                                         DB::raw("row_number()OVER(ORDER BY 日間生師比) as RANK"),
                                         DB::raw("日間學制學生數 as 學生"),
                                         DB::raw("日間專任教師 as 教師"),
                                         DB::raw("日間生師比 as 生師比")
                                         )
                               ->where('設立別','公立')
                               ->where('學校類別','技專校院' )
                               ->where('學年度',$nowyear)
                               ->orderby('生師比')
                               ->get();
      // dd($StudentTeacherRatio);
      $StudentTeacherRatioS = DB::Table('生師比_校')
                                ->SELECT('學校名稱',
                                          DB::raw("row_number()OVER(ORDER BY 日間學制學生數 DESC) as RANK"),
                                          DB::raw("日間學制學生數 as 學生"),
                                          DB::raw("日間專任教師 as 教師"),
                                          DB::raw("日間生師比 as 生師比")
                                          )
                                ->where('設立別','公立')
                                ->where('學校類別','技專校院' )
                                ->where('學年度',$nowyear)
                                ->orderby('學生','DESC')
                                ->get();
      // dd($StudentTeacherRatioS);
      $StudentTeacherRatioT = DB::Table('生師比_校')
                                ->SELECT('學校名稱',
                                          DB::raw("row_number()OVER(ORDER BY 日間專任教師 DESC) as RANK"),
                                          DB::raw("日間學制學生數 as 學生"),
                                          DB::raw("日間專任教師 as 教師"),
                                          DB::raw("日間生師比 as 生師比")
                                          )
                                ->where('設立別','公立')
                                ->where('學校類別','技專校院' )
                                ->where('學年度',$nowyear)
                                ->orderby('教師','DESC')
                                ->get();
      // dd($StudentTeacherRatioT);
      return view("teacher.tpr",compact('schoolname',
                                        'StudentTeacherRatio',
                                        'StudentTeacherRatioS',
                                        'StudentTeacherRatioT',
                                        'nowyear'
                                        )
                 );
    }
    function college(){
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
      
      // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
      
      $year = request()->input("year");
      if(is_null($year)){
      $nowyear = DB::Table('生師比_校')
                 ->where('學校名稱','=',$schoolname)
                 ->max("學年度");}
      else{
             $nowyear=$year;
          }
      $College=DB::Table('College_System')
                  ->select('College','COL_COLOR','COL_NUM','AD_YEAR')
                  ->where('AD_YEAR',$nowyear)
                  ->groupby('College')
                  ->groupby('COL_COLOR')
                  ->groupby('COL_NUM')
                  ->groupby('AD_YEAR')
                  ->orderby('COL_NUM')
                  ->get();
      //學院生師比排名
      $college = DB::select(DB::raw("SET NOCOUNT ON;EXEC dbo.TPR $nowyear,'$schoolname'"));
      // dd($college);

      //商學院生師比排名 依生師比排序 參數：年度,學校名稱,學院,排序[0:生師比,1:學生,2:教師])
      $ComCollegeTPR = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','商學院',0
                                ")
                      );
      // dd($ComCollegeTPR);
      $ComCollegeS = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','商學院',1
                                ")
                      );
      // dd($ComCollegeS);
      $ComCollegeT = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','商學院',2
                                ")
                      );
      // dd($ComCollegeT);
      //設計學院生師比排名 依生師比排序 參數：年度,學校名稱,學院,排序[0:生師比,1:學生,2:教師])
      $CodCollegeTPR = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','設計學院',0
                                ")
                      );
      // dd($CodCollegeTPR);
      $CodCollegeS = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','設計學院',1
                                ")
                      );
      // dd($CodCollegeS);
      $CodCollegeT = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','設計學院',2
                                ")
                      );
      // dd($CodCollegeT);
      //資訊流通學院生師比排名 依生師比排序 參數：年度,學校名稱,學院,排序[0:生師比,1:學生,2:教師])
      $CidsCollegeTPR = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','資訊流通學院',0
                                ")
                      );
      // dd($CidsCollegeTPR);
      $CidsCollegeS = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','資訊流通學院',1
                                ")
                      );
      // dd($CidsCollegeS);
      $CidsCollegeT = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','資訊流通學院',2
                                ")
                      );
      // dd($CidsCollegeT);
      //語文學院生師比排名 依生師比排序 參數：年度,學校名稱,學院,排序[0:生師比,1:學生,2:教師])
      $ColCollegeTPR = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','語文學院',0
                                ")
                      );
      // dd($ColCollegeTPR);
      $ColCollegeS = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','語文學院',1
                                ")
                      );
      // dd($ColCollegeS);
      $ColCollegeT = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','語文學院',2
                                ")
                      );
      // dd($ColCollegeT);
      //商學院生師比排名 依生師比排序 參數：年度,學校名稱,學院,排序[0:生師比,1:學生,2:教師])
      $NtcncCollegeTPR = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','中護健康學院',0
                                ")
                      );
      // dd($NtcncCollegeTPR);
      $NtcncCollegeS = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','中護健康學院',1
                                ")
                      );
      // dd($NtcncCollegeS);
      $NtcncCollegeT = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','中護健康學院',2
                                ")
                      );

      return view("teacher.tpr_college",
                  compact('schoolname','college',
                          'ComCollegeTPR','ComCollegeS','ComCollegeT',
                          'CodCollegeTPR','CodCollegeS','CodCollegeT',
                          'CidsCollegeTPR','CidsCollegeS','CidsCollegeT',
                          'ColCollegeTPR','ColCollegeS','ColCollegeT',
                          'NtcncCollegeTPR','NtcncCollegeS','NtcncCollegeT',
                          'nowyear','College'
                         )
                );
    }
function collegeapi(){
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
      $nowyear = request()->input("year");
      $college= request()->input("college");
      //商學院生師比排名 依生師比排序 參數：年度,學校名稱,學院,排序[0:生師比,1:學生,2:教師])
      $CollegeTPR = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','$college',0
                                ")
                      );
      // dd($ComCollegeTPR);
      $CollegeS = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','$college',1
                                ")
                      );
      // dd($ComCollegeS);
      $CollegeT = DB::select(
                        DB::raw("SET NOCOUNT ON;
                                 EXEC dbo.TPR_College $nowyear,'$schoolname','$college',2
                                ")
                      );
  return response()->json(['CollegeTPR' => $CollegeTPR,'CollegeS' => $CollegeS,'CollegeT' => $CollegeT],Response::HTTP_OK);
}
function department(){
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
      
      // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
      
     $year = request()->input("year");
      if(is_null($year)){
           $nowyear = DB::Table('FT_TCH_DEP')
                    ->where('SCH_NAME','=',$schoolname)
                    ->max("AD_YEAR");}
      else{
             $nowyear=$year;
                   }

     $dp_sname= DB::table("College_System")
                ->select('DEP_SIMPLE','DEP_LIKE','DEP_COLOR','AD_YEAR')
                ->where('AD_YEAR',$nowyear)
                ->where('SYSTEM_TYPE','日間部')
                ->groupby('DEP_SIMPLE')
                ->groupby('COL_NUM')
                ->groupby('DEP_LIKE')
                ->groupby('DEP_COLOR')
                ->groupby('AD_YEAR')
                ->orderby('COL_NUM')
                ->get();
        
        
      return view("teacher.tpr_department",compact('dp_sname','nowyear','schoolname'));
    }
    function department_api(){
      $yaer = request()->input("year");
      $dp= request()->input("dp");
     $tpr = DB::select(DB::raw("SET NOCOUNT ON;EXEC dbo.tpr_dp $yaer,'$dp'"));
     return response()->json(['tpr' => $tpr],Response::HTTP_OK);
    }
}
