<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use Validator;
use Carbon;
class Admin_Controller extends Controller
{
    public function signin(){

      if(request()->has("login"))
      {
            $input = request()->all();
            $rule = [
                "user_email" => [
                    "required",
                    "max:200",
                    "email"
                ],
                "user_pw" => [
                    "required",
                    "alpha_num",
                ],
            ];
            $validator = Validator::make($input,$rule);
            if($validator->fails())
            {
                return redirect("signin")
                     ->withErrors($validator)
                     ->withInput();
            }
            else
            {
            // 新資料表
            $user = DB::Table('users')
                        ->where("user_email",$input["user_email"])
                        ->first();
            // $user = DB::Table('MEMBER')
            //             ->where("email",$input["user_email"])
            //             ->first();

            if($user==null){
                return redirect("signin")
                     ->withErrors("帳號或密碼錯誤");
            }

            // 新資料表
            $pwd = request()->input("user_pw");
            $is_password_corrent = Hash::check($input["user_pw"],$user->user_pw);
            if($is_password_corrent)
            {
                session()->put("name",$user->user_name);
                return redirect('back_home');
            }
            else{
                return redirect("signin")
                     ->withErrors("帳號或密碼錯誤");
            }
            // $pwd = request()->input("user_pw");
            // // dd($pwd);
            // if($pwd == $user->pwd)
            // {
            //     session()->put("name",$user->name);
            //     return redirect('back_home');
            // }
            // else{
            //     return redirect("signin")
            //          ->withErrors("帳號或密碼錯誤");
            // }
        }
      }
      return view("back_login");
    }
    public function signout()
    {
        session()->forget("name");
        return redirect('signin');
    }
    public function index()
    {
        if(request()->has("save"))
        {
            // dd( request()->all() );
            $input = request()->all();
            $id = key(request()->input("save"));
            if (Hash::needsRehash($input["edit_pw"]))
            {
                $input["edit_pw"] = Hash::make($input["edit_pw"]);
                DB::Table('users')
                ->where("id",$id)
                ->update([
                    "user_email" => request()->input("edit_email"),
                    "user_pw" => $input["edit_pw"],
                    "user_name" => request()->input("edit_name"),
                    "updatedate" =>  Carbon\Carbon::now()
                ]);
            }else{
                DB::Table('users')
                ->where("id",$id)
                ->update([
                    "user_email" => request()->input("edit_email"),
                    "user_name" => request()->input("edit_name"),
                    "updatedate" =>  Carbon\Carbon::now()
                ]);
            }

        }
        $user = DB::Table('users')
                  ->get();
        // dd($user);

        return view("admin/adminedit",compact('user'));
    }
    public function home()
    {
        if(request()->has("save"))
        {
            // dd( request()->all() );
            $input = request()->all();
            $id = key(request()->input("save"));
              DB::Table('School')
                ->where("School_Code",$id)
                ->update([
                    "School_check" => 'true'
                ]);
              DB::Table('School')
                ->where("School_Code",'<>',$id)
                ->update([
                    "School_check" => 'false'
                ]);
        }
        $schoolname = DB::Table('School')
                        ->where('School_check',true)
                        ->pluck('School_Name');
        $schoolname = $schoolname[0];

        $schoolnamelist = DB::Table('School')
                            ->get();
        // dd($schoolname);
        // 學生人數_校
        $StudentNowYear = DB::Table('STU_SCH')
                             ->max("AD_YEAR");
        // 學生人數_系
        $StudentDepartmentNowYear = DB::Table('STU_DEP')
                                       ->max("AD_YEAR");
        //校院系編輯
        $ColSysNowYear = DB::Table('College_System')
                            ->max("AD_YEAR");
        // 休學人數分析-校
        $SP_SCH_NowYear = DB::Table('SP_SCH_NEW')
                                       ->max("AD_YEAR"); 
        // 休學人數分析-系
        $SP_DEP_NowYear = DB::Table('SP_DEP_NEW')
                                       ->max("AD_YEAR"); 
        // 退學人數分析-校
        $DP_SCH_NowYear = DB::Table('DP_SCH')
                                       ->max("AD_YEAR"); 
        // 退學人數分析-系
        $DP_DEP_NowYear = DB::Table('DP_DEP')
                                       ->max("AD_YEAR"); 
        // 休退學院系科編輯
        $DSP_System_NowYear = DB::Table('DSP_System')
                                       ->max("AD_YEAR"); 
        // 專任教師數_校
        $FT_TCH_SCH_NowYear = DB::Table('FT_TCH_SCH')
                                       ->max("AD_YEAR");
        // 專任教師數_系
        $FT_TCH_DEP_NowYear = DB::Table('FT_TCH_DEP')
                                       ->max("AD_YEAR"); 
        // 兼任教師數_校
        $PT_TCH_SCH_NowYear = DB::Table('PT_TCH_SCH')
                                       ->max("AD_YEAR");
        // 兼任教師數_系
        $PT_TCH_DEP_NowYear = DB::Table('PT_TCH_DEP')
                                       ->max("AD_YEAR"); 
        // 生師比_校
        $PK_NowYear = DB::Table('生師比_校')
                                       ->max("學年度"); 
        // 專任教師授課時數-校
        $FT_TCH_HOURS_ONSCH_NowYear = DB::Table('FT_TCH_HOURS_ONSCH')
                                       ->max("AD_YEAR");
        // 進入本校學生入學管道
        $Entrance_pipeline = DB::Table('進入本校學生入學管道')
                               ->max("入學學年期");
        //進入本校學生畢業學校
        $Graduated_school = DB::Table('入學前地區')
                              ->max("入學學年期");
        // 教師學院系科編輯
        $Teacher_System_NowYear = DB::Table('Teacher_System')
                                    ->max("AD_YEAR"); 
        
        $department_group_baselines_NowYear = DB::Table('department_group_baselines')
                                    ->max("year"); 
        $group_predictions_NowYear = DB::Table('group_predictions')
                                    ->max("year");                             
        $NowYear = array((int)$StudentNowYear,
                         (int)$StudentDepartmentNowYear,
                         (int)$ColSysNowYear,
                         (int)$SP_SCH_NowYear,
                         (int)$SP_DEP_NowYear,

                         (int)$DP_SCH_NowYear,
                         (int)$DP_DEP_NowYear,
                         (int)$DSP_System_NowYear,
                         (int)$FT_TCH_SCH_NowYear,
                         (int)$FT_TCH_DEP_NowYear,

                         (int)$PT_TCH_SCH_NowYear,
                         (int)$PT_TCH_DEP_NowYear,
                         (int)$PK_NowYear,
                         (int)$FT_TCH_HOURS_ONSCH_NowYear,
                         (int)$Graduated_school,

                         (int)$Teacher_System_NowYear,
                         (int)$department_group_baselines_NowYear,
                         (int)$group_predictions_NowYear
                       );
        return view("admin/back_home",compact('NowYear','schoolname','schoolnamelist'));
    }
}
// STU_SCH             學1-2.正式學籍在學學生人數-以「校(含學制班別)」統計
// STU_DEP             學1-1.正式學籍在學學生人數-以「系(所)」統計
// College_System      STU_DEP
// SP_SCH              學13-2.於學年底處於休學狀態之人數-以「校(含學制班別)」統計
// SP_DEP              學13-1.於學年底處於休學狀態之人數-以「系(所)」統計
// DP_SCH              學14-2.退學人數-以「校(含學制班別)」統計
// DP_DEP              學14-1.退學人數-以「系(所)」統計
// DSP_System          College_System
// FT_TCH_DEP          教1-1.專任教師數-以「系(所)」統計
// FT_TCH_SCH          教1-2.專任教師數-以「校」統計
// PT_TCH_DEP          教2-1.兼任教師數-以「系(所)」統計
// PT_TCH_SCH          教2-2.兼任教師數-以「校」統計
// 生師比_校            教5.日間學制生師比-以「校」統計
// FT_TCH_HOURS_ONSCH  教4-2.專任教師每週授課時數-以「校」統計