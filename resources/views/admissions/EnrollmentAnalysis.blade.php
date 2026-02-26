@extends("temp")
@section("title")
{{$nowyear}}學年度入學管道分析-校
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
        <td style="background-color:rgb(33,66,109);border:1px solid rgb(33,66,109);">
            <a style="color:white;">校</a></td>
        <td>
            <a href="EnrollmentAnalysisDepartment?value=資訊工程系&year={{$nowyear}}">系</a>
        </td>
    </tr>
</table>
<div id="container" style="min-width: 200px;max-width: 600px;margin: 0 auto;"></div>
<div style="text-align:center">
    <span class="badge" style="background-color:#99FF99;">技優甄審</span>
    <span class="badge" style="background-color:#FFFFBB;">申請入學</span>
    <span class="badge" style="background-color:#CCEEFF;">甄選入學</span>
    <span class="badge" style="background-color:#FF8888;">其他</span>
</div>
@stop

@push('scripts')
<script>
    Highcharts.chart('container', {
        plotOptions: {
            series: {
                turboThreshold: 2000000
            }
        },
        series: [{
            type: 'treemap',
            name: '不分校',
            layoutAlgorithm: 'squarified',
            allowDrillToNode: true,
            animationLimit: 1000,
            dataLabels: {
                enabled: false
            },
            levelIsConstant: false,
            levels: [{
                level: 1,
                dataLabels: {
                    enabled: true
                },
                borderWidth: 3,
                borderColor: '#496d9c',
            },{
                level: 2,
                borderColor: 'white',
            }],
            data:[
                @php
                    $tempS = "";
                    $tempD = "";
                @endphp
                @foreach($EnrollmentAna as $EA)
                    @if($EA->入學前學校 != $tempS)
                        @php
                            $tempS = $EA->入學前學校;
                            $tempD = $EA->入學前學校科組;
                        @endphp

                            {name:'{{$EA->入學前學校}}',
                             id:'id-{{ $EA->入學前學校 }}',
                            },
                            {name: '{{$EA->入學前學校科組}}',
                             id:'id-{{ $EA->入學前學校 }}-{{$EA->入學前學校科組}}',
                             parent: 'id-{{ $EA->入學前學校 }}'
                            },
                            {name: '{{$EA->入學其他分類}}',
                             parent: 'id-{{ $EA->入學前學校 }}-{{$EA->入學前學校科組}}',
                             value: {{$EA->人數}},
                             color:'{{$EA->顏色}}'
                            },
                        
                    @else
                        @if($EA->入學前學校科組 != $tempD)
                            @php
                                $tempD = $EA->入學前學校科組;
                            @endphp

                            {name: '{{$EA->入學前學校科組}}',
                             id:'id-{{ $EA->入學前學校 }}-{{$EA->入學前學校科組}}',
                             parent: 'id-{{ $EA->入學前學校 }}'
                            },
                            {name: '{{$EA->入學其他分類}}',
                             parent: 'id-{{ $EA->入學前學校 }}-{{$EA->入學前學校科組}}',
                             value: {{$EA->人數}},
                             color:'{{$EA->顏色}}'
                            },
                        @else
                        {name: '{{$EA->入學其他分類}}',
                         parent: 'id-{{ $EA->入學前學校 }}-{{$EA->入學前學校科組}}',
                         value: {{$EA->人數}},
                         color:'{{$EA->顏色}}'
                        },
                        @endif
                    @endif
                @endforeach

            ]
        }],

        subtitle: {
            text: '<a href="../EnrollmentAnalysisMore?year={{$nowyear}}">詳細資料</a>'
        },
        title: {
            text: '日間部入學管道分析(四技)前20間',
            style: {
                fontFamily:'Microsoft JhengHei',
                fontSize:'20px'
            }
        },
        credits: {
            enabled: false   //刪除右下標籤
        },
        data:{
            style: {
                fontFamily:'Microsoft JhengHei',
                fontSize:'20px'
            },
        }
    });
</script>
@endpush