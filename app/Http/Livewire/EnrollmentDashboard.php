<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class EnrollmentDashboard extends Component
{
    /* =========================
     * 基本狀態
     * ========================= */
    public $departments = [];
    public $selectedDepartment = null;
    public string $admission_type = '聯合登記分發';
    public ?string $group21Note = null;

    public $baseYear;
    public $predictionYears = [];

    public $warning = null;

    /* =========================
     * Baseline（原群）
     * ========================= */
    public array $baselinePicked = [];          // [['group_id','group_name']]
    public array $baselineYearly = [];           // year => total
    public int   $baselineTotal = 0;
    public array $baselinePerGroupYear = [];     // [gid][year] => count

    /* =========================
     * Scenario（新群）
     * ========================= */
    public array $scenarioGroups = [];            // checkbox 勾選的 group_id
    public array $scenarioPicked = [];            // [['group_id','group_name']]
    public array $scenarioYearly = [];
    public int   $scenarioTotal = 0;
    public array $scenarioPerGroupYear = [];

    /* =========================
     * Slot（核心）
     * ========================= */
    public array $baselineSlots = [];  // slot => ['group_id','group_name'] | null
    public array $scenarioSlots = [];  // slot => ['group_id','group_name'] | null

    public array $groupComparisonTables = [];

    /* =========================
     * mount
     * ========================= */
    public function mount()
    {
        // 以 group_predictions 最小預測年度推算基準年
        $this->baseYear = (int) DB::table('group_predictions')->min('year') - 1;

        $this->predictionYears = [
            $this->baseYear + 1,
            $this->baseYear + 2,
            $this->baseYear + 3,
        ];

        $this->departments = $this->loadDepartments();
    }

    /* =========================
     * 系科切換
     * ========================= */
    public function updatedSelectedDepartment()
    {
        if (empty($this->selectedDepartment)) {
            $this->resetAll();
            return;
        }

        $this->loadBaseline();
    }

    /* =========================
     * 招生管道切換
     * ========================= */
    public function updatedAdmissionType()
    {
        $this->selectedDepartment = null;
        $this->group21Note       = null;
        $this->departments       = $this->loadDepartments();
        $this->resetAll();
    }

    /* =========================
     * 系科清單（依管道）
     * ========================= */
    private function loadDepartments(): array
    {
        return DB::table('department_group_baselines')
            ->where('admission_type', $this->admission_type)
            ->distinct()
            ->orderBy('DEP_SIMPLE')
            ->pluck('DEP_SIMPLE')
            ->toArray();
    }

    protected function resetAll(): void
    {
        $this->baselinePicked = [];
        $this->baselineYearly = [];
        $this->baselineTotal  = 0;
        $this->baselinePerGroupYear = [];

        $this->scenarioGroups = [];
        $this->scenarioPicked = [];
        $this->scenarioYearly = [];
        $this->scenarioTotal  = 0;
        $this->scenarioPerGroupYear = [];

        $this->baselineSlots = [];
        $this->scenarioSlots = [];
        $this->groupComparisonTables = [];

        $this->emit('updateChart', [
            'years'    => $this->predictionYears,
            'baseline' => array_fill_keys($this->predictionYears, 0),
            'scenario' => array_fill_keys($this->predictionYears, 0),
        ]);
    }

    /* =========================
     * Baseline 載入
     * ========================= */
    protected function loadBaseline()
    {
        $rows = DB::table('department_group_baselines')
            ->where('DEP_SIMPLE', $this->selectedDepartment)
            ->where('admission_type', $this->admission_type)
            ->get(['group_id', 'group_name']);

        $this->baselinePicked = $rows
            ->take(3)
            ->map(fn($r) => [
                'group_id'   => (string)$r->group_id,
                'group_name' => $r->group_name,
            ])->toArray();

        if (empty($this->baselinePicked)) {
            $this->resetAll();
            return;
        }

        // 第21群（資管類）特殊說明：此群係從第09群商管群獨立劃分，預測資料以第09群計算
        // 使用 (int) 轉型，相容 DB 欄位為整數 21、字串 '21' 或 '021' 等各種格式
        $has21 = collect($this->baselinePicked)
            ->contains(fn($g) => (int)$g['group_id'] === 21);

        if ($has21) {
            $g09InBaseline = collect($this->baselinePicked)
                ->contains(fn($g) => (int)$g['group_id'] === 9);

            $this->group21Note = $g09InBaseline
                // 兩者都在 baseline：說明 21 資料引用 09，但 scenario 手動選擇
                ? '※ 第21群「資管類」係從第09群「商管群」報考人數中獨立劃分之名額，兩群預測資料均以第09群計算。新群類別選單中第21群對應欄位請自行選擇替代群別。'
                // 只有 21（一般情況）：說明已自動對照 09
                : '※ 第21群「資管類」係從第09群「商管群」報考人數中獨立劃分之名額，預測資料以第09群計算；系統已自動將第09群列為對照群別，如需可手動調整。';
        } else {
            $this->group21Note = null;
        }

        $ids = array_column($this->baselinePicked, 'group_id');

        // ── 資料查詢層：第21群在 group_predictions 無資料，改以第09群資料替代 ──
        // queryIds：將 21 替換為 09 後去重，避免 baseline 同時含 09+21 時重複查詢
        $group09Meta = $has21 ? $this->fetchGroup09Meta() : null;
        $g09id       = $group09Meta ? $group09Meta['group_id'] : null;

        $queryIds = $has21
            ? array_unique(array_map(fn($id) => ((int)$id === 21) ? $g09id : $id, $ids))
            : $ids;

        $this->baselineYearly       = $this->sumByYear($queryIds);
        $this->baselineTotal        = array_sum($this->baselineYearly);
        $this->baselinePerGroupYear = $this->fetchPerGroupYear($queryIds);

        // 將 09 的預測資料複製到 '21' 鍵，讓 buildGroupComparisonTables 用 baseline group_id='21' 查得到
        if ($has21 && $g09id && isset($this->baselinePerGroupYear[$g09id])) {
            $this->baselinePerGroupYear['21'] = $this->baselinePerGroupYear[$g09id];
        }

        // ── 初始化 slot（關鍵） ──
        $this->initBaselineScenarioSlots();

        // 預設 scenario = baseline，但排除第21群（不在 group_predictions / checkbox 選單中）
        $this->scenarioGroups = array_values(
            array_filter($ids, fn($id) => (int)$id !== 21)
        );

        // 若過往有第21群，且 09 群「不在」此系科的 baseline 中，才自動預填 09
        // （若 baseline 已有 09，則 09 已佔一個 slot，不再重複填入，留空讓使用者自選）
        if ($has21) {
            $group09AlreadyInBaseline = collect($this->baselinePicked)
                ->contains(fn($g) => (int)$g['group_id'] === 9);

            if (!$group09AlreadyInBaseline) {
                // 找到 scenario 中 group 21 對應的空 slot，填入 group 09
                foreach ($this->baselineSlots as $slot => $b) {
                    if ($b && (int)$b['group_id'] === 21) {
                        $this->scenarioSlots[$slot] = $group09Meta;
                        break;
                    }
                }
                // 將 09 加入勾選清單（嚴格比對避免重複）
                if (!in_array($g09id, $this->scenarioGroups, true)) {
                    $this->scenarioGroups[] = $g09id;
                }
            }
            // 若 baseline 已有 09：21 的 scenario slot 維持 null，讓使用者自行選擇
        }

        $this->recalculateScenario();
    }

    /* =========================
     * Slot 初始化（關鍵）
     * ========================= */
    protected function initBaselineScenarioSlots(): void
    {
        $this->baselineSlots = [];
        $this->scenarioSlots = [];

        $slot = 1;
        foreach ($this->baselinePicked as $b) {
            if ($slot > 3) break;

            $this->baselineSlots[$slot] = $b;
            // 第21群不預設帶入 scenario：因 group_predictions 無此群資料且 checkbox 選單上沒有此選項，
            // 讓使用者自行在該 slot 選擇替代群別；baseline 欄位仍保留以供比較表顯示
            // 使用 (int) 轉型相容各種 DB 格式（整數 21、'21'、'021' 等）
            $this->scenarioSlots[$slot] = ((int)$b['group_id'] === 21) ? null : $b;
            $slot++;
        }

        for (; $slot <= 3; $slot++) {
            $this->baselineSlots[$slot] = null;
            $this->scenarioSlots[$slot] = null;
        }
    }

    /* =========================
     * Scenario 勾選變更
     * ========================= */
    public function updatedScenarioGroups()
    {
        // 🔒 未選系科直接 return（避免報錯）
        if (empty($this->baselineSlots)) {
            $this->scenarioGroups = [];
            return;
        }

        if (count($this->scenarioGroups) > 3) {
            $this->scenarioGroups = array_slice($this->scenarioGroups, 0, 3);
            $this->warning = '最多只能選擇 3 個群類別';
            return;
        }

        $this->warning = null;

        $this->syncScenarioSlots();
        $this->recalculateScenario();
    }

    /* =========================
     * Slot 對齊規則（核心邏輯）
     * ========================= */
    protected function syncScenarioSlots(): void
{
    // 1️⃣ 移除被取消的（不補位）
    foreach ($this->scenarioSlots as $slot => $val) {
        if ($val && !in_array($val['group_id'], $this->scenarioGroups, true)) {
            $this->scenarioSlots[$slot] = null;
        }
    }

    // 2️⃣ 新勾選的群，依序塞回 slot
    foreach ($this->scenarioGroups as $gid) {
        $gid = (string)$gid;

        // 已存在於 slot 中就略過
        if ($this->slotContains($gid)) continue;

        // 2-1️⃣ baseline 同群 → 回到原 slot
        foreach ($this->baselineSlots as $slot => $b) {
            if ($b && $b['group_id'] === $gid && $this->scenarioSlots[$slot] === null) {
                $this->scenarioSlots[$slot] = $this->fetchGroupMeta($gid);
                continue 2;
            }
        }

        // 2-2️⃣ baseline 有值、scenario 空 → 維持對位
        foreach ($this->scenarioSlots as $slot => $val) {
            if ($val === null && $this->baselineSlots[$slot] !== null) {
                $this->scenarioSlots[$slot] = $this->fetchGroupMeta($gid);
                continue 2;
            }
        }

        // ✅ 2-3️⃣ fallback：任何空 slot（包含 baselineSlots 為 null）
        foreach ($this->scenarioSlots as $slot => $val) {
            if ($val === null) {
                $this->scenarioSlots[$slot] = $this->fetchGroupMeta($gid);
                break;
            }
        }
    }
}


    protected function slotContains(string $gid): bool
    {
        foreach ($this->scenarioSlots as $s) {
            if ($s && $s['group_id'] === (string)$gid) return true;
        }
        return false;
    }

    protected function fetchGroupMeta(string $gid): array
    {
        $row = DB::table('group_predictions')
            ->where('group_id', $gid)
            ->first();

        return [
            'group_id'   => (string)$gid,
            'group_name' => $row->group_name ?? '—',
        ];
    }

    /**
     * 專用於查找第09群（商管群）：以 CAST 相容整數/字串各種 DB 儲存格式
     */
    private function fetchGroup09Meta(): array
    {
        $row = DB::table('group_predictions')
            ->whereRaw('CAST(group_id AS INT) = 9')
            ->first(['group_id', 'group_name']);

        return [
            'group_id'   => $row ? (string)$row->group_id : '09',
            'group_name' => $row ? $row->group_name : '商管群',
        ];
    }

    /* =========================
     * Scenario 重算
     * ========================= */
    protected function recalculateScenario()
    {
        $ids = array_values(
            array_filter(array_map(
                fn($s) => $s['group_id'] ?? null,
                $this->scenarioSlots
            ))
        );

        $this->scenarioPicked = array_values(
            array_filter($this->scenarioSlots)
        );

        $this->scenarioYearly = empty($ids)
            ? array_fill_keys($this->predictionYears, 0)
            : $this->sumByYear($ids);

        $this->scenarioTotal = array_sum($this->scenarioYearly);
        $this->scenarioPerGroupYear = $this->fetchPerGroupYear($ids);

        $this->buildGroupComparisonTables();

        $this->emit('updateChart', [
            'years'    => $this->predictionYears,
            'baseline' => $this->baselineYearly,
            'scenario' => $this->scenarioYearly,
        ]);
    }

    /* =========================
     * 明細表組裝
     * ========================= */
    protected function buildGroupComparisonTables(): void
    {
        $this->groupComparisonTables = [];

        for ($slot = 1; $slot <= 3; $slot++) {
            $b = $this->baselineSlots[$slot];
            $s = $this->scenarioSlots[$slot];

            if (!$b && !$s) continue;

            $rows = [];
            foreach ($this->predictionYears as $y) {
                $bCount = $b ? ($this->baselinePerGroupYear[$b['group_id']][$y] ?? 0) : 0;
                $sCount = $s ? ($this->scenarioPerGroupYear[$s['group_id']][$y] ?? 0) : 0;

                $rows[] = [
                    'year' => $y,
                    'baseline' => ['count' => $bCount],
                    'scenario' => ['count' => $sCount],
                ];
            }

            $this->groupComparisonTables[] = [
                'index' => $slot,
                'baseline_group' => $b['group_name'] ?? '—',
                'scenario_group' => $s['group_name'] ?? '—',
                'rows' => $rows,
            ];
        }
    }

    /* =========================
     * DB helper
     * ========================= */
    protected function sumByYear(array $groupIds): array
    {
        $rows = DB::table('group_predictions')
            ->select('year', DB::raw('SUM(predicted_count) as total'))
            ->whereIn('group_id', $groupIds)
            ->whereIn('year', $this->predictionYears)
            ->groupBy('year')
            ->get();

        $out = array_fill_keys($this->predictionYears, 0);
        foreach ($rows as $r) {
            $out[$r->year] = (int)$r->total;
        }
        return $out;
    }

    protected function fetchPerGroupYear(array $groupIds): array
    {
        if (empty($groupIds)) return [];

        $rows = DB::table('group_predictions')
            ->select('group_id', 'year', DB::raw('SUM(predicted_count) as total'))
            ->whereIn('group_id', $groupIds)
            ->whereIn('year', $this->predictionYears)
            ->groupBy('group_id', 'year')
            ->get();

        $map = [];
        foreach ($rows as $r) {
            $map[(string)$r->group_id][$r->year] = (int)$r->total;
        }

        foreach ($groupIds as $gid) {
            $map[(string)$gid] = $map[(string)$gid] ?? array_fill_keys($this->predictionYears, 0);
        }

        return $map;
    }

    public function render()
    {
        $groups = DB::table('group_predictions')
            ->select('group_id', 'group_name')
            ->groupBy('group_id', 'group_name')
            ->orderBy('group_id')
            ->get();

        return view('livewire.enrollment-dashboard', compact('groups'));
    }
}
