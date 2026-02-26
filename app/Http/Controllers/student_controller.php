<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
// $content = App::make('Controllers\student_controller')->test('108');
//     var_dump($content);
class student_controller extends Controller
{
    //學生人數-校
    public function student(){
      // 🎯 MenuComposer 會自動提供 $schoolname 和 $menuLinks
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
      
      // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
      //$schoolname 學校名稱
      $year = request()->input("year");

        
        //$nowyear 資料庫最新資料年
        if(is_null($year)){
           $nowyear = DB::Table('STU_SCH')
                    ->where('SCH_NAME','=',$schoolname)
                    ->max("AD_YEAR");}
        else{
             $nowyear=$year;
                   }

        $STU_SUM = DB::Table('STU_SCH')
                    ->select(DB::raw("sum(STU_SUM) as STU_SUM"))
                    ->where("AD_YEAR",'=',$nowyear)
                    ->where('SCH_NAME','=',$schoolname)
                    ->first();

        $SYSTEM_TYPE = DB::Table('STU_DEP As a')
                        ->leftjoin('College_System As b', function ($join) {
                                $join->on('b.DEP_CODE','a.DEP_CODE');
                                $join->on('b.AD_YEAR','a.AD_YEAR');
                                $join->on('b.SCH_SYS','a.SCH_SYS');
                                $join->on('b.DEP_NAME','a.DEP_NAME');
                        })
                        ->select('SYSTEM_TYPE',DB::raw("sum(STU_SUM) as STU_SUM"))
                        ->where('a.AD_YEAR','=',$nowyear)
                        ->where('SCH_NAME','=',$schoolname)
                        ->groupby('b.SYSTEM_TYPE')
                        ->groupby('ST_NUM')
                        ->orderby('ST_NUM')
                        ->get();

        $SCH_SYS = DB::Table('STU_DEP')
                    ->leftjoin('College_System', function ($join) {
                            $join->on('College_System.DEP_CODE','STU_DEP.DEP_CODE');
                            $join->on('College_System.AD_YEAR','STU_DEP.AD_YEAR');
                            $join->on('College_System.SCH_SYS','STU_DEP.SCH_SYS');
                            $join->on('College_System.DEP_NAME','STU_DEP.DEP_NAME');
                    })
                    ->select('STU_DEP.SCH_SYS',DB::raw("sum(STU_SUM) as STU_SUM"))
                    ->where('STU_DEP.AD_YEAR','=',$nowyear)
                    ->where('SCH_NAME','=',$schoolname)
                    ->groupby('STU_DEP.SCH_SYS')
                    ->groupby('SS_NUM')
                    ->orderby('SS_NUM')
                    ->get();

        $College = DB::Table('STU_DEP')
                    ->leftjoin('College_System', function ($join) {
                            $join->on('College_System.DEP_CODE','STU_DEP.DEP_CODE');
                            $join->on('College_System.AD_YEAR','STU_DEP.AD_YEAR');
                            $join->on('College_System.SCH_SYS','STU_DEP.SCH_SYS');
                            $join->on('College_System.DEP_NAME','STU_DEP.DEP_NAME');
                    })
                    ->select('College',DB::raw("sum(STU_SUM) as STU_SUM"))
                    ->where('STU_DEP.AD_YEAR','=',$nowyear)
                    ->where('SCH_NAME','=',$schoolname)
                    ->groupby('College_System.College')
                    ->groupby('COL_NUM')
                    ->orderby('COL_NUM')
                    ->get();

        $STU_SCH = DB::Table('STU_SCH')
                    ->select('SCH_NAME','SCH_CODE',DB::raw("sum(STU_SUM) as STU_SCH"))
                    ->where('AD_YEAR','=',$nowyear)
                    ->where('PUB_OR_PRI','=','公立')
                    ->where('SCH_CTG','=','技專校院')
                    ->groupby('SCH_CODE')
                    ->groupby('SCH_NAME')
                    ->orderby('STU_SCH','DESC')
                    ->take(10)
                    ->get();

        //SET NOCOUNT ON 會防止針對預存程序中的每個陳述式，將DONE_IN_PROC 訊息傳給用戶端。
        $NUMSQL = DB::select(DB::raw("SET NOCOUNT ON;EXEC StudentRank $nowyear"));
        
        // ✅ 移除所有 link_* 變數：MenuComposer 已自動提供 $menuLinks
        return view("student.student",compact('STU_SUM','SYSTEM_TYPE','SCH_SYS','College','STU_SCH','schoolname','NUMSQL','nowyear'));
    }

    function student_college(){
      $year = request()->input("year");

      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
      
       // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
       
        //年度
       if(is_null($year)){
       $nowyear = DB::Table('STU_SCH')
                     ->where('SCH_NAME','=',$schoolname)
                     ->max("AD_YEAR");
                     }
        else{
          $nowyear=$year;
        } 
       
        $colrow= DB::Table('College_System')
                  ->SELECT('College','COL_NUM','COL_COLOR')
                  ->where("AD_YEAR",'=',$nowyear)
                  ->groupby('COL_NUM')
                  ->groupby('College')
                  ->groupby('COL_COLOR')
                  
                  ->get();
        

       
        // dd($department);

    return view("student.student_college",compact('colrow','nowyear')); 
    }

//院api
    function student_college_api(){
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0]; 
       $nowyear = request()->input("year");
        $college = request()->input("College");
         // 學院總人數
        $College = DB::Table('STU_DEP')
                      ->leftjoin('College_System',function ($join) {
                          $join->on('STU_DEP.DEP_CODE','College_System.DEP_CODE');
                          $join->on('STU_DEP.AD_YEAR','College_System.AD_YEAR');
                          $join->on('STU_DEP.SCH_SYS','College_System.SCH_SYS');
                          $join->on('STU_DEP.DEP_NAME','College_System.DEP_NAME');
                      })
                      ->select(DB::raw("sum(STU_SUM) as STU_SUM"))
                      ->where('STU_DEP.AD_YEAR','=',$nowyear)
                      ->where('SCH_NAME','=',$schoolname)
                      ->where('College_System.College','=',$college)
                      ->get();
        // dd($College);

        // 部別
            $Department = DB::Table('STU_DEP')
                      ->leftjoin('College_System',function ($join) {
                          $join->on('STU_DEP.DEP_CODE','College_System.DEP_CODE');
                          $join->on('STU_DEP.AD_YEAR','College_System.AD_YEAR');
                          $join->on('STU_DEP.SCH_SYS','College_System.SCH_SYS');
                          $join->on('STU_DEP.DEP_NAME','College_System.DEP_NAME');
                      })
                      ->select('College_System.SYSTEM_TYPE',DB::raw("sum(STU_SUM) as STU_SUM"))
                      ->where('STU_DEP.AD_YEAR','=',$nowyear)
                      ->where('SCH_NAME','=',$schoolname)
                      ->where('College_System.College','=',$college)
                      ->groupby('College_System.SYSTEM_TYPE')
                      ->get();
        // dd($Department);

        // 學制
        $Sch_sys = DB::Table('STU_DEP')
                      ->leftjoin('College_System',function ($join) {
                          $join->on('STU_DEP.DEP_CODE','College_System.DEP_CODE');
                          $join->on('STU_DEP.AD_YEAR','College_System.AD_YEAR');
                          $join->on('STU_DEP.SCH_SYS','College_System.SCH_SYS');
                          $join->on('STU_DEP.DEP_NAME','College_System.DEP_NAME');
                      })
                      ->select('STU_DEP.SCH_SYS',DB::raw("sum(STU_SUM) as STU_SUM"))
                      ->where('STU_DEP.AD_YEAR','=',$nowyear)
                      ->where('SCH_NAME','=',$schoolname)
                      ->where('College_System.College','=',$college)
                      ->groupby('STU_DEP.SCH_SYS')
                      ->get();
        // dd($Sch_sys);

        // 科系
        $department = DB::Table('STU_DEP')
                      ->leftjoin('College_System',function ($join) {
                          $join->on('STU_DEP.DEP_CODE','College_System.DEP_CODE');
                          $join->on('STU_DEP.AD_YEAR','College_System.AD_YEAR');
                          $join->on('STU_DEP.SCH_SYS','College_System.SCH_SYS');
                          $join->on('STU_DEP.DEP_NAME','College_System.DEP_NAME');
                      })
                      ->select('STU_DEP.DEP_NAME',DB::raw("sum(STU_SUM) as STU_SUM"))
                      ->where('STU_DEP.AD_YEAR','=',$nowyear)
                      ->where('SCH_NAME','=',$schoolname)
                      ->where('College_System.College','=',$college)
                      ->groupby('STU_DEP.DEP_NAME')
                      ->get();
       return response()->json(['College' => $College,'Department' => $Department,'Sch_sys' => $Sch_sys,'department'=>$department],Response::HTTP_OK);
    }

    //休學人數-校
    public function suspension(){
        $year= request()->input("year");
        //$schoolname 學校名稱
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
      // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
        //$nowyear 資料庫最新資料年
        if(is_null($year)){
        $nowyear = DB::Table('SP_SCH_NEW')
                     ->where('SCH_NAME','=',$schoolname)
                     ->max("AD_YEAR");
        }else{
          $nowyear=$year;
        }


        $SP_ED_SUM = DB::Table('SP_SCH_NEW')
                        ->select(DB::raw("sum(SP_ED_SUM) as sum"))
                        ->where("AD_YEAR",'=',$nowyear)
                        ->where('SCH_NAME','=',$schoolname)
                        ->first();
        $STU_SUM = DB::Table('SP_SCH_NEW')
                        ->select(DB::raw("sum(STU_SUM) as t"))
                        ->where("AD_YEAR",'=',$nowyear)
                      
                        ->where('SCH_NAME','=',$schoolname)
                        ->first();
          
        // 部別
        $SYSTEM_TYPE= DB::Table('SP_DEP_NEW')
                        ->select("SYSTEM_TYPE",
                                 DB::raw("sum(STU_SUM)/2 as STU_SUM"),
                                 DB::raw("sum(SP_ED_SUM) as SP_SUM"),
                                 DB::raw("sum(SP_ED_SUM)/sum(STU_SUM) as SPpi")
                                )
                        ->join('DSP_System', function ($join) {
                                $join->on('SP_DEP_NEW.SCH_SYS','DSP_System.SCH_SYS');
                                $join->on('SP_DEP_NEW.DEP_CODE','DSP_System.DEP_CODE');
                                $join->on('SP_DEP_NEW.DEP_NAME','DSP_System.DEP_NAME');
                                $join->on('SP_DEP_NEW.AD_YEAR','DSP_System.AD_YEAR');
                        })
                            
                    ->where("SP_DEP_NEW.AD_YEAR",'=',$nowyear)
                                ->where('SCH_NAME','=',$schoolname)
                    ->groupby('SYSTEM_TYPE')
                    ->get();
        //學制
        $SCH_SYS= DB::Table('SP_DEP_NEW')
                            ->select("SP_DEP_NEW.SCH_SYS",
                                     DB::raw("sum(STU_SUM)/2 as STU_SUM"),
                                     DB::raw("sum(SP_ED_SUM) as SP_SUM"),
                                     DB::raw("sum(SP_ED_SUM)/sum(STU_SUM) as SPpi")
                                    )
                            ->join('DSP_System', function ($join) {
                                    $join->on('SP_DEP_NEW.SCH_SYS','DSP_System.SCH_SYS');
                                    $join->on('SP_DEP_NEW.DEP_CODE','DSP_System.DEP_CODE');
                                    $join->on('SP_DEP_NEW.DEP_NAME','DSP_System.DEP_NAME');
                                    $join->on('SP_DEP_NEW.AD_YEAR','DSP_System.AD_YEAR');
                            })
                            
                            ->where("SP_DEP_NEW.AD_YEAR",'=',$nowyear)
                            ->where('SCH_NAME','=',$schoolname)
                            ->groupby('SP_DEP_NEW.SCH_SYS')
                            ->groupby('SS_NUM')
                            ->orderby('SS_NUM')
                            ->get();
        //院
        $College= DB::Table('SP_DEP_NEW')
                            ->select("DSP_System.COL",
                                     DB::raw("sum(STU_SUM)/2 as STU_SUM"),
                                     DB::raw("sum(SP_ED_SUM) as SP_SUM"),
                                     DB::raw("sum(SP_ED_SUM)/sum(STU_SUM) as SPpi")
                                    )
                            ->join('DSP_System', function ($join) {
                                    $join->on('SP_DEP_NEW.SCH_SYS','DSP_System.SCH_SYS');
                                    $join->on('SP_DEP_NEW.DEP_CODE','DSP_System.DEP_CODE');
                                    $join->on('SP_DEP_NEW.DEP_NAME','DSP_System.DEP_NAME');
                                    $join->on('SP_DEP_NEW.AD_YEAR','DSP_System.AD_YEAR');
                            })
                            
                            ->where("SP_DEP_NEW.AD_YEAR",'=',$nowyear)
                            ->where('SCH_NAME','=',$schoolname)
                            ->groupby('DSP_System.COL')
                            ->groupby('COL_NUM')
                            ->orderby('COL_NUM')
                            ->get();
        //前十
        $STU_SCH=DB::Table('SP_SCH_NEW')
                    ->select("SCH_NAME",
                            DB::raw("sum(STU_SUM)/2 as STU_SUM"),
                            DB::raw("sum(SP_ED_SUM) as SP_SUM"),
                            DB::raw("cast(round(sum(SP_ED_SUM)/sum(STU_SUM),3) as numeric(10,3)) as SPpi")
                            )
                    ->where("AD_YEAR",'=',$nowyear)
                    ->where("PUB_OR_PRI",'公立' )
                    ->groupby('SCH_NAME')  
                    ->orderby('SPpi','asc')
                    ->take(10) 
                    ->get();
        $NUMSQL = DB::select(DB::raw("SET NOCOUNT ON;EXEC dbo.SPEST $nowyear"));

        return view('student.s_suspension',
                      compact('SP_ED_SUM',
                                'STU_SUM',
                                'SYSTEM_TYPE',
                                'SCH_SYS',
                                'College',
                                'STU_SCH',
                                'schoolname',
                                'NUMSQL',
                                'nowyear')
                  );     
   }
   public function dropout(){
        //$schoolname 學校名稱
        $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
        // $nowyear 資料庫最新資料年
        $year= request()->input("year");
        if(is_null($year)){
        $nowyear = DB::Table('DP_SCH')
                     ->where('SCH_NAME','=',$schoolname)
                     ->max("AD_YEAR");
        }else{
          $nowyear=$year;
        }
        // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理
    //退學人數
    $SP_ED_SUM = DB::Table('DP_SCH')
                    ->select(DB::raw("sum(DP_SUM) as sum"))
                    ->where("AD_YEAR",'=',$nowyear)
                    ->where('SCH_NAME','=',$schoolname)
                    ->first();
  //                  
    $STU_SUM = DB::Table('DP_SCH')
                    ->select(DB::raw("sum(STU_SUM) as t"))
                    ->where("AD_YEAR",'=',$nowyear)
                    ->where('SCH_NAME','=',$schoolname)
                    ->first();
    //各部別
    $SYSTEM_TYPE= DB::Table('DP_DEP')
                ->select("DSP_System.SYSTEM_TYPE",
                    DB::raw("sum(DP_DEP.DP_SUM)as DP_SUM")
                         )
                ->join('DSP_System', function ($join) {
                       $join->on('DP_DEP.SCH_SYS','DSP_System.SCH_SYS');
                       $join->on('DP_DEP.DEP_CODE','DSP_System.DEP_CODE');
                       $join->on('DP_DEP.DEP_NAME','DSP_System.DEP_NAME');
                       $join->on('DP_DEP.AD_YEAR','DSP_System.AD_YEAR');
                        })
                        ->where("DP_DEP.AD_YEAR",'=',$nowyear)
                        ->where('SCH_NAME','=',$schoolname)
                        ->groupby('DSP_System.SYSTEM_TYPE')
                        ->groupby('ST_NUM')
                        ->orderby('ST_NUM',"asc")
                        ->get();
    $SYSTEM_TYPE_all= DB::Table('DP_DEP')
                ->select("DSP_System.SYSTEM_TYPE",
                    DB::raw("sum(DP_DEP.STU_SUM)as DP_SUM")
                         )
                ->join('DSP_System', function ($join) {
                       $join->on('DP_DEP.SCH_SYS','DSP_System.SCH_SYS');
                       $join->on('DP_DEP.DEP_CODE','DSP_System.DEP_CODE');
                       $join->on('DP_DEP.DEP_NAME','DSP_System.DEP_NAME');
                       $join->on('DP_DEP.AD_YEAR','DSP_System.AD_YEAR');
                        })
                        ->where("DP_DEP.AD_YEAR",'=',$nowyear)
                        ->where('SCH_NAME','=',$schoolname)
                        ->groupby('DSP_System.SYSTEM_TYPE')
                        ->groupby('ST_NUM')
                        ->orderby('ST_NUM',"asc")
                        ->get();
    //各學制
              $SCH_SYS= DB::Table('DP_DEP')
                        ->select("DSP_System.SCH_SYS",
                                 DB::raw("sum(DP_DEP.DP_SUM)as DP_SUM"),
                                 DB::raw("sum(DP_DEP.DP_SUM)/sum(STU_SUM) as DPpi") 
                                )
                        ->join('DSP_System', function ($join) {
                                $join->on('DP_DEP.SCH_SYS','DSP_System.SCH_SYS');
                                $join->on('DP_DEP.DEP_CODE','DSP_System.DEP_CODE');
                                $join->on('DP_DEP.DEP_NAME','DSP_System.DEP_NAME');
                                $join->on('DP_DEP.AD_YEAR','DSP_System.AD_YEAR');
                        })
                        
                        ->where("DP_DEP.AD_YEAR",'=',$nowyear)
                        ->where('SCH_NAME','=',$schoolname)
                        ->groupby('DSP_System.SCH_SYS')
                        ->groupby('SS_NUM')
                        ->orderby('SS_NUM',"asc")
                        ->get();
  //各學院
            $College= DB::Table('DP_DEP')
                        ->select("DSP_System.COL",
                                 DB::raw("sum(DP_DEP.DP_SUM)as DP_SUM"),
                                 DB::raw("sum(DP_DEP.DP_SUM)/sum(STU_SUM) as DPpi")
                                 
                                )
                        ->join('DSP_System', function ($join) {
                                $join->on('DP_DEP.SCH_SYS','DSP_System.SCH_SYS');
                                $join->on('DP_DEP.DEP_CODE','DSP_System.DEP_CODE');
                                $join->on('DP_DEP.DEP_NAME','DSP_System.DEP_NAME');
                                $join->on('DP_DEP.AD_YEAR','DSP_System.AD_YEAR');
                        })
                        
                        ->where("DP_DEP.AD_YEAR",'=',$nowyear)
                        ->where('SCH_NAME','=',$schoolname)
                        ->groupby('DSP_System.COL')
                        ->groupby('COL_NUM')
                        ->orderby('COL_NUM','asc')
                        ->get();
//前十
            $STU_SCH=DB::Table('DP_DEP')
                       ->select("SCH_NAME",
                                DB::raw("sum(STU_SUM)/2 as STU_SUM"),
                                DB::raw("sum(DP_SUM) as SP_SUM"),
                                DB::raw("cast(round(sum(DP_SUM)/(sum(STU_SUM)/2),3) as numeric(10,3)) as DPpi")
                                        )
                                 ->where("AD_YEAR",'=',$nowyear)
                                 ->where("PUB_OR_PRI",'公立' )
                                 ->groupby('SCH_NAME')  
                                 ->orderby('DPpi','asc')
                                 ->get();
 //預存
            $NUMSQL = DB::select(DB::raw("SET NOCOUNT ON;EXEC dbo.DP $nowyear"));                        
        return view('student.s_dropout',
            compact('SP_ED_SUM',
                    'STU_SUM',
                    'SYSTEM_TYPE',
                    'SYSTEM_TYPE_all',
                    'SCH_SYS',
                    'College',
                    'STU_SCH',
                    'schoolname',
                    'NUMSQL',
                    'nowyear'
                        ));
    }
    //休學院
        function s_suspension_college(){
        $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
        $year= request()->input("year");
        if(is_null($year)){
        $nowyear = DB::Table('SP_SCH_NEW')
                     ->where('SCH_NAME','=',$schoolname)
                     ->max("AD_YEAR");
        }else{
          $nowyear=$year;
        }
        // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理

        $College= DB::Table('SP_DEP_NEW')
                        ->select("DSP_System.COL",
                                 DB::raw("sum(STU_SUM) as STU_SUM"),
                                 DB::raw("sum(SP_ED_SUM) as SP_SUM"),
                                 DB::raw("sum(SP_ED_SUM)/(sum(STU_SUM)) as SPpi")
                                )
                        ->join('DSP_System', function ($join) {
                                $join->on('SP_DEP_NEW.SCH_SYS','DSP_System.SCH_SYS');
                                $join->on('SP_DEP_NEW.DEP_CODE','DSP_System.DEP_CODE');
                                $join->on('SP_DEP_NEW.DEP_NAME','DSP_System.DEP_NAME');
                                $join->on('SP_DEP_NEW.AD_YEAR','DSP_System.AD_YEAR');
                        })
                        ->where("SP_DEP_NEW.AD_YEAR",'=',$nowyear)
                        ->where('SCH_NAME','=',$schoolname)
                        ->groupby('DSP_System.COL')
                        ->groupby('DSP_System.COL_NUM')
                        ->orderby('DSP_System.COL_NUM')
                        ->get();
        $colrow= DB::Table('DSP_System')
                  ->SELECT('COL','COL_COLOR','COL_NUM')
                  ->where("AD_YEAR",'=',$nowyear)
                  ->groupby('COL_NUM')
                  ->groupby('COL')
                  ->groupby('COL_COLOR')
                  ->get();
                        
        return view('student.s_suspension_college',compact('College','colrow','nowyear'));
    }
    //休學院Api
    function s_suspension_college_Api(){
        $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0]; 
        $nowyear = request()->input("year");    
        $college = request()->input("College");
        $College = DB::Table('SP_DEP_NEW')
                      ->select(
                           DB::raw("sum(STU_SUM) as STU_SUM"),
                           DB::raw("sum(SP_ED_SUM) as SP_SUM"),
                           DB::raw("sum(SP_ED_SUM)/(sum(STU_SUM)) as SPpi")
                           )
                      ->leftjoin('DSP_System',function ($join) {
                          $join->on('SP_DEP_NEW.DEP_CODE','DSP_System.DEP_CODE');
                          $join->on('SP_DEP_NEW.AD_YEAR','DSP_System.AD_YEAR');
                          $join->on('SP_DEP_NEW.SCH_SYS','DSP_System.SCH_SYS');
                          $join->on('SP_DEP_NEW.DEP_NAME','DSP_System.DEP_NAME');
                      })
                      
                      ->where('SP_DEP_NEW.AD_YEAR','=',$nowyear)
                      ->where('SCH_NAME','=',$schoolname)
                      ->where('COL','=',$college)
                      ->get();
      $Department = DB::Table('SP_DEP_NEW')
                      ->select('DSP_System.SYSTEM_TYPE',
                        DB::raw("sum(STU_SUM) as STU_SUM"),
                        DB::raw("sum(SP_ED_SUM) as SP_SUM"),
                        DB::raw("sum(SP_ED_SUM)/sum(STU_SUM) as SPpi")
                              )
                      ->leftjoin('DSP_System',function ($join) {
                          $join->on('SP_DEP_NEW.DEP_CODE','DSP_System.DEP_CODE');
                          $join->on('SP_DEP_NEW.AD_YEAR','DSP_System.AD_YEAR');
                          $join->on('SP_DEP_NEW.SCH_SYS','DSP_System.SCH_SYS');
                          $join->on('SP_DEP_NEW.DEP_NAME','DSP_System.DEP_NAME');
                      })
                      ->where('SP_DEP_NEW.AD_YEAR','=',$nowyear)
                      ->where('SCH_NAME','=',$schoolname)
                      ->where('DSP_System.COL','=',$college)
                      ->groupby('DSP_System.SYSTEM_TYPE')
                      
                      ->get();
      

   return response()->json(['College' => $College,'Department'=>$Department ],Response::HTTP_OK);
   }
function s_suspension_college_Api2(){
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0]; 
      $nowyear = request()->input("year");      
      $college = request()->input("College");
      $SCH_SYS= DB::Table('SP_DEP_NEW')
                ->select("SP_DEP_NEW.SCH_SYS",
                   DB::raw("sum(STU_SUM) as STU_SUM"),
                  DB::raw("sum(SP_ED_SUM) as SP_SUM"),
                  DB::raw("sum(SP_ED_SUM)/(sum(STU_SUM)) as SPpi")
                                )
                        ->join('DSP_System', function ($join) {
                                $join->on('SP_DEP_NEW.SCH_SYS','DSP_System.SCH_SYS');
                                $join->on('SP_DEP_NEW.DEP_CODE','DSP_System.DEP_CODE');
                                $join->on('SP_DEP_NEW.DEP_NAME','DSP_System.DEP_NAME');
                                $join->on('SP_DEP_NEW.AD_YEAR','DSP_System.AD_YEAR');
                        })
                        
                        ->where("SP_DEP_NEW.AD_YEAR",'=',$nowyear)
                        ->where('SCH_NAME','=',$schoolname)
                        ->where('DSP_System.COL','=',$college)
                        ->groupby('SP_DEP_NEW.SCH_SYS')
                        ->groupby('SS_NUM')
                        ->orderby('SS_NUM')
                        ->get();
return response()->json(['SCH_SYS'=>$SCH_SYS],Response::HTTP_OK);
 }  
//修學院學生休學人數api2
     function s_suspension_college_Api3()
    {//
         
       $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
       $nowyear = request()->input("year");
        $college = request()->input("College");
              $sp=  DB::Table('SP_DEP_NEW')
                    ->select("DEP_SIMPLE",

                              DB::raw("sum(SP_ED_SUM) as SP_SUM"),
                              DB::raw("sum(STU_SUM) as STU_SUM")
                            
                                    )
                            ->join('DSP_System', function ($join) {
                                    $join->on('SP_DEP_NEW.SCH_SYS','DSP_System.SCH_SYS');
                                    $join->on('SP_DEP_NEW.DEP_CODE','DSP_System.DEP_CODE');
                                    $join->on('SP_DEP_NEW.DEP_NAME','DSP_System.DEP_NAME');
                                    $join->on('SP_DEP_NEW.AD_YEAR','DSP_System.AD_YEAR');
                            })
                            ->where("SP_DEP_NEW.AD_YEAR",'=',$nowyear)
                            ->where('SCH_NAME','=',$schoolname)
                            ->where('DSP_System.COL','=',$college)
                            ->groupby('DEP_SIMPLE')
                            ->get();
             return response()->json(['sp' => $sp,],Response::HTTP_OK);
         }

         //修學院休學原因api3
     function s_suspension_college_Api4()
    {
       $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
       $nowyear = request()->input("year");
        $college = request()->input("College");
        $col= DB::Table('SP_DEP_NEW')
                        ->select(
                                 
                                 DB::raw("sum(SP_ED_SUM) as SP_SUM"),
                                )
                        ->join('DSP_System', function ($join) {
                                $join->on('SP_DEP_NEW.SCH_SYS','DSP_System.SCH_SYS');
                                $join->on('SP_DEP_NEW.DEP_CODE','DSP_System.DEP_CODE');
                                $join->on('SP_DEP_NEW.DEP_NAME','DSP_System.DEP_NAME');
                                $join->on('SP_DEP_NEW.AD_YEAR','DSP_System.AD_YEAR');
                        })
                        ->where("SP_DEP_NEW.AD_YEAR",'=',$nowyear)
                        ->where('SCH_NAME','=',$schoolname)
                        ->where('COL',$college)
                        ->get();
              $sp=  DB::Table('SP_DEP_NEW')
                    ->select("DEP_SIMPLE",
                              
                              DB::raw("sum(SP_ED_SICK) as SP_ED_SICK"),
                              DB::raw("sum(SP_ED_MONEY) as SP_ED_MONEY"),
                              DB::raw("sum(SP_ED_SCORE) as SP_ED_SCORE"),
                              DB::raw("sum(SP_ED_INTERESTS) as SP_ED_INTERESTS"),
                              DB::raw("sum(SP_ED_WORK) as SP_ED_WORK"),
                              DB::raw("sum(SP_ED_PREGNANT) as  SP_ED_PREGNANT"),
                              DB::raw("sum(SP_ED_BABY) as SP_ED_BABY") ,
                              DB::raw("sum(SP_ED_MILITARY) as SP_ED_MILITARY"),
                              DB::raw("sum(SP_ED_TRAVEL) as SP_ED_TRAVEL"),
                              DB::raw("sum(SP_ED_PAPER) as SP_ED_PAPER"),
                              DB::raw("sum(SP_ED_MALADAPTIVE) as SP_ED_MALADAPTIVE"),
                              DB::raw("sum(SP_ED_FAMILY) as SP_ED_FAMILY"),
                              DB::raw("sum(SP_ED_EXAM) as SP_ED_EXAM"),
                              DB::raw("sum(SP_ED_OTHER) as SP_ED_OTHER"),
                              
                          
                               )
                            ->join('DSP_System', function ($join) {
                                    $join->on('SP_DEP_NEW.SCH_SYS','DSP_System.SCH_SYS');
                                    $join->on('SP_DEP_NEW.DEP_CODE','DSP_System.DEP_CODE');
                                    $join->on('SP_DEP_NEW.DEP_NAME','DSP_System.DEP_NAME');
                                    $join->on('SP_DEP_NEW.AD_YEAR','DSP_System.AD_YEAR');
                            })
                            ->where("SP_DEP_NEW.AD_YEAR",'=',$nowyear)
                            ->where('SCH_NAME','=',$schoolname)
                            ->where('DSP_System.COL','=',$college)
                            ->groupby('DEP_SIMPLE')
                            ->get();
             return response()->json(['sp' => $sp,'col'=>$col],Response::HTTP_OK);
    }

    function s_suspension_college_Api5()
    {
       $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
       $nowyear = request()->input("year");
        $college = request()->input("College");
              $sp=  DB::Table('SP_DEP_NEW')
                    ->select("DEP_SIMPLE",
                              DB::raw("sum(SP_ED_SUM) as SP_SUM"),
                              DB::raw("sum(SP_ED_SICK) as SP_ED_SICK"),
                              DB::raw("sum(SP_ED_MONEY) as SP_ED_MONEY"),
                              DB::raw("sum(SP_ED_SCORE) as SP_ED_SCORE"),
                              DB::raw("sum(SP_ED_INTERESTS) as SP_ED_INTERESTS"),
                              DB::raw("sum(SP_ED_WORK) as SP_ED_WORK"),
                              DB::raw("sum(SP_ED_PREGNANT) as  SP_ED_PREGNANT"),
                              DB::raw("sum(SP_ED_BABY) as SP_ED_BABY") ,
                              DB::raw("sum(SP_ED_MILITARY) as SP_ED_MILITARY"),
                              DB::raw("sum(SP_ED_TRAVEL) as SP_ED_TRAVEL"),
                              DB::raw("sum(SP_ED_PAPER) as SP_ED_PAPER"),
                              DB::raw("sum(SP_ED_MALADAPTIVE) as SP_ED_MALADAPTIVE"),
                              DB::raw("sum(SP_ED_FAMILY) as SP_ED_FAMILY"),
                              DB::raw("sum(SP_ED_EXAM) as SP_ED_EXAM"),
                              DB::raw("sum(SP_ED_OTHER) as SP_ED_OTHER"),
                              DB::raw("sum(SP_ED_SUM) as SP_SUM"),
                              DB::raw("sum(STU_SUM) as STU_SUM")
                               )
                            ->join('DSP_System', function ($join) {
                                    $join->on('SP_DEP_NEW.SCH_SYS','DSP_System.SCH_SYS');
                                    $join->on('SP_DEP_NEW.DEP_CODE','DSP_System.DEP_CODE');
                                    $join->on('SP_DEP_NEW.DEP_NAME','DSP_System.DEP_NAME');
                                    $join->on('SP_DEP_NEW.AD_YEAR','DSP_System.AD_YEAR');
                            })
                            ->where("SP_DEP_NEW.AD_YEAR",'=',$nowyear)
                            ->where('SCH_NAME','=',$schoolname)
                            ->where('DSP_System.COL','=',$college)
                            ->groupby('DEP_SIMPLE')
                            ->get();
             return response()->json(['sp' => $sp,],Response::HTTP_OK);
    }

    //測試
     function s_suspension_college_Api6()
    {
       $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
       $nowyear = request()->input("year");
        $college = request()->input("College");
              $sp=  DB::Table('SP_DEP_NEW')
                    ->select("COL",
                              DB::raw("sum(SP_ED_SUM) as SP_SUM"),
                              DB::raw("sum(SP_ED_SICK) as SP_ED_SICK"),
                              DB::raw("sum(SP_ED_MONEY) as SP_ED_MONEY"),
                              DB::raw("sum(SP_ED_SCORE) as SP_ED_SCORE"),
                              DB::raw("sum(SP_ED_INTERESTS) as SP_ED_INTERESTS"),
                              DB::raw("sum(SP_ED_WORK) as SP_ED_WORK"),
                              DB::raw("sum(SP_ED_PREGNANT) as  SP_ED_PREGNANT"),
                              DB::raw("sum(SP_ED_BABY) as SP_ED_BABY") ,
                              DB::raw("sum(SP_ED_MILITARY) as SP_ED_MILITARY"),
                              DB::raw("sum(SP_ED_TRAVEL) as SP_ED_TRAVEL"),
                              DB::raw("sum(SP_ED_PAPER) as SP_ED_PAPER"),
                              DB::raw("sum(SP_ED_MALADAPTIVE) as SP_ED_MALADAPTIVE"),
                              DB::raw("sum(SP_ED_FAMILY) as SP_ED_FAMILY"),
                              DB::raw("sum(SP_ED_EXAM) as SP_ED_EXAM"),
                              DB::raw("sum(SP_ED_OTHER) as SP_ED_OTHER"),
                              DB::raw("sum(SP_ED_SUM) as SP_SUM"),
                              DB::raw("sum(STU_SUM) as STU_SUM")
                               )
                            ->join('DSP_System', function ($join) {
                                    $join->on('SP_DEP_NEW.SCH_SYS','DSP_System.SCH_SYS');
                                    $join->on('SP_DEP_NEW.DEP_CODE','DSP_System.DEP_CODE');
                                    $join->on('SP_DEP_NEW.DEP_NAME','DSP_System.DEP_NAME');
                                    $join->on('SP_DEP_NEW.AD_YEAR','DSP_System.AD_YEAR');
                            })
                            ->where("SP_DEP_NEW.AD_YEAR",'=',$nowyear)
                            ->where('SCH_NAME','=',$schoolname)
                            ->where('DSP_System.COL','=',$college)
                            ->groupby('COL')
                            ->get();
             return response()->json(['sp' => $sp,],Response::HTTP_OK);
      }
//退學院
function s_dropout_college(){
        $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
        $year= request()->input("year");
        if(is_null($year)){
        $nowyear = DB::Table('DP_DEP')
                     ->where('SCH_NAME','=',$schoolname)
                     ->max("AD_YEAR");
        }else{
          $nowyear=$year;
        }
        // ✅ 移除菜單查詢：現已由 MenuComposer 統一處理

        $College= DB::Table('DP_DEP')
                        ->select("DSP_System.COL",
                                 DB::raw("sum(STU_SUM)/2 as STU_SUM"),
                                 DB::raw("sum(DP_SUM) as DP_SUM"),
                                 DB::raw("cast(round(sum(DP_SUM)/sum(STU_SUM),3) as numeric(10,3)) as DPpi")
                                )
                        ->join('DSP_System', function ($join) {
                                $join->on('DP_DEP.SCH_SYS','DSP_System.SCH_SYS');
                                $join->on('DP_DEP.DEP_CODE','DSP_System.DEP_CODE');
                                $join->on('DP_DEP.DEP_NAME','DSP_System.DEP_NAME');
                                $join->on('DP_DEP.AD_YEAR','DSP_System.AD_YEAR');
                        })
                        ->where("DP_DEP.AD_YEAR",'=',$nowyear)
                        ->where('SCH_NAME','=',$schoolname)
                        ->groupby('DSP_System.COL')
                        ->groupby('DSP_System.COL_NUM')
                        ->orderby('DSP_System.COL_NUM')
                        ->get();
        $colrow= DB::Table('DSP_System')
                  ->SELECT('COL','COL_COLOR','COL_NUM')
                  ->where("AD_YEAR",'=',$nowyear)
                  ->groupby('COL_NUM')
                  ->groupby('COL')
                  ->groupby('COL_COLOR')
                  
                  ->get();
        return view('student.s_dropout_college',compact('colrow','College','nowyear'));
    }
    //退學院api
    function s_dropout_college_Api(){
        
        $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0]; 
        $nowyear = request()->input("year");
        $college = request()->input("College");
        $College = DB::Table('DP_DEP')
                      ->leftjoin('DSP_System',function ($join) {
                          $join->on('DP_DEP.DEP_CODE','DSP_System.DEP_CODE');
                          $join->on('DP_DEP.AD_YEAR','DSP_System.AD_YEAR');
                          $join->on('DP_DEP.SCH_SYS','DSP_System.SCH_SYS');
                          $join->on('DP_DEP.DEP_NAME','DSP_System.DEP_NAME');
                      })
                      ->select(DB::raw("sum(STU_SUM/2) as STU_SUM"),
                               DB::raw("sum(DP_SUM) as DP_SUM"),
                               DB::raw("sum(DP_SUM)/sum(STU_SUM/2) as DPpi")
                               )
                      ->where('DP_DEP.AD_YEAR','=',$nowyear)
                      ->where('SCH_NAME','=',$schoolname)
                      ->where('COL','=',$college)
                      ->get();
      $Department = DB::Table('DP_DEP')
                      ->leftjoin('DSP_System',function ($join) {
                          $join->on('DP_DEP.DEP_CODE','DSP_System.DEP_CODE');
                          $join->on('DP_DEP.AD_YEAR','DSP_System.AD_YEAR');
                          $join->on('DP_DEP.SCH_SYS','DSP_System.SCH_SYS');
                          $join->on('DP_DEP.DEP_NAME','DSP_System.DEP_NAME');
                      })
                      ->select('DSP_System.SYSTEM_TYPE',
                        DB::raw("sum(DP_SUM) as DP_SUM"),
                        DB::raw("sum(STU_SUM/2) as STU_SUM"),
                        DB::raw("sum(DP_SUM)/sum(STU_SUM/2) as DPpi"))
                      ->where('DP_DEP.AD_YEAR','=',$nowyear)
                      ->where('SCH_NAME','=',$schoolname)
                      ->where('DSP_System.COL','=',$college)
                      ->groupby('DSP_System.SYSTEM_TYPE')
                      ->get();
      
        
   return response()->json(['College' => $College,'Department'=>$Department ],Response::HTTP_OK);
   }
   //退學院ap2
   function s_dropout_college_Api2()
    {
       $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
       $nowyear = request()->input("year");
         
        $college = request()->input("College");
                 $SCH_SYS= DB::Table('DP_DEP')
                ->select("DP_DEP.SCH_SYS",
                           DB::raw("sum(DP_SUM) as DP_SUM"),
                           DB::raw("sum(STU_SUM/2) as STU_SUM"),
                           DB::raw("sum(DP_SUM)/sum(STU_SUM/2) as DPpi")
                                )
                        ->join('DSP_System', function ($join) {
                                $join->on('DP_DEP.SCH_SYS','DSP_System.SCH_SYS');
                                $join->on('DP_DEP.DEP_CODE','DSP_System.DEP_CODE');
                                $join->on('DP_DEP.DEP_NAME','DSP_System.DEP_NAME');
                                $join->on('DP_DEP.AD_YEAR','DSP_System.AD_YEAR');
                        })
                        
                        ->where("DP_DEP.AD_YEAR",'=',$nowyear)
                        ->where('SCH_NAME','=',$schoolname)
                        ->where('DSP_System.COL','=',$college)
                        ->groupby('DP_DEP.SCH_SYS')
                        ->groupby('SS_NUM')
                        ->orderby('SS_NUM')
                        ->get();
             return response()->json(['SCH_SYS'=>$SCH_SYS],Response::HTTP_OK);
         }

          function s_dropout_college_Api3()
    {
       $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0];
       $nowyear = request()->input("year");
        
        $college = request()->input("College");
              
              $dp=  DB::Table('DP_DEP')
                    ->select("DEP_SIMPLE",

                              DB::raw("sum(DP_SUM) as DP_SUM"),
                              DB::raw("sum(STU_SUM/2) as STU_SUM")
                            
                                    )
                            ->join('DSP_System', function ($join) {
                                    $join->on('DP_DEP.SCH_SYS','DSP_System.SCH_SYS');
                                    $join->on('DP_DEP.DEP_CODE','DSP_System.DEP_CODE');
                                    $join->on('DP_DEP.DEP_NAME','DSP_System.DEP_NAME');
                                    $join->on('DP_DEP.AD_YEAR','DSP_System.AD_YEAR');
                            })
                            ->where("DP_DEP.AD_YEAR",'=',$nowyear)
                            ->where('SCH_NAME','=',$schoolname)
                            ->where('DSP_System.COL','=',$college)
                            ->groupby('DEP_SIMPLE')
                            ->get();
             return response()->json(['dp'=>$dp],Response::HTTP_OK);
         }

        function s_dropout_college_Api4()
    {
       $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
      $schoolname = $schoolname[0]; 
       $nowyear = request()->input("year");
       
        $college = request()->input("College");
               $COL=  DB::Table('DP_DEP')
                    ->select("COL",
                              DB::raw("sum(DP_SUM) as DP_SUM"),
                              DB::raw("sum(DP_SCORE) as DP_SCORE"),
                              DB::raw("sum(DP_CONDUCT) as DP_CONDUCT"),
                              DB::raw("sum(DP_INTERESTS) as DP_INTERESTS"),
                              DB::raw("sum(DP_OVEFDUE) as DP_OVEFDUE"),
                              DB::raw("sum(DP_NORETURN) as DP_NORETURN"),
                              DB::raw("sum(DP_PREGNANT) as  DP_PREGNANT"),
                              DB::raw("sum(DP_BABY) as DP_BABY") ,
                              DB::raw("sum(DP_SICK) as DP_SICK"),
                              DB::raw("sum(DP_WORK) as DP_WORK"),
                              DB::raw("sum(DP_MONEY) as DP_MONEY"),
                              DB::raw("sum(DP_PLAN) as DP_PLAN"),
                              DB::raw("sum(DP_OTHER) as DP_OTHER"),
                              DB::raw("sum(STU_SUM/2) as STU_SUM")
                               )
                            ->join('DSP_System', function ($join) {
                                    $join->on('DP_DEP.SCH_SYS','DSP_System.SCH_SYS');
                                    $join->on('DP_DEP.DEP_CODE','DSP_System.DEP_CODE');
                                    $join->on('DP_DEP.DEP_NAME','DSP_System.DEP_NAME');
                                    $join->on('DP_DEP.AD_YEAR','DSP_System.AD_YEAR');
                            })
                            ->where("DP_DEP.AD_YEAR",'=',$nowyear)
                            ->where('SCH_NAME','=',$schoolname)
                            ->where('DSP_System.COL','=',$college)
                            ->groupby('COL')
                            ->get();
             return response()->json(['COL'=>$COL],Response::HTTP_OK);
         }

         function s_dropout_college_Api5()
    {
        $nowyear = request()->input("year");
        $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->pluck('School_Name');
        $schoolname = $schoolname[0]; 
        $college = request()->input("College"); 
        $nowyear = DB::Table('DP_DEP')
                     ->where('SCH_NAME','=',$schoolname)
                     ->max("AD_YEAR");
       
        $college = request()->input("College");
               $DP=  DB::Table('DP_DEP')
                    ->select("DEP_SIMPLE",
                              DB::raw("sum(DP_SUM) as DP_SUM"),
                              DB::raw("sum(DP_SCORE) as DP_SCORE"),
                              DB::raw("sum(DP_CONDUCT) as DP_CONDUCT"),
                              DB::raw("sum(DP_INTERESTS) as DP_INTERESTS"),
                              DB::raw("sum(DP_OVEFDUE) as DP_OVEFDUE"),
                              DB::raw("sum(DP_NORETURN) as DP_NORETURN"),
                              DB::raw("sum(DP_PREGNANT) as  DP_PREGNANT"),
                              DB::raw("sum(DP_BABY) as DP_BABY") ,
                              DB::raw("sum(DP_SICK) as DP_SICK"),
                              DB::raw("sum(DP_WORK) as DP_WORK"),
                              DB::raw("sum(DP_MONEY) as DP_MONEY"),
                              DB::raw("sum(DP_PLAN) as DP_PLAN"),
                              DB::raw("sum(DP_OTHER) as DP_OTHER"),
                              DB::raw("sum(STU_SUM/2) as STU_SUM")
                               )
                            ->join('DSP_System', function ($join) {
                                    $join->on('DP_DEP.SCH_SYS','DSP_System.SCH_SYS');
                                    $join->on('DP_DEP.DEP_CODE','DSP_System.DEP_CODE');
                                    $join->on('DP_DEP.DEP_NAME','DSP_System.DEP_NAME');
                                    $join->on('DP_DEP.AD_YEAR','DSP_System.AD_YEAR');
                            })
                            ->where("DP_DEP.AD_YEAR",'=',$nowyear)
                            ->where('SCH_NAME','=',$schoolname)
                            ->where('DSP_System.COL','=',$college)
                            ->groupby('DEP_SIMPLE')
                            ->get();
             return response()->json(['DP'=>$DP],Response::HTTP_OK);
         }
}

