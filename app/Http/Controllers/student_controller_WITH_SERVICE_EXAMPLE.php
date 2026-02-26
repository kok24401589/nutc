<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenuService;
use Illuminate\Support\Facades\DB;

/**
 * 使用 MenuService 的 Controller 範例
 * 
 * 這個方案不需要繼承 BaseController
 * 而是使用依賴注入的方式使用 MenuService
 */
class student_controller_WITH_SERVICE_EXAMPLE extends Controller
{
    protected $menuService;

    /**
     * 建構子注入 MenuService
     *
     * @param  \App\Services\MenuService  $menuService
     * @return void
     */
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function student()
    {
        // ✅ 使用 MenuService 獲取學校名稱
        $schoolname = $this->menuService->getSchoolName();
        
        $year = request()->input("year");
        
        if (is_null($year)) {
            $nowyear = DB::Table('STU_SCH')
                ->where('SCH_NAME', $schoolname)
                ->max("AD_YEAR");
        } else {
            $nowyear = $year;
        }

        $STU_SUM = DB::Table('STU_SCH')
            ->select(DB::raw("sum(STU_SUM) as STU_SUM"))
            ->where("AD_YEAR", '=', $nowyear)
            ->where('SCH_NAME', $schoolname)
            ->first();

        // ... 其他查詢邏輯

        // ✅ 使用 MenuService 獲取選單資料
        $menuData = $this->menuService->getMenuData();

        return view('student', array_merge([
            'year' => $nowyear,
            'STU_SUM' => $STU_SUM,
            // ... 其他資料
        ], $menuData));
    }

    /**
     * 清除選單快取（例如：當資料更新時）
     */
    public function clearMenuCache()
    {
        $this->menuService->clearCache();
        return response()->json(['message' => '選單快取已清除']);
    }
}
