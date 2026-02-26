@extends("temp")
@section("link")
{{-- Highcharts 核心已在 temp.blade.php 載入，此處不需重複 --}}
@stop
@section("title")
{{$nowyear}}學年度教師人數分析-系
@stop
{{-- ✅ 菜單連結已由 MenuComposer 統一處理，無需在此定義 --}}
@section("content")
<style type="text/css">
    .col{
        border:1px solid rgb(33,66,109);
    }

</style>
{{-- 校院系 --}}
<div class="container-fluid">
<div class="row" style="font-size:36px;font-family:Microsoft JhengHei;">
  <div class="col text-center" >
    <a href="teacher?year={{"$nowyear"}}" >校</a>
  </div>
  <div class="col text-center" >
    <a href="teacher_college?year={{"$nowyear"}}">院</a>
  </div>
  <div class="col text-center" style="background-color:rgb(33,66,109);">
    <a href="teacher_department?year={{"$nowyear"}}"style="color:white;">系</a>
  </div>
</div>
<table width=100% border="1">
  <tr>
        <td colspan="3" style="width: 100%;">
            <div style="width:95%"> 
                <div class="row">
                    @foreach($Colrow as $C)
                        <div id='{{$C->college}}' 
                             class='col-md-6' 
                             style='height:500px;
                                    max-width:90vw;'>
                        </div>
                    @endforeach
                <div class="col-md-12" style="height:50px;;"></div>  
                <div id="container" class="col-md-6" style="height:500px;max-width:90vw;display:none"></div>
                <div id="container2" class="col-md-6" style="height:500px;max-width:90vw;display:none"></div>
                </div>
                <table> 
                    <tr>
                        <h3 style="font-weight:bold;font-family:Microsoft JhengHei;text-align:center;">請選擇要比較的科系<img src="img/clear.png"  title="清除" id="清空" style="width:100px;"></h3><br>
                    </tr>
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
                            <img src="img/{{$dp->DEP_SIMPLE}}.png" id="{{$dp->DEP_SIMPLE}}" style="width:50px;-webkit-filter:grayscale(1);">
                        @endforeach
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            
        </td>
        
    </tr>
</table>
</div>
@endsection

@push('scripts')
<script>
    @php
        //以學院做整理
        $numrow = collect($numrow)->groupby("college");
    @endphp
    @foreach($numrow as $college=>$num)
      Highcharts.chart('{{$college}}',{
        chart: {
            type: 'column'
        },
         credits: {
          enabled: false   //刪除右下標籤
        },
        shadow:{color:"false"},
        title: {
            text: '{{$college}}各系教師分布',
            style: {
                        fontFamily:'Microsoft JhengHei',
                        fontSize:'20px'
                    }
        },
    @php
        //以系所名稱做整理
        $nums = collect($num)->groupby("department_simple");
    @endphp
        xAxis: {
            categories: [
                @foreach($nums as $department_simple =>$Nums)
                    '{{$department_simple}}',
                @endforeach
                ],
            labels: {
                    style: {
                        fontFamily:'Microsoft JhengHei',
                        fontSize:'20pt'
                    }
                }
        },
        yAxis: {
            min: 0,
            title: {
                text: '總人數'
            },
            labels: {
                    style: {
                        fontFamily:'Microsoft JhengHei',
                        fontSize:'2vw'
                    }
                },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'center',
            x: 0,
            verticalAlign: 'bottom',
            y: 0,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: true
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>總和: {point.stackTotal}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style:{
                        textOutline:false
                    }
                }
            }
        },
        series: [{
            name: '教授',
            data: [
                    @php
                        $join = $num->pluck("PFS")->toArray();
                        $join = join(",",$join);
                    @endphp
                    {{$join}}
                 ]
        }, {
            name: '副教授',
            data: [
                    @php
                        $join = $num->pluck("ASCPFS")->toArray();
                        $join = join(",",$join);
                    @endphp
                    {{$join}}
                  ]
        }, {
            name: '助理教授',
            data:[
                    @php
                        $join = $num->pluck("ASTPFS")->toArray();
                        $join = join(",",$join);
                    @endphp
                    {{$join}}
                ]
        }, {
            name: '講師',
            data:[
                    @php
                        $join = $num->pluck("LT")->toArray();
                        $join = join(",",$join);
                    @endphp
                    {{$join}}
                ]
        }, {
            name: '其他教師',
            data:[
                    @php
                        $join = $num->pluck("OT_TCH")->toArray();
                        $join = join(",",$join);
                    @endphp
                    {{$join}}
                ]
        }]
      });
    @endforeach
</script>
<script>

  var chart = Highcharts.chart('container', {
    credits: {
      enabled: false   //刪除右下標籤
    },
    title: {
        text: '各科系專任教師人數比較',
        style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'20px'
                }
    },

    xAxis: {
        
        categories: ['教授', '副教授', '助理教授', '講師', '其他教師'],
        labels: {
                style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'20px'
                }
            }
        
    },
      plotOptions :{   
            bar: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true //设置显示对应y的值
                }
            }
        }

});

  var chart2 = Highcharts.chart('container2', {
    credits: {
      enabled: false   //刪除右下標籤
    },
    title: {
        text: '各科系兼任教師人數比較',
        style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'20px'
                }
    },

    xAxis: {
        
        categories: ['教授', '副教授', '助理教授', '講師', '其他教師'],
        labels: {
                style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'20px'
                }
            }
        
    },
      plotOptions :{   
            bar: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true //设置显示对应y的值
                }
            }
        }

});
@foreach($numrowPK as $PK)

var a{{$loop->index}}=0;

    $('#{{$PK->department}}').click(function () {
        document.getElementById('container').style.display = 'block';
        document.getElementById('container2').style.display = 'block';
        if(a{{$loop->index}}==0){
        chart.addSeries({
        type: 'bar',
        name: '{{$PK->department}}',
        data: [{{(int)$PK->PFS}},
               {{(int)$PK->ASCPFS}},
               {{(int)$PK->ASTPFS}},
               {{(int)$PK->LT}},
               {{(int)$PK->OT_TCH}}
        ]
        });
        chart2.addSeries({
        type: 'bar',
        name: '{{$PK->department}}',
        data: [{{(int)$PK->PFS_Both}},
               {{(int)$PK->ASCPFS_Both}},
               {{(int)$PK->ASTPFS_Both}},
               {{(int)$PK->LT_Both}},
               {{(int)$PK->OT_TCH_Both}}]
        });
        a{{$loop->index}}+=1;$(this).css('-webkit-filter','grayscale(0)')}
        else{
            for(i=0;i<chart.series.length;i++){
                if(chart.series[i].name=='{{$PK->department}}'){
                    chart.series[i].remove(true);
                    a{{$loop->index}}=0;$(this).css('-webkit-filter','grayscale(1)')
                }
            }
            for(i=0;i<chart2.series.length;i++){
                if(chart2.series[i].name=='{{$PK->department}}'){
                    chart2.series[i].remove(true);
                    a{{$loop->index}}=0;$(this).css('-webkit-filter','grayscale(1)')
                }
            }
        }
});
@endforeach
$('#清空').click(function () {
    @foreach($numrowPK as $PK)
      a{{$loop->index}}=0;
    @endforeach
        seriesData = [];
        while (chart.series.length > 0) {
          $('#'+chart.series[0].name).css('-webkit-filter','grayscale(1)');
          chart.series[0].remove(true);
        }
        for (var i = 0; i < seriesData.length; i++) {
          chart.addSeries(
          );
        };
        while (chart2.series.length > 0) {
          $('#'+chart2.series[0].name).css('-webkit-filter','grayscale(1)');
        // $(document.getElementById(chart2.series[0].name)).css('-webkit-filter','grayscale(1)');
          chart2.series[0].remove(true);
        }
        for (var i = 0; i < seriesData.length; i++) {
          chart2.addSeries(
          );
        }
    document.getElementById('container').style.display = 'none';
    document.getElementById('container2').style.display = 'none';
});
</script>
@endpush

