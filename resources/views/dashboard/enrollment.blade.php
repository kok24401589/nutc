@extends("temp")
@section("title")
群類招生試算平台
@stop

{{-- ✅ 菜單連結已由 MenuComposer 統一處理，無需在此定義 --}}

@section('content')
    <livewire:enrollment-dashboard />



@endsection
@push('scripts')
<script>
let comparisonChart = null;

document.addEventListener('livewire:load', function () {
    const canvas = document.getElementById('comparisonChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    // 🔹 初始化年份（由後端動態帶入）
    const initialYears = @json($predictionYears ?? []);

    comparisonChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: initialYears.map(String),
            datasets: [
                {
                    label: '原群類別(人數)',
                    data: [],
                    borderColor: '#6c757d',
                    backgroundColor: 'rgba(108,117,125,0.15)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: false
                },
                {
                    label: '新群類別(人數)',
                    data: [],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0,123,255,0.15)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + '：'
                                + context.parsed.y.toLocaleString() + ' 人';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // 🔄 Livewire 即時更新圖表
    Livewire.on('updateChart', data => {
        if (!comparisonChart || !data) return;

        const years = data.years || [];
        const baseline = data.baseline || {};
        const scenario = data.scenario || {};

        comparisonChart.data.labels = years.map(String);

        // ⚠️ 用 years 對齊資料，避免順序錯亂
        comparisonChart.data.datasets[0].data =
            years.map(y => baseline[y] ?? 0);

        comparisonChart.data.datasets[1].data =
            years.map(y => scenario[y] ?? 0);

        comparisonChart.update();
    });
});
</script>
@endpush

