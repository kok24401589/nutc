<div class="container-fluid px-4">



<div class="container mt-4">
    <div class="alert alert-info mb-3 text-center">
        <span class="font-weight-bold">
            本次預測係依據
            <strong>{{ $baseYear }}</strong> 年度資料，
            推估
            <strong>
                {{ $predictionYears[0] }}–{{ $predictionYears[count($predictionYears)-1] }}
            </strong>
            年報考人數趨勢。
        </span>
    </div>
</div>

    {{-- 系科選擇 --}}
    <div class="card mb-4">
        <div class="card-body">
            <label><strong>選擇系科</strong></label>
            <select class="form-control" wire:model="selectedDepartment">
                <option value="">請選擇系科</option>
                @foreach($departments as $dep)
                    <option value="{{ $dep }}">{{ $dep }}</option>
                @endforeach
            </select>
        <!-- </div>
    </div> -->

{{-- Baseline --}}
<!-- <div class="card mb-4">
    <div class="card-body"> -->
        @php
    $baselineCount = count($baselinePicked ?? []);
@endphp

<h5 style="margin-top: 10px">
    <strong>{{ $baseYear }}</strong> 年度該系科招收群類別

    @if($baselineCount > 0 && $baselineCount < 3)
        <span class="badge badge-warning ml-2">
            該系科僅招 {{ $baselineCount }} 群類別
        </span>
    @endif
</h5>

@if(empty($selectedDepartment))
    {{-- 尚未選取系科 --}}
    <div class="text-muted">尚未選取系科</div>

@elseif($baselineCount === 0)
    {{-- 已選系科，但沒有歷史群類別 --}}
    <div class="text-muted">
        因該系科為第一次招生或非四技招生系科，故無過往招生群類別。
    </div>

@else
    {{-- 正常顯示 baseline 群類別 --}}
    <div class="mb-2">
        @foreach($baselinePicked as $g)
            <span class="badge badge-secondary mr-1"
                  style="font-size: 1rem; padding: 0.5em 0.75em;">
                {{ $g['group_id'] }} {{ $g['group_name'] }}
            </span>
        @endforeach
    </div>
@endif


    </div>
</div>

{{-- Scenario --}}
<div class="card mb-4">
    <div class="card-body">
        <h5>挑選新群類別試算（最多 3 群）</h5>
        <div class="row">
            @foreach($groups as $group)
                @php
                    $selected = in_array($group->group_id, $scenarioGroups ?? []);
                    $disableNew = is_array($scenarioGroups)
                        && count($scenarioGroups) >= 3
                        && !$selected;
                @endphp

                <div class="col-md-3 mb-2">
                    <label class="{{ $disableNew ? 'text-muted' : '' }}">
                        <input type="checkbox"
                               wire:model="scenarioGroups"
                               value="{{ $group->group_id }}"
                               {{ empty($selectedDepartment) ? 'disabled' : '' }}>
                        {{ $group->group_id }} {{ $group->group_name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>




<div class="card mb-4">
    <div class="card-body">
        <h5>各群別報考人數比較</h5>

        @if(empty($groupComparisonTables))
            <div class="text-muted">請先選擇系科以產生比較表。</div>
        @else
            @foreach($groupComparisonTables as $table)
                <div class="border rounded p-3 mb-4">
                    <h6 class="font-weight-bold mb-3">第 {{ $table['index'] }} 群別</h6>

                    <table class="table table-sm table-bordered text-center mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:120px;">年度</th>

                                <th style="width:40%;" class="text-center">
                                        原群類別
                                    <div class="mt-1">
                                            @if($table['baseline_group'] !== '—')
                                        <span class="badge badge-secondary">
                                            {{ $table['baseline_group'] }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                    </div>
                                </th>


                                <th style="width:40%;">
                                    新群類別
                                    @if($table['scenario_group'] !== '—')
                                        <div class="mt-1">
                                            <span class="badge badge-info">
                                                {{ $table['scenario_group'] }}
                                            </span>
                                        </div>
                                    @endif
                                </th>

                                <th style="width:20%;">
                                    差值<br>
                                    <small class="text-muted">新 − 原</small>
                                </th>
                            </tr>
                            </thead>
                        <tbody>
                        @foreach($table['rows'] as $r)
                            @php
                                $baselineCount = is_array($r['baseline'])
                                    ? ($r['baseline']['count'] ?? 0)
                                    : ($r['baseline'] ?? 0);

                                $scenarioCount = is_array($r['scenario'])
                                    ? ($r['scenario']['count'] ?? 0)
                                    : ($r['scenario'] ?? 0);

                                $delta = $scenarioCount - $baselineCount;
                            @endphp
                            <tr>
                                <td>{{ $r['year'] }}</td>

                               <td>{{ number_format($baselineCount) }}</td>

                                <td>{{ number_format($scenarioCount) }}</td>

                                <td class="{{ $delta > 0 ? 'text-success' : ($delta < 0 ? 'text-danger' : 'text-muted') }}">
                                    {{ number_format($delta) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </div>
            @endforeach
        @endif
    </div>
</div>

{{-- Comparison --}}
<div class="card mb-4">
    <div class="card-body">
        <h6 class="font-weight-bold">招收群類別總人數比較</h6>

        @if($warning)
            <div class="alert alert-warning">{{ $warning }}</div>
        @endif

        <table class="table table-sm table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>年度</th>
                    <th class="text-right">原群類別</th>
                    <th class="text-right">新群類別</th>
                    <th class="text-right">差值(新-原)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($predictionYears as $y)
                    <tr>
                        <td>{{ $y }}</td>
                        <td class="text-right">{{ number_format($baselineYearly[$y] ?? 0) }}</td>
                        <td class="text-right">{{ number_format($scenarioYearly[$y] ?? 0) }}</td>
                        @php
                            $delta = ($scenarioYearly[$y] ?? 0) - ($baselineYearly[$y] ?? 0);
                        @endphp

                        <td class="text-right
                            {{ $delta > 0 ? 'text-success' : ($delta < 0 ? 'text-danger' : 'text-muted') }}">
                            {{ number_format($delta) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-weight-bold">
                    <td>三年合計</td>
                    <td class="text-right">{{ number_format($baselineTotal) }}</td>
                    <td class="text-right">{{ number_format($scenarioTotal) }}</td>
                    @php
                    $totalDelta = $scenarioTotal - $baselineTotal;
                @endphp

                <td class="text-right
                    {{ $totalDelta > 0 ? 'text-success' : ($totalDelta < 0 ? 'text-danger' : 'text-muted') }}">
                    {{ number_format($totalDelta) }}
                </td>
                </tr>
            </tfoot>
        </table>


        <div class="border-top pt-3 mt-4" wire:ignore>
    <h6 class="text-muted mb-2">招收群類別報考人數趨勢比較</h6>

    <div style="height: 280px;">
        <canvas id="comparisonChart"></canvas>
    </div>
</div>


    </div>
</div>


</div>
