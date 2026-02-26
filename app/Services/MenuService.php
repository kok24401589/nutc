<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

/**
 * 選單服務類別
 * 
 * 負責處理所有選單相關的資料查詢邏輯
 * 可配合 View Composer 或 Controller 使用
 */
class MenuService
{
    private $schoolname;

    public function __construct()
    {
        $this->schoolname = $this->getSchoolName();
    }

    /**
     * 獲取學校名稱
     * 
     * @return string
     */
    public function getSchoolName()
    {
        return Cache::remember('current_school_name', 3600, function () {
            return DB::Table('School')
                ->where('School_check', true)
                ->value('School_Name');
        });
    }

    /**
     * 獲取所有選單連結（帶快取）
     * 
     * @return array
     */
    public function getMenuLinks()
    {
        // 使用快取避免重複查詢，快取 1 小時
        return Cache::remember('menu_links_' . $this->schoolname, 3600, function () {
            return [
                'link_student' => $this->getMaxYear('STU_SCH', 'SCH_NAME', 'AD_YEAR'),
                'link_s_suspension' => $this->getMaxYear('SP_SCH_NEW', 'SCH_NAME', 'AD_YEAR'),
                'link_s_dropout' => $this->getMaxYear('DP_SCH', 'SCH_NAME', 'AD_YEAR'),
                'link_teacher' => $this->getMaxYear('FT_TCH_SCH', 'SCH_NAME', 'AD_YEAR'),
                'link_teacherHour' => $this->getMaxYear('FT_TCH_HOURS_ONSCH', 'SCH_NAME', 'AD_YEAR'),
                'link_tpr' => $this->getMaxYear('生師比_校', '學校名稱', '學年度'),
                'link_EnrollmentAnalysis' => DB::Table('進入本校學生入學管道')->max("入學學年期"),
                'link_treemap' => DB::Table('入學前地區')->max("入學學年期"),
            ];
        });
    }

    /**
     * 查詢指定資料表的最大年度
     * 
     * @param string $table 資料表名稱
     * @param string $schoolColumn 學校欄位名稱
     * @param string $yearColumn 年度欄位名稱
     * @return mixed
     */
    private function getMaxYear($table, $schoolColumn, $yearColumn)
    {
        return DB::Table($table)
            ->where($schoolColumn, $this->schoolname)
            ->max($yearColumn);
    }

    /**
     * 清除選單快取
     * 當資料更新時呼叫此方法
     * 
     * @return void
     */
    public function clearCache()
    {
        Cache::forget('menu_links_' . $this->schoolname);
        Cache::forget('current_school_name');
    }

    /**
     * 獲取包含選單的完整資料
     * 
     * @return array
     */
    public function getMenuData()
    {
        return [
            'schoolname' => $this->schoolname,
            'menuLinks' => $this->getMenuLinks(),
        ];
    }

    /**
     * 生成選單 HTML 結構（純資料版本）
     * 
     * @return array
     */
    public function getMenuStructure()
    {
        $links = $this->getMenuLinks();
        
        return [
            [
                'label' => '回首頁',
                'url' => url('index'),
            ],
            [
                'label' => '學生類',
                'children' => [
                    [
                        'label' => '學生人數分析',
                        'children' => [
                            ['label' => '最新資料', 'url' => url("student/?year={$links['link_student']}")],
                            ['label' => '109學年', 'url' => url('student/?year=109')],
                            ['label' => '108學年', 'url' => url('student/?year=108')],
                            ['label' => '107學年', 'url' => url('student/?year=107')],
                            ['label' => '106學年', 'url' => url('student/?year=106')],
                        ],
                    ],
                    [
                        'label' => '休學人數分析',
                        'children' => [
                            ['label' => '最新資料', 'url' => url("s_suspension/?year={$links['link_s_suspension']}")],
                            ['label' => '108學年', 'url' => url('s_suspension/?year=108')],
                            ['label' => '107學年', 'url' => url('s_suspension/?year=107')],
                            ['label' => '106學年', 'url' => url('s_suspension/?year=106')],
                        ],
                    ],
                    [
                        'label' => '退學人數分析',
                        'children' => [
                            ['label' => '最新資料', 'url' => url("s_dropout/?year={$links['link_s_dropout']}")],
                            ['label' => '108學年', 'url' => url('s_dropout/?year=108')],
                            ['label' => '107學年', 'url' => url('s_dropout/?year=107')],
                            ['label' => '106學年', 'url' => url('s_dropout/?year=106')],
                        ],
                    ],
                ],
            ],
            [
                'label' => '教師類',
                'children' => [
                    [
                        'label' => '教師人數分析',
                        'children' => [
                            ['label' => '最新資料', 'url' => url("teacher/?year={$links['link_teacher']}")],
                            ['label' => '109學年', 'url' => url('teacher/?year=109')],
                            ['label' => '108學年', 'url' => url('teacher/?year=108')],
                            ['label' => '107學年', 'url' => url('teacher/?year=107')],
                            ['label' => '106學年', 'url' => url('teacher/?year=106')],
                        ],
                    ],
                    ['label' => '生師比率分析', 'url' => url('tpr')],
                    ['label' => '教師授課時數', 'url' => url("TeachHour/?year={$links['link_teacherHour']}")],
                ],
            ],
            [
                'label' => '招生類',
                'children' => [
                    ['label' => '五專升二技分析', 'url' => url('../fivetotwo/fivetotwo.php')],
                    ['label' => '入學管道分析', 'url' => url("EnrollmentAnalysis/?year={$links['link_EnrollmentAnalysis']}")],
                    ['label' => '學生來源地區分析', 'url' => url("treemap/?year={$links['link_treemap']}")],
                ],
            ],
            [
                'label' => '其他教育資料庫',
                'url' => url('Link_teacher'),
            ],
        ];
    }
}
