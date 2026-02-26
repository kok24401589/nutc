<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
class treemap_Controller extends Controller
{
    public function treemap(){
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
      
      // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
      
      $year = request()->input("year");
      if(is_null($year)){
      $nowyear = DB::Table('入學前地區')
                 ->max("入學學年期");}
      else{
             $nowyear=$year;
                   }
      $all = DB::Table('入學前地區')
               ->SELECT(DB::raw("
                 COUNT(CASE 
                       WHEN 入學前學校所在城市 in ('臺北市','新北市','基隆市','桃園市','桃園縣','宜蘭縣','新竹縣','新竹市') THEN '北部'
                       WHEN 入學前學校所在城市 in ('苗栗縣','臺中市','彰化縣','南投縣','雲林縣') THEN '中部'
                       WHEN 入學前學校所在城市 in ('高雄市','臺南市','嘉義市','嘉義縣','屏東縣','澎湖縣') THEN '南部'
                       WHEN 入學前學校所在城市 in ('臺東縣','花蓮縣') THEN '東部'
                       ELSE '其他'
                       END) 人數"
                              )
                       )
               ->where('入學學年期',$nowyear)
               ->get();
    // dd($all);
  //全學制
      $area = DB::select(DB::raw("SET NOCOUNT ON;EXEC area '五專',1,$nowyear"));
    // dd($area);
      $StudentSourceNumber = DB::select(DB::raw("SET NOCOUNT ON;EXEC dbo.SSN '五專',1,$nowyear"));
//五專
      $area_five = DB::select(DB::raw("SET NOCOUNT ON;EXEC area '五專',0,$nowyear"));
      $StudentSourceNumber_five  = DB::select(DB::raw("SET NOCOUNT ON;EXEC dbo.SSN '五專',0,$nowyear"));
//四技
      $area_fs = DB::select(DB::raw("SET NOCOUNT ON;EXEC area '四技',0,$nowyear"));
      $StudentSourceNumber_fs = DB::select(DB::raw("SET NOCOUNT ON;EXEC dbo.SSN '四技',0,$nowyear"));
//二技
      $area_second = DB::select(DB::raw("SET NOCOUNT ON;EXEC area '二技',0,$nowyear"));
      $StudentSourceNumber_second = DB::select(DB::raw("SET NOCOUNT ON;EXEC dbo.SSN '二技',0,$nowyear"));
//碩士班
      $area_master = DB::select(DB::raw("SET NOCOUNT ON;EXEC area '碩士班',0,$nowyear"));
      $StudentSourceNumber_master = DB::select(DB::raw("SET NOCOUNT ON;EXEC dbo.SSN '碩士班',0,$nowyear"));

//五專
      $all_five = DB::Table('入學前地區')
               ->SELECT(DB::raw("
                 COUNT(CASE 
                       WHEN 入學前學校所在城市 in ('臺北市','新北市','基隆市','桃園市','桃園縣','宜蘭縣','新竹縣','新竹市') THEN '北部'
                       WHEN 入學前學校所在城市 in ('苗栗縣','臺中市','彰化縣','南投縣','雲林縣') THEN '中部'
                       WHEN 入學前學校所在城市 in ('高雄市','臺南市','嘉義市','嘉義縣','屏東縣','澎湖縣') THEN '南部'
                       WHEN 入學前學校所在城市 in ('臺東縣','花蓮縣') THEN '東部'
                       ELSE '其他'
                       END) 人數"
                              )
                      )
               ->where("學制","五專")
               ->where('入學學年期',$nowyear)
               ->get();
//四技
      $all_fs = DB::Table('入學前地區')
               ->SELECT(DB::raw("
                 COUNT(CASE 
                       WHEN 入學前學校所在城市 in ('臺北市','新北市','基隆市','桃園市','桃園縣','宜蘭縣','新竹縣','新竹市') THEN '北部'
                       WHEN 入學前學校所在城市 in ('苗栗縣','臺中市','彰化縣','南投縣','雲林縣') THEN '中部'
                       WHEN 入學前學校所在城市 in ('高雄市','臺南市','嘉義市','嘉義縣','屏東縣','澎湖縣') THEN '南部'
                       WHEN 入學前學校所在城市 in ('臺東縣','花蓮縣') THEN '東部'
                       ELSE '其他'
                       END) 人數"
                              )
                       )
               ->where("學制","四技")
               ->where('入學學年期',$nowyear)
               ->get();
//二技
      $all_second = DB::Table('入學前地區')
               ->SELECT(DB::raw("
                 COUNT(CASE 
                       WHEN 入學前學校所在城市 in ('臺北市','新北市','基隆市','桃園市','桃園縣','宜蘭縣','新竹縣','新竹市') THEN '北部'
                       WHEN 入學前學校所在城市 in ('苗栗縣','臺中市','彰化縣','南投縣','雲林縣') THEN '中部'
                       WHEN 入學前學校所在城市 in ('高雄市','臺南市','嘉義市','嘉義縣','屏東縣','澎湖縣') THEN '南部'
                       WHEN 入學前學校所在城市 in ('臺東縣','花蓮縣') THEN '東部'
                       ELSE '其他'
                       END) 人數"
                              )
                       )
               ->where("學制","二技")
               ->where('入學學年期',$nowyear)
               ->get();
//碩班
      $all_master = DB::Table('入學前地區')
               ->SELECT(DB::raw("
                 COUNT(CASE 
                       WHEN 入學前學校所在城市 in ('臺北市','新北市','基隆市','桃園市','桃園縣','宜蘭縣','新竹縣','新竹市') THEN '北部'
                       WHEN 入學前學校所在城市 in ('苗栗縣','臺中市','彰化縣','南投縣','雲林縣') THEN '中部'
                       WHEN 入學前學校所在城市 in ('高雄市','臺南市','嘉義市','嘉義縣','屏東縣','澎湖縣') THEN '南部'
                       WHEN 入學前學校所在城市 in ('臺東縣','花蓮縣') THEN '東部'
                       ELSE '其他'
                       END) 人數"
                              )
                       )
               ->where("學制","碩士班")
               ->where('入學學年期',$nowyear)
               ->get();




    	return view("admissions.treemap",compact('all',
                                               'all_fs',
                                               'all_five',
                                               'all_second',
                                               'all_master',
                                               'area',
                                               'area_fs',
                                               'area_five',
                                               'area_master',
                                               'area_second',
                                               'StudentSourceNumber',
                                               'StudentSourceNumber_five',
                                               'StudentSourceNumber_fs',
                                               'StudentSourceNumber_master',
                                               'StudentSourceNumber_second',
                                               'nowyear'));
    }
    function TreemapDepartment(){
      $department = request()->input("value");
      
      $year = request()->input("year");
      if(is_null($year)){
      $nowyear = DB::Table('入學前地區')
                 ->max("入學學年期");}
      else{
             $nowyear=$year;
                   }
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];

      // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理

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

      $StudentSourceNumber = DB::select(DB::raw("SET NOCOUNT ON;EXEC SourceAnalysisDepartment $department,$nowyear"));
      // dd($StudentSourceNumber);
      return view("admissions.TreemapDepartment",compact('StudentSourceNumber','Col_DEP','nowyear'));
    }

    // AJAX：只回傳圖表資料 JSON，不整頁刷新
    function TreemapDepartmentData(){
      $department = request()->input("value");
      $year       = request()->input("year");
      if(is_null($year)){
        $nowyear = DB::Table('入學前地區')->max("入學學年期");
      } else {
        $nowyear = $year;
      }

      $StudentSourceNumber = DB::select(DB::raw("SET NOCOUNT ON;EXEC SourceAnalysisDepartment $department,$nowyear"));

      $chartData = [];
      $temp = "";
      $team = 0;
      foreach($StudentSourceNumber as $ssn){
        if($ssn->入學前學校 != $temp){
          $temp = $ssn->入學前學校;
          $team++;
          $chartData[] = [
            'name'  => $ssn->入學前學校 . '<br/>(' . $ssn->學校人數 . ')',
            'id'    => 'id-' . $team,
            'color' => $ssn->顏色,
          ];
        }
        $chartData[] = [
          'name'   => $ssn->入學前學校科組 . '<br/>(' . $ssn->人數 . ')',
          'parent' => 'id-' . $team,
          'value'  => (int)$ssn->人數,
        ];
      }

      return response()->json([
        'data'       => $chartData,
        'department' => $department,
        'year'       => $nowyear,
      ]);
    }
    function TreemapMore(){
      $department = request()->input("value");
            $year = request()->input("year");
      if(is_null($year)){
      $nowyear = DB::Table('入學前地區')
                 ->max("入學學年期");}
      else{
             $nowyear=$year;
                   }
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];

      // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理

      $N = array('臺北市','新北市','基隆市','桃園市','桃園縣','宜蘭縣','新竹縣','新竹市');

      $North = DB::Table('入學前地區')
                 ->SELECT('入學前學校',
                          DB::raw("count('入學前學校') as'人數'")
                        )
                 ->where('科系',$department)
                 ->where('入學學年期',$nowyear)
                 ->wherein('入學前學校所在城市',$N)
                 ->groupby('入學前學校')
                 ->orderby(DB::raw('count(入學前學校)'),'DESC')
                 ->get();
      // dd($North);
      $C = array('苗栗縣','臺中市','彰化縣','南投縣','雲林縣');

      $Central = DB::Table('入學前地區')
                   ->SELECT('入學前學校',
                            DB::raw("count('入學前學校') as'人數'")
                          )
                   ->where('科系',$department)
                   ->where('入學學年期',$nowyear)
                   ->wherein('入學前學校所在城市',$C)
                   ->groupby('入學前學校')
                   ->orderby(DB::raw('count(入學前學校)'),'DESC')
                   ->get();
      // dd($Central);
      $S = array('高雄市','臺南市','嘉義市','嘉義縣','屏東縣','澎湖縣');

      $South = DB::Table('入學前地區')
                 ->SELECT('入學前學校',
                          DB::raw("count('入學前學校') as'人數'")
                        )
                 ->where('科系',$department)
                 ->where('入學學年期',$nowyear)
                 ->wherein('入學前學校所在城市',$S)
                 ->groupby('入學前學校')
                 ->orderby(DB::raw('count(入學前學校)'),'DESC')
                 ->get();
      $E = array('臺東縣','花蓮縣');

      $East = DB::Table('入學前地區')
                ->SELECT('入學前學校',
                         DB::raw("count('入學前學校') as'人數'")
                       )
                ->where('科系',$department)
                ->where('入學學年期',$nowyear)
                ->wherein('入學前學校所在城市',$E)
                ->groupby('入學前學校')
                ->orderby(DB::raw('count(入學前學校)'),'DESC')
                ->get();
      $O= array_merge($N,$C,$S,$E);
      $Other = DB::Table('入學前地區')
                 ->SELECT('入學前學校',
                          DB::raw("count('入學前學校') as'人數'")
                        )
                 ->where('科系',$department)
                 ->where('入學學年期',$nowyear)
                 ->whereNotin('入學前學校所在城市',$O
                              )
                 ->groupby('入學前學校')
                 ->orderby(DB::raw('count(入學前學校)'),'DESC')
                 ->get();
         // dd($Other);
      return view("admissions.TreemapMore",
                  compact('North',
                          'Central',
                          'South',
                          'East',
                          'Other',
                          'nowyear')
                  );
    }
}
