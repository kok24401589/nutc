<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 這是使用 BaseController 重構後的範例
 * 示範如何移除重複的選單查詢程式碼
 */
class student_controller_EXAMPLE extends BaseController
{
    public function student()
    {
        // ✅ 不需要再查詢這些（已在 BaseController 中處理）：
        // $schoolname = DB::Table('School')->where('School_check',true)->pluck('School_Name');
        // $link_student = ...
        // $link_s_suspension = ...
        // $link_s_dropout = ...
        // $link_teacher = ...
        // $link_teacherHour = ...
        // $link_tpr = ...
        // $link_EnrollmentAnalysis = ...
        // $link_treemap = ...
        
        // ✅ 直接使用 $this->schoolname
        $year = request()->input("year");
        
        if (is_null($year)) {
            $nowyear = DB::Table('STU_SCH')
                ->where('SCH_NAME', $this->schoolname)
                ->max("AD_YEAR");
        } else {
            $nowyear = $year;
        }

        $STU_SUM = DB::Table('STU_SCH')
            ->select(DB::raw("sum(STU_SUM) as STU_SUM"))
            ->where("AD_YEAR", '=', $nowyear)
            ->where('SCH_NAME', $this->schoolname)
            ->first();

        $SYSTEM_TYPE = DB::Table('STU_DEP As a')
            ->leftjoin('College_System As b', function ($join) {
                $join->on('b.DEP_CODE', 'a.DEP_CODE');
                $join->on('b.AD_YEAR', 'a.AD_YEAR');
                $join->on('b.SCH_SYS', 'a.SCH_SYS');
                $join->on('b.DEP_NAME', 'a.DEP_NAME');
            })
            ->select('SYSTEM_TYPE', DB::raw("sum(STU_SUM) as STU_SUM"))
            ->where('a.AD_YEAR', '=', $nowyear)
            ->where('SCH_NAME', $this->schoolname)
            ->groupby('b.SYSTEM_TYPE')
            ->groupby('ST_NUM')
            ->orderby('ST_NUM')
            ->get();

        // ... 其他查詢邏輯

        // ✅ 使用 viewWithMenu 方法（自動包含 menuLinks 和 schoolname）
        return $this->viewWithMenu('student', [
            'year' => $nowyear,
            'STU_SUM' => $STU_SUM,
            'SYSTEM_TYPE' => $SYSTEM_TYPE,
            // ... 其他資料
        ]);
        
        // 🔴 改前：return view('student', compact('變數1', '變數2', ..., 'menuLinks', 'schoolname'));
    }
}
