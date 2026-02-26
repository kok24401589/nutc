<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Services\MenuService;

/**
 * 選單 View Composer（使用 MenuService 版本）
 * 
 * 這是優化版本，使用 MenuService 來處理選單邏輯
 * 讓 Composer 更加簡潔，邏輯更好維護
 */
class MenuComposerWithService
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

    /**
     * 為視圖綁定選單資料
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with($this->menuService->getMenuData());
    }
}
