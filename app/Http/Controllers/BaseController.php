<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class BaseController extends Controller
{
    protected $schoolname;
    protected $menuLinks;

    public function __construct()
    {
        $this->schoolname = DB::Table('School')
            ->where('School_check', true)
            ->value('School_Name');

        $this->menuLinks = $this->getMenuLinks();
    }

    /**
     * 獲取所有選單連結資料
     * 
     * @return array
     */
    protected function getMenuLinks()
    {
        return [
            'link_student' => DB::Table('STU_SCH')
                ->where('SCH_NAME', $this->schoolname)
                ->max("AD_YEAR"),
            
            'link_s_suspension' => DB::Table('SP_SCH_NEW')
                ->where('SCH_NAME', $this->schoolname)
                ->max("AD_YEAR"),
            
            'link_s_dropout' => DB::Table('DP_SCH')
                ->where('SCH_NAME', $this->schoolname)
                ->max("AD_YEAR"),
            
            'link_teacher' => DB::Table('FT_TCH_SCH')
                ->where('SCH_NAME', $this->schoolname)
                ->max("AD_YEAR"),
            
            'link_teacherHour' => DB::Table('FT_TCH_HOURS_ONSCH')
                ->where('SCH_NAME', $this->schoolname)
                ->max("AD_YEAR"),
            
            'link_tpr' => DB::Table('生師比_校')
                ->where('學校名稱', $this->schoolname)
                ->max("學年度"),
            
            'link_EnrollmentAnalysis' => DB::Table('進入本校學生入學管道')
                ->max("入學學年期"),
            
            'link_treemap' => DB::Table('入學前地區')
                ->max("入學學年期"),
        ];
    }

    /**
     * 返回包含選單資料的視圖
     * 
     * @param string $view
     * @param array $data
     * @return \Illuminate\View\View
     */
    protected function viewWithMenu($view, $data = [])
    {
        return view($view, array_merge($data, [
            'menuLinks' => $this->menuLinks,
            'schoolname' => $this->schoolname,
        ]));
    }
}
