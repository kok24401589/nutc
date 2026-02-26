@extends("temp")
@section("title")
四技二專統一入學測驗群(類)別報考人數預測
@stop

{{-- ✅ 菜單連結已由 MenuComposer 統一處理，無需在此定義 --}}

@section("content")



            <style>
    .group-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 8px;
        font-family: Microsoft JhengHei;
    }
</style>

<div class="container-fluid">

    {{-- 標題 --}}
    <div class="row mb-4">
        <div class="col text-center" style="font-size:32px;font-family:Microsoft JhengHei;">
            各群報考人數趨勢與預測結果
        </div>
    </div>

    <div class="row">
        @foreach($GROUPS as $idx => $g)
        <div class="col-md-6 mb-5">
            <div class="group-title">
                {{ $g['GROUP_CODE'] }} {{ $g['GROUP_NAME'] }}
                —  報考人數趨勢（含預測）
            </div>
            <div id="chart_{{ $idx }}"></div>
        </div>

        <script>
        Highcharts.chart('chart_{{ $idx }}', {
            chart: {
                type: 'line',
                height: 420
            },

            title: { text: '' },

            credits: { enabled: false },

            xAxis: {
                categories: {!! json_encode(
                    array_map(fn($y) => $y.'年', $g['YEAR'])
                ) !!},

                plotBands: [{
                    from: {{ array_search($g['FORECAST_START'], $g['YEAR']) - 0.5 }},
                    to: {{ count($g['YEAR']) - 0.5 }},
                    color: 'rgba(200,220,255,0.35)',
                    label: {
                        text: '預測區間（{{ $g["FORECAST_START"] }}–{{ end($g["YEAR"]) }}）',
                        style: { color: '#333' }
                    }
                }]
            },

            yAxis: {
                title: {
                    text: '報考人數'
                }
            },

            tooltip: {
                shared: true,
                valueSuffix: ' 人'
            },

            plotOptions: {
                line: {
                    marker: {
                        enabled: true,
                        radius: 4
                    },
                    lineWidth: 3
                }
            },

            series: [{
                name: '報考人數（實際＋預測）',
                data: {!! json_encode($g['VALUE']) !!},
                color: '#1f77b4'
            }]
        });
        </script>
        @endforeach
    </div>

</div>
  
@stop