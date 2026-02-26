<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class MenuComposer
{
    /**
     * 為視圖綁定選單資料
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $schoolname = DB::Table('School')
            ->where('School_check', true)
            ->value('School_Name');

        // 獲取所有選單連結
        $menuLinks = [
            'link_student' => DB::Table('STU_SCH')
                ->where('SCH_NAME', $schoolname)
                ->max("AD_YEAR"),
            
            'link_s_suspension' => DB::Table('SP_SCH_NEW')
                ->where('SCH_NAME', $schoolname)
                ->max("AD_YEAR"),
            
            'link_s_dropout' => DB::Table('DP_SCH')
                ->where('SCH_NAME', $schoolname)
                ->max("AD_YEAR"),
            
            'link_teacher' => DB::Table('FT_TCH_SCH')
                ->where('SCH_NAME', $schoolname)
                ->max("AD_YEAR"),
            
            'link_teacherHour' => DB::Table('FT_TCH_HOURS_ONSCH')
                ->where('SCH_NAME', $schoolname)
                ->max("AD_YEAR"),
            
            'link_tpr' => DB::Table('生師比_校')
                ->where('學校名稱', $schoolname)
                ->max("學年度"),
            
            'link_EnrollmentAnalysis' => DB::Table('進入本校學生入學管道')
                ->max("入學學年期"),
            
            'link_treemap' => DB::Table('入學前地區')
                ->max("入學學年期"),
        ];

        $view->with('menuLinks', $menuLinks);
        $view->with('schoolname', $schoolname);
    }
}
