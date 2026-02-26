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
        $this->baseYear = DB::table('College_System')->max('AD_YEAR');

        $this->predictionYears = [
            $this->baseYear + 1,
            $this->baseYear + 2,
            $this->baseYear + 3,
        ];

        $this->departments = DB::table('College_System')
            ->where('SYSTEM_TYPE', '日間部')
            ->where('SCH_SYS', '學士班(日間)')
            ->where('AD_YEAR', $this->baseYear)
            ->groupBy('DEP_SIMPLE')
            ->orderBy('DEP_SIMPLE')
            ->pluck('DEP_SIMPLE')
            ->toArray();
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

        $ids = array_column($this->baselinePicked, 'group_id');

        $this->baselineYearly = $this->sumByYear($ids);
        $this->baselineTotal  = array_sum($this->baselineYearly);
        $this->baselinePerGroupYear = $this->fetchPerGroupYear($ids);

        // 初始化 slot（關鍵）
        $this->initBaselineScenarioSlots();

        // 預設 scenario = baseline
        $this->scenarioGroups = $ids;

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
            $this->scenarioSlots[$slot] = $b; // 初始 = baseline
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
