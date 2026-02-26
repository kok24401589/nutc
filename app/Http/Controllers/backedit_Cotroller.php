<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\Import_College_System;
use App\Imports\Import_STU_SCH;
use App\Imports\Import_STU_DEP;
use App\Imports\Import_DSP_System;
use App\Imports\Import_SP_SCH;
use App\Imports\Import_SP_DEP;
use App\Imports\Import_DP_DEP;
use App\Imports\Import_DP_SCH;
use App\Exports\Export_College_System;
use App\Exports\Export_STU_SCH;
use App\Exports\Export_STU_DEP;
use App\Exports\Export_DSP_System;
use App\Exports\Export_SP_SCH;
use App\Exports\Export_SP_DEP;
use App\Exports\Export_DP_DEP;
use App\Exports\Export_DP_SCH;
use App\Imports\Import_FT_TCH_DEP;
use App\Imports\Import_FT_TCH_SCH;
use App\Imports\Import_PT_TCH_DEP;
USE App\Imports\Import_PT_TCH_SCH;
USE App\Imports\Import_TPR;
use App\Imports\Import_EnrollmentAnalysis;
use App\Imports\Import_Group_Pred;
use App\Imports\Import_source_area;
use App\Imports\Import_Teacher_System;
use App\Imports\Import_Department_GroupBaselines;

use Excel;
use DB;
class backedit_Cotroller extends Controller
{
    public function all(){

      // if(Session::has('name')){
      // }else{
      //      return redirect('/');
      // }
      //資料更新
       $nowyear = DB::Table('College_System')
                     ->max("AD_YEAR");
                     
      // $NUMSQL = DB::select(DB::raw("SET NOCOUNT ON ;EXEC dbo.New_System $nowyear"));
                     // DB::select(DB::raw("SET NOCOUNT ON;EXEC dbo.STEST $nowyear"));

//       DB::select(DB::raw("exec New_System :Param1"),[
//     ':Param1' => $nowyear, 
// ]);
      // DB::select('EXEC New_System ?',['$nowyear']);

        if(request()->has("save"))
          {
              // dd( request()->all() );
              $id = key(request()->input("save"));
              DB::Table('College_System')
                  ->where("id",$id)
                  ->update([
                      "SYSTEM_TYPE" => request()->input("edit_SYSTEM_TYPE"),
                      "College" => request()->input("edit_College"),
                      "DEP_SIMPLE" => request()->input("edit_DEP_SIMPLE"),
                      "DEP_COLOR" => request()->input("edit_DEP_COLOR"),
                      "COL_COLOR" => request()->input("edit_COL_COLOR"),
                      // "COL_ICON" => request()->input("edit_COL_ICON"),
                      // "DEP_ICON" => request()->input("edit_DEP_ICON"),
                      "ST_NUM" => request()->input("edit_ST_NUM"),
                      "SS_NUM" => request()->input("edit_SS_NUM"),
                      "COL_NUM" => request()->input("edit_COL_NUM"),
                      "DEP_LIKE"=>request()->input("edit_DEP_LIKE")
                  ]);
          }
          // 執行預存
        if(request()->has("up"))
          {
            DB::statement(DB::raw("SET NOCOUNT ON;EXEC New_System $nowyear"));
          }

        //所有學制
        $s_system_type = DB::Table('College_System')
                            ->where('AD_YEAR',$nowyear)
                            ->orderby("SYSTEM_TYPE")
                            ->groupby('SYSTEM_TYPE')
                            ->pluck("SYSTEM_TYPE");
        // dd($s_dep_code);

        //所有系所代碼
        $s_dep_code = DB::Table('College_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("DEP_CODE")
                        ->groupby('DEP_CODE')
                        ->pluck("DEP_CODE");
        // dd($s_dep_code);

        $s_college = DB::Table('College_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("College")
                        ->groupby('College')
                        ->pluck("College");
        // dd($s_dep_code);

        //所有系所簡單名稱
        $s_dep_simple = DB::Table('College_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("DEP_SIMPLE")
                        ->groupby('DEP_SIMPLE')
                        ->pluck("DEP_SIMPLE");
        // dd($s_sch_sys);

        //所有學制班別
        $s_sch_sys = DB::Table('College_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("SCH_SYS")
                        ->groupby('SCH_SYS')
                        ->pluck("SCH_SYS");
        // dd($s_sch_sys);

        //所有學制代碼
        $s_st_num = DB::Table('College_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("ST_NUM")
                        ->groupby('ST_NUM')
                        ->pluck("ST_NUM");
        // dd($s_ss_num);

        //所有班別代碼
        $s_ss_num = DB::Table('College_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("SS_NUM")
                        ->groupby('SS_NUM')
                        ->pluck("SS_NUM");
        // dd($s_ss_num);

        //學院代碼
        $s_col_num = DB::Table('College_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("COL_NUM")
                        ->groupby('COL_NUM')
                        ->pluck("COL_NUM");
        // dd($s_ss_num);

        //搜尋
        $search_DEP_CODE = "";
        $search_SCH_SYS = "";
        if(request()->has("search"))
            $search_DEP_CODE = request()->input("search_DEP_CODE");
            $search_SCH_SYS = request()->input("search_SCH_SYS");
        // echo $search_DEP_CODE;

        $null_list = DB::Table('College_System')
                        ->where('AD_YEAR',$nowyear)
                        ->Where(function($query){
                          $query->orwhere('SYSTEM_TYPE')
                                ->orwhere('College')
                                ->orwhere('DEP_SIMPLE')
                                ->orwhere('DEP_COLOR')
                                ->orwhere('COL_COLOR')
                                // ->orwhere('COL_ICON')
                                // ->orwhere('DEP_ICON')
                                ->orwhere('ST_NUM')
                                ->orwhere('SS_NUM')
                                ->orwhere('COL_NUM')
                                ->orwhere('DEP_LIKE');
                        })
                        ->groupby('ID')
                        ->orderby('ID')
                        ->pluck("ID");
        // //dd($null_list);

        $College = DB::Table('College_System AS a')
                    ->orderby('ID')
                    ->where('AD_YEAR',$nowyear)
                    ->where('DEP_CODE',"like",$search_DEP_CODE."%")
                    ->where('SCH_SYS',"like",$search_SCH_SYS."%")
                    ->get();
        // dd($College);
         
        return view('admin.backedit',
                    compact('College',
                            's_system_type',
                            's_dep_code',
                            's_college',
                            's_dep_simple',
                            's_sch_sys',
                            'null_list',
                            's_st_num',
                            's_ss_num',
                            's_col_num'
                            )
                    );
    }
// ------------------------------------------------------

        public function all2(){
      //資料更新
       $nowyear = DB::Table('DSP_System')
                     ->max("AD_YEAR");
                     
      // $NUMSQL = DB::select(DB::raw("SET NOCOUNT ON ;EXEC dbo.New_System $nowyear"));
                     // DB::select(DB::raw("SET NOCOUNT ON;EXEC dbo.STEST $nowyear"));
          // 執行預存
        if(request()->has("up"))
          {
            DB::statement(DB::raw("SET NOCOUNT ON;EXEC New_System2 $nowyear"));
          }
//       DB::select(DB::raw("exec New_System :Param1"),[
//     ':Param1' => $nowyear, 
// ]);
      // DB::select('EXEC New_System ?',['$nowyear']);
        if(request()->has("save"))
          {
              // dd( request()->all() );
              $id = key(request()->input("save"));
              DB::Table('DSP_System')
                  ->where("id",$id)
                  ->update([
                      "SYSTEM_TYPE" => request()->input("edit_SYSTEM_TYPE"),
                      "COL" => request()->input("edit_College"),
                      "DEP_SIMPLE" => request()->input("edit_DEP_SIMPLE"),
                      "DEP_COLOR" => request()->input("edit_DEP_COLOR"),
                      "COL_COLOR" => request()->input("edit_COL_COLOR"),
                      // "COL_ICON" => request()->input("edit_COL_ICON"),
                      // "DEP_ICON" => request()->input("edit_DEP_ICON"),
                      "ST_NUM" => request()->input("edit_ST_NUM"),
                      "SS_NUM" => request()->input("edit_SS_NUM"),
                      "COL_NUM" => request()->input("edit_COL_NUM")
                  ]);
          }
        

        //所有學制
        $s_system_type = DB::Table('DSP_System')
                            ->where('AD_YEAR',$nowyear)
                            ->orderby("SYSTEM_TYPE")
                            ->groupby('SYSTEM_TYPE')
                            ->pluck("SYSTEM_TYPE");
        // dd($s_dep_code);

        //所有系所代碼
        $s_dep_code = DB::Table('DSP_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("DEP_CODE")
                        ->groupby('DEP_CODE')
                        ->pluck("DEP_CODE");
        // dd($s_dep_code);

        $s_college = DB::Table('DSP_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("COL")
                        ->groupby('COL')
                        ->pluck("COL");
        // dd($s_dep_code);

        //所有系所簡單名稱
        $s_dep_simple = DB::Table('DSP_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("DEP_SIMPLE")
                        ->groupby('DEP_SIMPLE')
                        ->pluck("DEP_SIMPLE");
        // dd($s_sch_sys);

        //所有學制班別
        $s_sch_sys = DB::Table('DSP_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("SCH_SYS")
                        ->groupby('SCH_SYS')
                        ->pluck("SCH_SYS");
        // dd($s_sch_sys);

        //所有學制代碼
        $s_st_num = DB::Table('DSP_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("ST_NUM")
                        ->groupby('ST_NUM')
                        ->pluck("ST_NUM");
        // dd($s_ss_num);

        //所有班別代碼
        $s_ss_num = DB::Table('DSP_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("SS_NUM")
                        ->groupby('SS_NUM')
                        ->pluck("SS_NUM");
        // dd($s_ss_num);

        //學院代碼
        $s_col_num = DB::Table('DSP_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("COL_NUM")
                        ->groupby('COL_NUM')
                        ->pluck("COL_NUM");
        // dd($s_ss_num);

        //搜尋
        $search_DEP_CODE = "";
        $search_SCH_SYS = "";
        if(request()->has("search"))
            $search_DEP_CODE = request()->input("search_DEP_CODE");
            $search_SCH_SYS = request()->input("search_SCH_SYS");
        // echo $search_DEP_CODE;

        $null_list = DB::Table('DSP_System')
                        ->where('AD_YEAR',$nowyear)
                        ->Where(function($query){
                          $query->orwhere('SYSTEM_TYPE')
                                ->orwhere('COL')
                                ->orwhere('DEP_SIMPLE')
                                ->orwhere('DEP_COLOR')
                                ->orwhere('COL_COLOR')
                                // ->orwhere('COL_ICON')
                                // ->orwhere('DEP_ICON')
                                ->orwhere('ST_NUM')
                                ->orwhere('SS_NUM')
                                ->orwhere('COL_NUM');
                        })
                        ->groupby('ID')
                        ->orderby('ID')
                        ->pluck("ID");
        // //dd($null_list);

        $College = DB::Table('DSP_System AS a')
                    ->orderby('ID')
                    ->where('AD_YEAR',$nowyear)
                    ->where('DEP_CODE',"like",$search_DEP_CODE."%")
                    ->where('SCH_SYS',"like",$search_SCH_SYS."%")
                    ->get();
        // dd($College);
         
        return view('admin.backedit2',
                    compact('College',
                            's_system_type',
                            's_dep_code',
                            's_college',
                            's_dep_simple',
                            's_sch_sys',
                            'null_list',
                            's_st_num',
                            's_ss_num',
                            's_col_num'
                            )
                    );
    }
//---------------------------------------------------------------------------

public function all3(){

      // if(Session::has('name')){
      // }else{
      //      return redirect('/');
      // }
      //資料更新
       $nowyear = DB::Table('Teacher_System')
                     ->max("AD_YEAR");
                     
      // $NUMSQL = DB::select(DB::raw("SET NOCOUNT ON ;EXEC dbo.New_System $nowyear"));
                     // DB::select(DB::raw("SET NOCOUNT ON;EXEC dbo.STEST $nowyear"));

//       DB::select(DB::raw("exec New_System :Param1"),[
//     ':Param1' => $nowyear, 
// ]);
      // DB::select('EXEC New_System ?',['$nowyear']);

        if(request()->has("save"))
          {
              // dd( request()->all() );
              $id = key(request()->input("save"));
              DB::Table('Teacher_System')
                  ->where("id",$id)
                  ->update([
                      "department" => request()->input("edit_department"),
                      "department_simple" => request()->input("edit_department_simple"),
                      "college" => request()->input("edit_college"),
                      "Collegecode" => request()->input("edit_Collegecode")
                  ]);
          }
          // 執行預存
        if(request()->has("up"))
          {
            DB::statement(DB::raw("SET NOCOUNT ON;EXEC New_System3 $nowyear"));
          }

        //所有系所代碼
        $t_dep_code = DB::Table('Teacher_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("department_code")
                        ->groupby('department_code')
                        ->pluck("department_code");
        // dd($t_dep_code);

        //所有系所名稱
        $t_department = DB::Table('Teacher_System')
                          ->where('AD_YEAR',$nowyear)
                          ->orderby("department")
                          ->groupby('department')
                          ->pluck("department");
        // dd($t_department);

        //所有系所簡單名稱
        $t_dep_simple = DB::Table('Teacher_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("department_simple")
                        ->groupby('department_simple')
                        ->pluck("department_simple");
        // dd($t_dep_simple);

        //所有學院
        $t_college = DB::Table('Teacher_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("college")
                        ->groupby('college')
                        ->pluck("college");
        // dd($t_college);

        //所有學院代碼
        $t_collegecode = DB::Table('Teacher_System')
                        ->where('AD_YEAR',$nowyear)
                        ->orderby("Collegecode")
                        ->groupby('Collegecode')
                        ->pluck("Collegecode");
        // dd($t_collegecode);


        //搜尋
        $search_DEP_CODE = "";
        // $search_SCH_SYS = "";
        if(request()->has("search"))
            $search_DEP_CODE = request()->input("search_DEP_CODE");
            // $search_SCH_SYS = request()->input("search_SCH_SYS");
        // echo $search_DEP_CODE;

        $null_list = DB::Table('Teacher_System')
                        ->where('AD_YEAR',$nowyear)
                        ->Where(function($query){
                          $query->orwhere('department')
                                ->orwhere('department_simple')
                                ->orwhere('college')
                                ->orwhere('Collegecode');
                        })
                        ->groupby('ID')
                        ->orderby('ID')
                        ->pluck("ID");
        // dd($null_list);

        $College = DB::Table('Teacher_System AS a')
                    ->orderby('ID')
                    ->where('AD_YEAR',$nowyear)
                    ->where('department_code',"like",$search_DEP_CODE."%")
                    // ->where('SCH_SYS',"like",$search_SCH_SYS."%")
                    ->get();
        // dd($College);
         
        return view('admin.backedit3',
                    compact('College',
                            't_dep_code',
                            't_department',
                            't_dep_simple',
                            't_college',
                            't_collegecode',
                            'null_list'
                            )
                    );
    }
    //-----------------------檔案上傳----------------------------------------
    public function College_System_all(){
      $nowyear = DB::Table('College_System')
                     ->max("AD_YEAR");
      $all = DB::table('College_System')
            ->where('AD_YEAR','=',$nowyear)
            ->orderby('AD_YEAR')
            ->get();
      return view('admin.all.College_System_all',compact('all'));
    }
    public function College_System_from(Request $request){

      Excel::import(new Import_College_System,$request->file);
      
      return redirect('/College_System_all');
    }
    //--STU_SCH---------------------------------------------------------------
    public function STU_SCH_all(){
      $nowyear = DB::Table('STU_SCH')
                     ->max("AD_YEAR");
      $all = DB::table('STU_SCH')
            ->where('AD_YEAR','=',$nowyear)
            ->orderby('AD_YEAR')
            ->get();
      return view('admin.all.STU_SCH_all',compact('all'));
    }
    public function STU_SCH_from(Request $request){
      Excel::import(new Import_STU_SCH,$request->file);
      return redirect('/STU_SCH_all');
    }
    //--STU_DEP------------------------------------------------------------------
    public function STU_DEP_all(){
      $nowyear = DB::Table('STU_DEP')
                     ->max("AD_YEAR");
      $all = DB::table('STU_DEP')
            ->where('AD_YEAR','=',$nowyear)
            ->orderby('AD_YEAR')
            ->get();
      return view('admin.all.STU_DEP_all',compact('all'));
    }
    public function STU_DEP_from(Request $request){
      Excel::import(new Import_STU_DEP,$request->file);
      return redirect('/STU_DEP_all');
    }
//--DSP_System---------------------------------------------------------------------
    public function DSP_System_all(){
      $nowyear = DB::Table('DSP_System')
                     ->max("AD_YEAR");
      $all = DB::table('DSP_System')
            ->where('AD_YEAR','=',$nowyear)
            ->orderby('AD_YEAR')
            ->get();
      return view('admin.all.DSP_System_all',compact('all'));
    }
    public function DSP_System_from(Request $request){
      Excel::import(new Import_DSP_System,$request->file);
      return redirect('/DSP_System_all');
    }
//SP_SCH----------------------------------------------------------------------------
    public function SP_SCH_all(){
      $nowyear = DB::Table('SP_SCH_NEW')
                     ->max("AD_YEAR");
      $all = DB::table('SP_SCH_NEW')
            ->where('AD_YEAR','=',$nowyear)
            ->orderby('AD_YEAR')
            ->get();
      return view('admin.all.SP_SCH_all',compact('all'));
    }
    public function SP_SCH_from(Request $request){
      Excel::import(new Import_SP_SCH,$request->file);
      return redirect('/SP_SCH_all');
    }
//SP_DEP-----------------------------------------------------------------------------
    public function SP_DEP_all(){
      $nowyear = DB::Table('SP_DEP_NEW')
                     ->max("AD_YEAR");
      $all = DB::table('SP_DEP_NEW')
            ->where('AD_YEAR','=',$nowyear)
            ->orderby('AD_YEAR')
            ->get();
      return view('admin.all.SP_DEP_all',compact('all'));
    }
    public function SP_DEP_from(Request $request){
      Excel::import(new Import_SP_DEP,$request->file);
      return redirect('/SP_DEP_all');
    }
//DP_DEP-----------------------------------------------------------------------------
    public function DP_DEP_all(){
      $nowyear = DB::Table('DP_DEP')
                     ->max("AD_YEAR");
      $all = DB::table('DP_DEP')
            ->where('AD_YEAR','=',$nowyear)
            ->orderby('AD_YEAR')
            ->get();
      return view('admin.all.DP_DEP_all',compact('all'));
    }
    public function DP_DEP_from(Request $request){
      Excel::import(new Import_DP_DEP,$request->file);

      return redirect('/DP_DEP_all');
    }
//DP_SCH-----------------------------------------------------------------------------
    public function DP_SCH_all(){
      $nowyear = DB::Table('DP_SCH')
                     ->max("AD_YEAR");
      $all = DB::table('DP_SCH')
            ->where('AD_YEAR','=',$nowyear)
            ->orderby('AD_YEAR')
            ->get();
      return view('admin.all.DP_SCH_all',compact('all'));
    }
    public function DP_SCH_from(Request $request){
      Excel::import(new Import_DP_SCH,$request->file);
      return redirect('/DP_SCH_all');
    }

//FT_TCH_DEP-----------------------------------------------------------------------------
    public function FT_TCH_DEP_all(){
      $nowyear = DB::Table('FT_TCH_DEP')
                     ->max("AD_YEAR");
      $all = DB::table('FT_TCH_DEP')
            ->where('AD_YEAR','=',$nowyear)
            ->orderby('AD_YEAR')
            ->get();
      return view('admin.all.FT_TCH_DEP_all',compact('all'));
    }
    public function FT_TCH_DEP_from(Request $request){
      Excel::import(new Import_FT_TCH_DEP,$request->file);
      return redirect('/FT_TCH_DEP_all');
    }

//FT_TCH_SCH-----------------------------------------------------------------------------
    public function FT_TCH_SCH_all(){
      $nowyear = DB::Table('FT_TCH_SCH')
                     ->max("AD_YEAR");
      $all = DB::table('FT_TCH_SCH')
            ->where('AD_YEAR','=',$nowyear)
            ->orderby('AD_YEAR')
            ->get();
      return view('admin.all.FT_TCH_SCH_all',compact('all'));
    }
    public function FT_TCH_SCH_from(Request $request){
      Excel::import(new Import_FT_TCH_SCH,$request->file);
      return redirect('/FT_TCH_SCH_all');
    }

//PT_TCH_DEP-----------------------------------------------------------------------------
    public function PT_TCH_DEP_all(){
      $nowyear = DB::Table('PT_TCH_DEP')
                     ->max("AD_YEAR");
      $all = DB::table('PT_TCH_DEP')
            ->where('AD_YEAR','=',$nowyear)
            ->orderby('AD_YEAR')
            ->get();
      return view('admin.all.PT_TCH_DEP_all',compact('all'));
    }
    public function PT_TCH_DEP_from(Request $request){
      Excel::import(new Import_PT_TCH_DEP,$request->file);
      return redirect('/PT_TCH_DEP_all');
    }

//PT_TCH_DEP_SCH-----------------------------------------------------------------------------
    public function PT_TCH_SCH_all(){
      $nowyear = DB::Table('PT_TCH_SCH')
                     ->max("AD_YEAR");
      $all = DB::table('PT_TCH_SCH')
            ->where('AD_YEAR','=',$nowyear)
            ->orderby('AD_YEAR')
            ->get();
      return view('admin.all.PT_TCH_SCH_all',compact('all'));
    }
    public function PT_TCH_SCH_from(Request $request){
      Excel::import(new Import_PT_TCH_SCH,$request->file);
      return redirect('/PT_TCH_SCH_all');
    }
//TPR----------------------------------------------------------------------------
    public function TPR_all(){
      $nowyear = DB::Table('生師比_校')
                     ->max("學年度");


      $all = DB::table('生師比_校')
            ->where('學年度',$nowyear)
            ->get();
            
      return view('admin.all.TPR_all',compact('all'));
    }
    public function TPR_from(Request $request){
      Excel::import(new Import_TPR,$request->file);
      return redirect('/TPR_all');
    }

//EnrollmentAnalysis----------------------------------------------------------------------------
    public function EnrollmentAnalysis_all(){
      $nowyear = DB::Table('進入本校學生入學管道')
                     ->max("入學學年期");


      $all = DB::table('進入本校學生入學管道')
            ->where('入學學年期',$nowyear)
            ->get();
            
      return view('admin.all.EnrollmentAnalysis_all',compact('all'));
    }
    public function EnrollmentAnalysis_from(Request $request){
      Excel::import(new Import_EnrollmentAnalysis,$request->file);
      return redirect('/EnrollmentAnalysis_all');
    }
//Import_Group_Pred----------------------------------------------------------------------------
    public function Group_Pred_all(){
      $nowyear = DB::Table('group_predictions')
                     ->max("year");


      $all = DB::table('group_predictions')
            ->whereBetween('year', [$nowyear - 2, $nowyear])
            ->orderBy('year', 'desc')
            ->get();
            
      return view('admin.all.Group_Pred_all',compact('all'));
    }
    public function Group_Pred_from(Request $request){
      Excel::import(new Import_Group_Pred,$request->file);
      return redirect('/Group_Pred_all');
    }

//Department_GroupBaselines----------------------------------------------------------------------------
    public function Department_GroupBaselines_all(){
      $nowyear = DB::Table('department_group_baselines')
                     ->max("year");
       $all = DB::table('department_group_baselines')
            ->where('year',$nowyear)
            ->get();
      return view('admin.all.Department_GroupBaselines_all',compact('all'));
    }
    public function Department_GroupBaselines_from(Request $request){
      Excel::import(new Import_Department_GroupBaselines,$request->file);
      return redirect('/Department_GroupBaselines_all');
    }
//source_area----------------------------------------------------------------------------
    public function source_area_all(){
      $nowyear = DB::Table('入學前地區')
                     ->max("入學學年期");


      $all = DB::table('入學前地區')
            ->where('入學學年期',$nowyear)
            ->get();
            
      return view('admin.all.source_area_all',compact('all'));
    }
    public function source_area_from(Request $request){
      Excel::import(new Import_source_area,$request->file);
      return redirect('/source_area_all');
    }
//Teacher_System----------------------------------------------------------------------------
    public function Teacher_System_all(){
      $nowyear = DB::Table('Teacher_System')
                     ->max("AD_YEAR");


      $all = DB::table('Teacher_System')
            ->where('AD_YEAR',$nowyear)
            ->get();
            
      return view('admin.all.Teacher_System_all',compact('all'));
    }
    public function Teacher_System_from(Request $request){
      Excel::import(new Import_Teacher_System,$request->file);
      return redirect('/Teacher_System_all');
    }


    //-----------------------檔案下載-----------------------------------------
     public function College_System_xlsx()
    {
        return Excel::download(new Export_College_System,'College_System.xlsx');
    }
     public function College_System_csv()
    {
        return Excel::download(new Export_College_System,'College_System.csv');
    }
    //-------------STU_SCH--------------------------------------------------------
         public function STU_SCH_xlsx()
    {
        return Excel::download(new Export_STU_SCH,'STU_SCH.xlsx');
    }
     public function STU_SCH_csv()
    {
        return Excel::download(new Export_STU_SCH,'STU_SCH.csv');
    }
//STU_DEP-----------------------------------------------------------------------------
      public function STU_DEP_xlsx()
    {
        return Excel::download(new Export_STU_DEP,'STU_DEP.xlsx');
    }
     public function STU_DEP_csv()
    {
        return Excel::download(new Export_STU_DEP,'STU_DEP.csv');
    }
//DSP_System--------------------------------------------------------------------------
      public function DSP_System_xlsx()
    {
        return Excel::download(new Export_DSP_System,'DSP_System.xlsx');
    }
     public function DSP_System_csv()
    {
        return Excel::download(new Export_DSP_System,'DSP_System.csv');
    }
//SP_SCH-------------------------------------------------------------------------------
       public function SP_SCH_xlsx()
    {
        return Excel::download(new Export_SP_SCH,'SP_SCH.xlsx');
    }
     public function SP_SCH_csv()
    {
        return Excel::download(new Export_SP_SCH,'SP_SCH.csv');
    }
//SP_DEP----------------------------------------------------------------------------------
       public function SP_DEP_xlsx()
    {
        return Excel::download(new Export_SP_DEP,'SP_DEP.xlsx');
    }
     public function SP_DEP_csv()
    {
        return Excel::download(new Export_SP_DEP,'SP_DEP.csv');
    }
//DP_DEP----------------------------------------------------------------------------------
       public function DP_DEP_xlsx()
    {
        return Excel::download(new Export_DP_DEP,'DP_DEP.xlsx');
    }
     public function DP_DEP_csv()
    {
        return Excel::download(new Export_DP_DEP,'DP_DEP.csv');
    } 
    //DP_SCH----------------------------------------------------------------------------------
       public function DP_SCH_xlsx()
    {
        return Excel::download(new Export_DP_SCH,'DP_SCH.xlsx');
    }
     public function DP_SCH_csv()
    {
        return Excel::download(new Export_DP_SCH,'DP_SCH.csv');
    } 
}
