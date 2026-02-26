@extends("temp")
@section("title")
{{$nowyear}}學年度學生生源分析-系
@stop

{{-- ✅ 菜單連結已由 MenuComposer 統一處理，無需在此定義 --}}

@section("link")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/9.3.3/modules/data.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/9.3.3/modules/heatmap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/9.3.3/modules/treemap.min.js"></script>
    <style>
        .progwidth {
            max-width: 550px;
        }
        .treemapwidth{
            max-width: 600px;
        }     
        @media screen and (max-width: 766px) {
            .progwidth {
                max-width: 85%;
            }
            .treemapwidth {
                max-width: 100%;    
            }
        }
    </style>
@stop
@section("content")

<table width=100% border="1">
    <tr align="center" style="font-size:36px;font-family:Microsoft JhengHei;">
        <td><a href="treemap?year={{$nowyear}}">校</a></td>
        <td style="background-color:rgb(33,66,109);border:1px solid rgb(33,66,109);">
            <a style="color:white;">系</a>
        </td>
    </tr>
</table>
<div id="container" style="min-width: 200px;max-width: 600px;margin: 0 auto;"></div>
<table> 
    @php
       //以College做整理
       $DEP = collect($Col_DEP)->groupby("College");
   @endphp
   @foreach($DEP as $Col => $deps)
   <tr>
       <td>
           <img src="img/{{$Col}}.png" id="{{$Col}}" style="width:70px;">
       </td>
       <td style="padding:5px">
           <hr style="width:3px;height:80px;background-color:#767676;margin:0px">
       </td>
       <td>
       @foreach($deps as $dp)
           <a href="treemap_department?value={{$dp->DEP_SIMPLE}}&year={{$nowyear}}" class="dep-link" data-dep="{{$dp->DEP_SIMPLE}}" data-year="{{$nowyear}}"><img src="img/{{$dp->DEP_SIMPLE}}.png" class="dep-img" id="{{$dp->DEP_SIMPLE}}" style="width:50px;{{grayscale($dp->DEP_SIMPLE)}}"></a>
       @endforeach
       </td>
   </tr>
   @endforeach
</table>
@php
    function grayscale($value){
        if($value == $_GET["value"]){ echo "-webkit-filter:grayscale(0)";}
        else{ echo "-webkit-filter:grayscale(1)";}
    }
@endphp
@push('scripts')
<script>
    var currentChart = null;
    var currentYear  = '{{ $nowyear }}';

    // 初始資料（由 PHP 直接輸出，避免首次載入多一次 AJAX）
    var initialData = [
        @php
          $temp = "";
          $team = 0;
        @endphp
        @foreach($StudentSourceNumber as $ssn)
            @if($ssn->入學前學校 != $temp)
              @php $temp = $ssn->入學前學校; $team+=1; @endphp
              {name:'{{$temp}}<br/>({{$ssn->學校人數}})' , id:'id-{{ $team }}', color:'{{$ssn->顏色}}'},
              {name:'{{$ssn->入學前學校科組}}<br/>({{$ssn->人數}})' , parent:'id-{{ $team }}', value:{{$ssn->人數}} },
            @else
              {name:'{{$ssn->入學前學校科組}}<br/>({{$ssn->人數}})' , parent:'id-{{ $team }}', value:{{$ssn->人數}} },
            @endif
        @endforeach
    ];

    function renderChart(data, dep, year) {
        if (currentChart) {
            currentChart.destroy();
        }
        currentChart = Highcharts.chart('container', {
            plotOptions: {
                series: { turboThreshold: 2000000 }
            },
            series: [{
                type: 'treemap',
                name: '不分校',
                layoutAlgorithm: 'squarified',
                allowDrillToNode: true,
                animationLimit: 1000,
                dataLabels: { enabled: false },
                levelIsConstant: false,
                levels: [{ level: 1, dataLabels: { enabled: true }, borderWidth: 3 }],
                data: data
            }],
            subtitle: {
                text: '<a href="/treemapmore?value=' + encodeURIComponent(dep) + '&year=' + year + '">詳細資料</a>'
            },
            title: {
                text: '日間部各科系生源分析前20間',
                style: { fontFamily: 'Microsoft JhengHei', fontSize: '20px' }
            },
            credits: { enabled: false }
        });
    }

    // 首次渲染
    renderChart(initialData, '{{ addslashes($_GET["value"] ?? "") }}', currentYear);

    // 點選科系 → AJAX 更新，不整頁刷新
    document.querySelectorAll('.dep-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var dep  = this.dataset.dep;
            var year = this.dataset.year;

            // 更新灰階效果
            document.querySelectorAll('.dep-img').forEach(function(img) {
                img.style.webkitFilter = 'grayscale(1)';
            });
            this.querySelector('img').style.webkitFilter = 'grayscale(0)';

            // 更新網址列（不刷新頁面）
            history.pushState(null, '', 'treemap_department?value=' + dep + '&year=' + year);

            // AJAX 取得圖表資料
            fetch('treemap_department_data?value=' + encodeURIComponent(dep) + '&year=' + encodeURIComponent(year))
                .then(function(res) { return res.json(); })
                .then(function(json) {
                    renderChart(json.data, json.department, json.year);
                })
                .catch(function(err) {
                    console.error('載入科系資料失敗', err);
                });
        });
    });
</script>
@endpush
@stop