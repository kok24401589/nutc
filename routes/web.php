<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/EnrollmentDashboard', function () {

    // ✅ MenuComposer 已自動提供 $schoolname 和 $menuLinks
    // 只保留業務邏輯所需的資料查詢

    $year = request()->input('year');

    if (is_null($year)) {
        $schoolname = DB::table('School')
            ->where('School_check', true)
            ->value('School_Name');
        
        $nowyear = DB::table('STU_SCH')
            ->where('SCH_NAME', $schoolname)
            ->max('AD_YEAR');
    } else {
        $nowyear = $year;
    }

    return view('dashboard.enrollment', compact('nowyear'));
});

Route::get("/ir","IndexController@index");
Route::get('/t', function () {
	//模板
    return view('temp');
});
//--學生人數--------------------
Route::match(['get','post'],'student/{year?}',"student_controller@student");

Route::match(['get','post'],'student_college/{year?}', "student_controller@student_college");

Route::match(['get','post'],'student_department/{value?}/{year?}',"student_department_controller@student");
//--學生休學人數--------------------

Route::match(['get','post'],'s_suspension/{year?}',"student_controller@suspension");

Route::match(['get','post'],'s_suspension_college/{year?}',"student_controller@s_suspension_college");

Route::match(['get','post'],'s_suspension_department/{value?}',"student_department_controller@suspension");

//--學生退學人數--------------------
Route::match(['get','post'],'s_dropout/{year?}',"student_controller@dropout");

Route::match(['get','post'],'s_dropout_college/{year?}',"student_controller@s_dropout_college");

Route::match(['get','post'],'s_dropout_department/{value?}',"student_department_controller@dropout");

//會員登入
Route::match(['get','post'],"/signin","Admin_Controller@signin");
//會員登出
Route::get("/signout","Admin_Controller@signout");

//--後台--------------------
//Kernel記得改
Route::group(['middleware'=> 'check'], function() {
    //會員註冊
    Route::match(['get','post'],'/signup',"RegisterController@index");
    Route::match(['get','post'],'backedit',"backedit_Cotroller@all");
    Route::match(['get','post'],'backedit2',"backedit_Cotroller@all2");
    Route::match(['get','post'],'backedit3',"backedit_Cotroller@all3");
    Route::match(['get','post'],'back_home',"Admin_Controller@home");
    //學生類上傳
    Route::get('/impot_from_student', function () {
        return view('admin.import_student');
    });
    //教師類上傳
    Route::get('/impot_from_teacher', function () {
        return view('admin.import_teacher');
    });
        //生源類上傳
    Route::get('/impot_from_EnrollmentAnalysis', function () {
        return view('admin.import_EnrollmentAnalysis');
    });
    //自訂表上傳
    Route::get('/impot_from_customized', function () {
        return view('admin.import_customized');
    });
    //會員資料修改
    Route::match(['get','post'],'adminedit',"Admin_Controller@index");
});

//--教師人數--------------------
Route::match(['get','post'],'teacher/{year?}','teacher_controller@teacher');

Route::match(['get','post'],'teacher_college/{year?}','teacher_controller@teacher_college');

Route::get('teacher_department','teacher_controller@teacher_department');

//--生師比---------------------
Route::get('tpr','TprController@school');

Route::get('tpr_college','TprController@college');

Route::match(['get','post'],'tpr_department/{year?}','TprController@department');

//--教師授課時數
Route::get('TeachHour','TeachHourController@school');

//--生源分析
Route::get('treemap','treemap_Controller@treemap');

Route::get('treemap_department','treemap_Controller@TreemapDepartment');
Route::get('treemap_department_data','treemap_Controller@TreemapDepartmentData');  // AJAX JSON
Route::match(['get','post'],'TreemapMore_test/{system?}','treemap_test@TreemapMore_s');
Route::get('treemapmore','treemap_Controller@TreemapMore');

//--入學管道分析
Route::get('EnrollmentAnalysis','EnrollmentAnalysis_Controller@School');
Route::get('EnrollmentAnalysisDepartment','EnrollmentAnalysis_Controller@Department');
Route::get('EnrollmentAnalysisDepartment_data','EnrollmentAnalysis_Controller@DepartmentData');  // AJAX JSON
Route::get('EnrollmentAnalysisMore','EnrollmentAnalysis_Controller@More');
//
Route::get('Studentclass_pred','EnrollmentAnalysis_Controller@Pr');
//--檔案上傳路徑-----------------------------------
//檢視上傳路徑
Route::get('/College_System_all',"backedit_Cotroller@College_System_all");
Route::get('/STU_DEP_all',"backedit_Cotroller@STU_DEP_all");
Route::get('/STU_SCH_all',"backedit_Cotroller@STU_SCH_all");
Route::get('/DSP_System_all',"backedit_Cotroller@DSP_System_all");
Route::get('/SP_SCH_all',"backedit_Cotroller@SP_SCH_all");
Route::get('/SP_DEP_all',"backedit_Cotroller@SP_DEP_all");
Route::get('/DP_DEP_all',"backedit_Cotroller@DP_DEP_all");
Route::get('/DP_SCH_all',"backedit_Cotroller@DP_SCH_all");
Route::get('/PT_TCH_DEP_all',"backedit_Cotroller@PT_TCH_DEP_all");
Route::get('/PT_TCH_SCH_all',"backedit_Cotroller@PT_TCH_SCH_all");
Route::get('/FT_TCH_DEP_all',"backedit_Cotroller@FT_TCH_DEP_all");
Route::get('/FT_TCH_SCH_all',"backedit_Cotroller@FT_TCH_SCH_all");
Route::get('/TPR_all',"backedit_Cotroller@TPR_all");
Route::get('/EnrollmentAnalysis_all',"backedit_Cotroller@EnrollmentAnalysis_all");

Route::get('/Group_Pred_all',"backedit_Cotroller@Group_Pred_all");
Route::get('/Department_GroupBaselines_all',"backedit_Cotroller@Department_GroupBaselines_all");

Route::get('/source_area_all',"backedit_Cotroller@source_area_all");
Route::get('/Teacher_System_all',"backedit_Cotroller@Teacher_System_all");
//表單傳送路徑
Route::post('/College_System_from',"backedit_Cotroller@College_System_from")->name('College_System_from');
Route::post('/STU_SCH_from',"backedit_Cotroller@STU_SCH_from")->name('STU_SCH_from');
Route::post('/STU_DEP_from',"backedit_Cotroller@STU_DEP_from")->name('STU_DEP_from');
Route::post('/DSP_System_from',"backedit_Cotroller@DSP_System_from")->name('DSP_System_from');
Route::post('/SP_SCH_from',"backedit_Cotroller@SP_SCH_from")->name('SP_SCH_from');
Route::post('/SP_DEP_from',"backedit_Cotroller@SP_DEP_from")->name('SP_DEP_from');
Route::post('/DP_DEP_from',"backedit_Cotroller@DP_DEP_from")->name('DP_DEP_from');
Route::post('/DP_SCH_from',"backedit_Cotroller@DP_SCH_from")->name('DP_SCH_from');
Route::post('/PT_TCH_DEP_from',"backedit_Cotroller@PT_TCH_DEP_from")->name('PT_TCH_DEP_from');
Route::post('/PT_TCH_SCH_from',"backedit_Cotroller@PT_TCH_SCH_from")->name('PT_TCH_SCH_from');
Route::post('/FT_TCH_DEP_from',"backedit_Cotroller@FT_TCH_DEP_from")->name('FT_TCH_DEP_from');
Route::post('/FT_TCH_SCH_from',"backedit_Cotroller@FT_TCH_SCH_from")->name('FT_TCH_SCH_from');
Route::post('/TPR_from',"backedit_Cotroller@TPR_from")->name('TPR_from');
Route::post('/EnrollmentAnalysis_from',"backedit_Cotroller@EnrollmentAnalysis_from")->name('EnrollmentAnalysis_from');

Route::post('/Group_Pred_from',"backedit_Cotroller@Group_Pred_from")->name('Group_Pred_from');
Route::post('/Department_GroupBaselines_from',"backedit_Cotroller@Department_GroupBaselines_from")->name('Department_GroupBaselines_from');

Route::post('/source_area_from',"backedit_Cotroller@source_area_from")->name('source_area_from');
Route::post('/Teacher_System_from',"backedit_Cotroller@Teacher_System_from")->name('Teacher_System_from');

//--檔案下載路徑-----------------------------------
//College_System
Route::get('/College_System_xlsx',"backedit_Cotroller@College_System_xlsx");
Route::get('/College_System_csv',"backedit_Cotroller@College_System_csv");
//STU_SCH
Route::get('/STU_SCH_xlsx',"backedit_Cotroller@STU_SCH_xlsx");
Route::get('/STU_SCH_csv',"backedit_Cotroller@STU_SCH_csv");
//STU_DEP
Route::get('/STU_DEP_xlsx',"backedit_Cotroller@STU_DEP_xlsx");
Route::get('/STU_DEP_csv',"backedit_Cotroller@STU_DEP_csv");
//DSP_System
Route::get('/DSP_System_xlsx',"backedit_Cotroller@DSP_System_xlsx");
Route::get('/DSP_System_csv',"backedit_Cotroller@DSP_System_csv");
//SP_SCH
Route::get('/SP_SCH_xlsx',"backedit_Cotroller@SP_SCH_xlsx");
Route::get('/SP_SCH_csv',"backedit_Cotroller@SP_SCH_csv");
//SP_DEP_all
Route::get('/SP_DEP_xlsx',"backedit_Cotroller@SP_DEP_xlsx");
Route::get('/SP_DEP_csv',"backedit_Cotroller@SP_DEP_csv");
//SP_DEP_all
Route::get('/DP_DEP_xlsx',"backedit_Cotroller@DP_DEP_xlsx");
Route::get('/DP_DEP_csv',"backedit_Cotroller@DP_DEP_csv");
//SP_SCH_all
Route::get('/DP_SCH_xlsx',"backedit_Cotroller@DP_SCH_xlsx");
Route::get('/DP_SCH_csv',"backedit_Cotroller@DP_SCH_csv");
