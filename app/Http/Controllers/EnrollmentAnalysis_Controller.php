<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
class EnrollmentAnalysis_Controller extends Controller
{

    function School(){
      $year = request()->input("year");
      $SchoolSystem = '四技';
      
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];

      // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
      
        if(is_null($year)){
           $nowyear = DB::Table('進入本校學生入學管道')
                    ->max("入學學年期");}
        else{
             $nowyear=$year;
                   }
      $EnrollmentAna = DB::select(DB::raw("SET NOCOUNT ON;EXEC EnrollmentAnalysisSchool $nowyear"));
      // dd($EnrollmentAna);

      return view("admissions.EnrollmentAnalysis",compact('EnrollmentAna','nowyear'));
    }
    function Department(){
      $year = request()->input("year");
      $department = request()->input("value");
      $SchoolSystem = '四技';
      
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];

      // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
      
        if(is_null($year)){
           $nowyear = DB::Table('進入本校學生入學管道')
                    ->max("入學學年期");}
        else{
             $nowyear=$year;
                   }
      if($nowyear == 110){
        $Col_DEP = DB::Table('College_System')
                     ->select('College','DEP_SIMPLE')
                     ->where('AD_YEAR',$nowyear-1)
                     ->groupby('College')
                     ->groupby('DEP_SIMPLE')
                     ->groupby('COL_NUM')
                     ->orderby('COL_NUM')
                     ->get();
      }else{
        $Col_DEP = DB::Table('College_System')
                      ->select('College','DEP_SIMPLE')
                      ->where('AD_YEAR',$nowyear)
                      ->groupby('College')
                      ->groupby('DEP_SIMPLE')
                      ->groupby('COL_NUM')
                      ->orderby('COL_NUM')
                      ->get();
      }
      $EnrollmentAna = DB::select(DB::raw("SET NOCOUNT ON;EXEC EnrollmentAnalysis $nowyear,$department"));
      // dd($EnrollmentAna);

      return view("admissions.EnrollmentAnalysisDepartment",compact('EnrollmentAna','nowyear','Col_DEP'));
    }

    // AJAX：只回傳圖表資料 JSON，不整頁刷新
    function DepartmentData(){
      $year       = request()->input("year");
      $department = request()->input("value");
      if(is_null($year)){
        $nowyear = DB::Table('進入本校學生入學管道')->max("入學學年期");
      } else {
        $nowyear = $year;
      }

      $EnrollmentAna = DB::select(DB::raw("SET NOCOUNT ON;EXEC EnrollmentAnalysis $nowyear,$department"));

      $chartData = [];
      $seenSchool = [];
      $seenDep    = [];
      foreach($EnrollmentAna as $EA){
        $schoolId = 'id-' . $EA->入學前學校;
        $depId    = 'id-' . $EA->入學前學校 . '-' . $EA->入學前學校科組;

        if(!in_array($schoolId, $seenSchool)){
          $seenSchool[] = $schoolId;
          $chartData[] = ['name' => $EA->入學前學校, 'id' => $schoolId];
        }
        if(!in_array($depId, $seenDep)){
          $seenDep[] = $depId;
          $chartData[] = ['name' => $EA->入學前學校科組, 'id' => $depId, 'parent' => $schoolId];
        }
        $chartData[] = [
          'name'   => $EA->入學其他分類,
          'parent' => $depId,
          'value'  => (int)$EA->人數,
          'color'  => $EA->顏色,
        ];
      }

      return response()->json([
        'data'       => $chartData,
        'department' => $department,
        'year'       => $nowyear,
      ]);
    }
    function More(){
      $year = request()->input("year");
      // $department = request()->input("value");
      $SchoolSystem = '四技';
      if(is_null(request()->input("year"))){
         $nowyear = DB::Table('進入本校學生入學管道')
                  ->max("入學學年期");
      }else{
           $nowyear=$year;
      }
      
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];

      // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
      
      if(is_null(request()->input("value"))){
        $Skills_Screening = DB::Table('進入本校學生入學管道')
                              ->select('入學前學校',DB::raw("count(入學前學校) as 人數"))
                              ->where('入學學年期',$nowyear)
                              ->where('入學其他分類','技優甄審')
                              ->groupby('入學前學校')
                              ->orderby(DB::raw("count(入學前學校)"),'desc')
                              ->get();
        $Admission = DB::Table('進入本校學生入學管道')
                       ->select('入學前學校',DB::raw("count(入學前學校) as 人數"))
                       ->where('入學學年期',$nowyear)
                       ->where('入學其他分類','申請入學')
                       ->groupby('入學前學校')
                       ->orderby(DB::raw("count(入學前學校)"),'desc')
                       ->get();
        $Selection_admission = DB::Table('進入本校學生入學管道')
                                 ->select('入學前學校',DB::raw("count(入學前學校) as 人數"))
                                 ->where('入學學年期',$nowyear)
                                 ->where('入學其他分類','甄選入學')
                                 ->groupby('入學前學校')
                                 ->orderby(DB::raw("count(入學前學校)"),'desc')
                                 ->get();
        $Other = DB::Table('進入本校學生入學管道')
                   ->select('入學前學校',DB::raw("count(入學前學校) as 人數"))
                   ->where('入學學年期',$nowyear)
                   ->where('入學其他分類','其它')
                   ->groupby('入學前學校')
                   ->orderby(DB::raw("count(入學前學校)"),'desc')
                   ->get();
        $department = null;
      return view("admissions.EnrollmentAnalysisMore",
             compact('nowyear','department',
                     'Skills_Screening','Admission','Selection_admission','Other')
           );
      }else{
        $department = request()->input("value");
        $Skills_Screening = DB::Table('進入本校學生入學管道')
                              ->select('入學前學校',DB::raw("count(入學前學校) as 人數"))
                              ->where('入學學年期',$nowyear)
                              ->where('科系',$department)
                              ->where('入學其他分類','技優甄審')
                              ->groupby('入學前學校')
                              ->orderby(DB::raw("count(入學前學校)"),'desc')
                              ->get();
        $Admission = DB::Table('進入本校學生入學管道')
                       ->select('入學前學校',DB::raw("count(入學前學校) as 人數"))
                       ->where('入學學年期',$nowyear)
                       ->where('科系',$department)
                       ->where('入學其他分類','申請入學')
                       ->groupby('入學前學校')
                       ->orderby(DB::raw("count(入學前學校)"),'desc')
                       ->get();
        $Selection_admission = DB::Table('進入本校學生入學管道')
                                 ->select('入學前學校',DB::raw("count(入學前學校) as 人數"))
                                 ->where('入學學年期',$nowyear)
                                 ->where('科系',$department)
                                 ->where('入學其他分類','甄選入學')
                                 ->groupby('入學前學校')
                                 ->orderby(DB::raw("count(入學前學校)"),'desc')
                                 ->get();
        $Other = DB::Table('進入本校學生入學管道')
                   ->select('入學前學校',DB::raw("count(入學前學校) as 人數"))
                   ->where('入學學年期',$nowyear)
                   ->where('科系',$department)
                   ->where('入學其他分類','其它')
                   ->groupby('入學前學校')
                   ->orderby(DB::raw("count(入學前學校)"),'desc')
                   ->get();
      return view("admissions.EnrollmentAnalysisMore",
             compact('nowyear','department',
                     'Skills_Screening','Admission','Selection_admission','Other')
           );
      }
    }


    function Pr(){
      
      $year = request()->input("year");
      $department = request()->input("value");
      $SchoolSystem = '四技';
      
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];

      // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
      
        if(is_null($year)){
           $nowyear = DB::Table('進入本校學生入學管道')
                    ->max("入學學年期");}
        else{
             $nowyear=$year;
                   }
     
    // =========================
    // 1. 撈實際資料（102–114）
    // =========================
    $real = DB::table('apply_real')
        ->select('group_code', 'group_name', 'year', 'apply_count')
        ->orderBy('group_code')
        ->orderBy('year')
        ->get();

    // =========================
    // 2. 撈預測資料（115–117）
    // =========================
    $pred = DB::table('apply_pred')
        ->select('group_code', 'group_name', 'year', 'apply_pred_count')
        ->orderBy('group_code')
        ->orderBy('year')
        ->get();

    // =========================
    // 3. 取得「完整年度軸」（動態）
    //    → 實際 + 預測 所有出現過的 year
    // =========================
    $ALL_YEARS = collect($real->pluck('year'))
        ->merge($pred->pluck('year'))
        ->unique()
        ->sort()
        ->values()
        ->toArray();

    // =========================
    // 4. 依 group_code 分組
    // =========================
    $realGrouped = $real->groupBy('group_code');
    $predGrouped = $pred->groupBy('group_code');

    $GROUPS = [];

    // =========================
    // 5. 合併實際 + 預測（年份對齊）
    // =========================
    foreach ($realGrouped as $groupCode => $realRows) {

        $predRows = $predGrouped->get($groupCode, collect());

        // year => value map
        $realMap = $realRows
            ->pluck('apply_count', 'year')
            ->toArray();

        $predMap = $predRows
            ->pluck('apply_pred_count', 'year')
            ->toArray();

        $values = [];

        foreach ($ALL_YEARS as $y) {
            if (isset($realMap[$y])) {
                $values[] = (int)$realMap[$y];
            } elseif (isset($predMap[$y])) {
                $values[] = (int)$predMap[$y];
            } else {
                $values[] = null;   // 該年度無資料
            }
        }

        // 預測起始年度（給前端畫 plotBand）
        $forecastStart = count($predMap) > 0
            ? min(array_keys($predMap))
            : null;

        $GROUPS[] = [
            'GROUP_CODE'     => str_pad($groupCode, 2, '0', STR_PAD_LEFT),
            'GROUP_NAME'     => $realRows->first()->group_name,
            'YEAR'           => $ALL_YEARS,   // ⭐ 動態年度（前端用）
            'VALUE'          => $values,      // ⭐ 與 YEAR 完全對齊
            'FORECAST_START' => $forecastStart
        ];
    }
      return view("admissions.Pr_student_class",compact('GROUPS','nowyear'));
    }


}
