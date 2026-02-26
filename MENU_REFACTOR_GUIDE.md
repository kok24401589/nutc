# 選單重構方案說明

## 問題分析
目前每個 Controller 都重複了 8-10 行選單連結查詢程式碼，且前端使用過時的 `document.writeln` 方式載入選單。

---

## 解決方案

### 🎯 **方案一：View Composer（最推薦）**

#### 優點：
- ✅ 自動將資料注入所有視圖，無需修改 Controller
- ✅ 集中管理，易於維護
- ✅ 符合 Laravel 最佳實踐
- ✅ 可選擇性應用於特定視圖

#### 已建立檔案：
1. `app/Http/View/Composers/MenuComposer.php` - 選單資料處理
2. `app/Providers/AppServiceProvider.php` - 已註冊 View Composer
3. `resources/views/components/menu.blade.php` - 新版 Blade 選單

#### 使用方式：

**在任何 Blade 視圖中直接使用（無需修改 Controller）：**
```blade
<!-- 引入選單 Component -->
@include('components.menu')

<!-- 或直接使用變數 -->
<a href="{{ url('student/?year=' . $menuLinks['link_student']) }}">
    學生人數分析
</a>
```

**Controller 無需修改，選單資料會自動傳入：**
```php
public function student()
{
    // 不需要再查詢選單資料
    // $menuLinks 和 $schoolname 已自動可用
    
    $data = [
        'STU_SUM' => $STU_SUM,
        'SYSTEM_TYPE' => $SYSTEM_TYPE,
        // ...
    ];
    
    return view('student', $data);
}
```

---

### 🎯 **方案二：Base Controller（替代方案）**

#### 優點：
- ✅ 易於理解和實作
- ✅ 可在子類別中自訂選單邏輯
- ✅ 適合需要選單資料做邏輯處理的情境

#### 已建立檔案：
1. `app/Http/Controllers/BaseController.php` - 基礎控制器

#### 使用方式：

**修改現有 Controller 繼承 BaseController：**
```php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController; // 改用 BaseController
use DB;

class student_controller extends BaseController // 繼承 BaseController
{
    public function student()
    {
        // 可直接使用 $this->schoolname 和 $this->menuLinks
        
        $year = request()->input("year");
        
        // 原有的業務邏輯...
        $STU_SUM = DB::Table('STU_SCH')
            ->where('SCH_NAME', $this->schoolname) // 使用 $this->schoolname
            ->first();
        
        // 使用 viewWithMenu 方法返回視圖（自動包含選單資料）
        return $this->viewWithMenu('student', [
            'year' => $year,
            'STU_SUM' => $STU_SUM,
            // ...
        ]);
    }
}
```

---

## 前端修改

### 替換舊的 menu.js

**在 temp.blade.php 中：**

**原本：**
```blade
<script src="{{URL::asset('menu.js')}}"></script>
```

**改為：**
```blade
@include('components.menu')
```

---

## 比較與建議

| 特性 | View Composer | Base Controller |
|------|---------------|-----------------|
| Controller 修改量 | 無需修改 | 需修改繼承 |
| 學習曲線 | 低 | 極低 |
| 維護性 | 極佳 | 良好 |
| 彈性 | 高 | 中 |
| Laravel 風格 | ✅ 最佳實踐 | ✅ 常見模式 |
| **推薦指數** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ |

---

## 實作步驟（選擇其一）

### 使用 View Composer（推薦）

1. ✅ 檔案已建立
2. 修改 `resources/views/temp.blade.php`，移除 `menu.js` 改用 `@include('components.menu')`
3. 從所有 Controller 中刪除重複的選單查詢程式碼
4. 測試各頁面選單功能

### 使用 Base Controller

1. ✅ 檔案已建立
2. 修改各 Controller 繼承 `BaseController`
3. 將 `return view()` 改為 `return $this->viewWithMenu()`
4. 移除重複的選單查詢程式碼
5. 修改 `resources/views/temp.blade.php`，改用 `@include('components.menu')`
6. 測試各頁面選單功能

---

## 進階優化建議

### 1. 快取選單資料
```php
// 在 MenuComposer.php 中使用快取
public function compose(View $view)
{
    $menuLinks = Cache::remember('menu_links', 3600, function () {
        // 查詢邏輯...
        return $menuLinks;
    });
    
    $view->with('menuLinks', $menuLinks);
}
```

### 2. 建立選單 Service
```php
// app/Services/MenuService.php
class MenuService
{
    public function getMenuLinks($schoolname)
    {
        // 選單邏輯...
    }
}
```

### 3. 資料庫存儲選單結構
考慮將選單結構存入資料庫，方便未來動態管理。

---

## 需要協助？

如果需要我協助：
1. 修改特定 Controller
2. 更新 temp.blade.php
3. 實作快取機制
4. 其他客製化需求

請告訴我！
