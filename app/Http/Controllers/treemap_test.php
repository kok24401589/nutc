<?php

namespace App\Http\Controllers;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class treemap_test extends Controller
{
    public function TreemapMore_s(){
$system = request()->input("system");
      //菜單連結
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
      $year = request()->input("year");
      if(is_null($year)){
      $nowyear = DB::Table('入學前地區')
                 ->max("入學學年期");}
      else{
             $nowyear=$year;
                   }

if(is_null($system)){
	     $N = array('臺北市','新北市','基隆市','桃園市','桃園縣','宜蘭縣','新竹縣','新竹市');

      $North = DB::Table('入學前地區')
                 ->SELECT('入學前學校',
                          DB::raw("count('入學前學校') as'人數'")
                        )
                 
                 ->wherein('入學前學校所在城市',$N)
                 ->where('入學學年期',$nowyear)
                 ->groupby('入學前學校')
                 ->orderby(DB::raw('count(入學前學校)'),'DESC')
                 ->get();
      // dd($North);
      $C = array('苗栗縣','臺中市','彰化縣','南投縣','雲林縣');

      $Central = DB::Table('入學前地區')
                   ->SELECT('入學前學校',
                            DB::raw("count('入學前學校') as'人數'")
                          )
                   
                   ->wherein('入學前學校所在城市',$C)
                   ->where('入學學年期',$nowyear)
                   ->groupby('入學前學校')
                   ->orderby(DB::raw('count(入學前學校)'),'DESC')
                   ->get();
      // dd($Central);
      $S = array('高雄市','臺南市','嘉義市','嘉義縣','屏東縣','澎湖縣');

      $South = DB::Table('入學前地區')
                 ->SELECT('入學前學校',
                          DB::raw("count('入學前學校') as'人數'")
                        )
                 
                 
                 ->wherein('入學前學校所在城市',$S)
                 ->where('入學學年期',$nowyear)
                 ->groupby('入學前學校')
                 ->orderby(DB::raw('count(入學前學校)'),'DESC')
                 ->get();
      $E = array('臺東縣','花蓮縣');

      $East = DB::Table('入學前地區')
                ->SELECT('入學前學校',
                         DB::raw("count('入學前學校') as'人數'")
                       )
               
                ->wherein('入學前學校所在城市',$E)
                ->where('入學學年期',$nowyear)
                ->groupby('入學前學校')
                ->orderby(DB::raw('count(入學前學校)'),'DESC')
                ->get();
      $O= array_merge($N,$C,$S,$E);
      $Other = DB::Table('入學前地區')
                 ->SELECT('入學前學校',
                          DB::raw("count('入學前學校') as'人數'")
                        )
                
                 ->whereNotin('入學前學校所在城市',$O
                              )
                 ->where('入學學年期',$nowyear)
                 ->groupby('入學前學校')
                 ->orderby(DB::raw('count(入學前學校)'),'DESC')
                 ->get();
             }
    else{
     $N = array('臺北市','新北市','基隆市','桃園市','桃園縣','宜蘭縣','新竹縣','新竹市');

      $North = DB::Table('入學前地區')
                 ->SELECT('入學前學校',
                          DB::raw("count('入學前學校') as'人數'")
                        )
                 ->where('學制',$system)
                 ->wherein('入學前學校所在城市',$N)
                 ->where('入學學年期',$nowyear)
                 ->groupby('入學前學校')
                 ->orderby(DB::raw('count(入學前學校)'),'DESC')
                 ->get();
      // dd($North);
      $C = array('苗栗縣','臺中市','彰化縣','南投縣','雲林縣');

      $Central = DB::Table('入學前地區')
                   ->SELECT('入學前學校',
                            DB::raw("count('入學前學校') as'人數'")
                          )
                   ->where('學制',$system)
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
                 ->where('學制',$system)
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
                ->where('學制',$system)
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
                 ->where('學制',$system)
                 ->where('入學學年期',$nowyear)
                 ->whereNotin('入學前學校所在城市',$O
                              )
                 ->groupby('入學前學校')
                 ->orderby(DB::raw('count(入學前學校)'),'DESC')
                 ->get();}
         // dd($Other);
      return view("admissions.TreemapMore_test",
                  compact('North',
                          'Central',
                          'South',
                          'East',
                          'Other',
                          'link_student',
                          'link_s_suspension',
                          'link_s_dropout',
                          'link_teacher',
                          'link_teacherHour',
                          'link_tpr','link_EnrollmentAnalysis','nowyear','link_treemap')
                  );
    }
}
