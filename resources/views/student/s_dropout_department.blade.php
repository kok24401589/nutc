@extends("temp")
@section("title")
{{(int)$nowyear}}學年度退學人數分析-系
@stop
{{-- ✅ 菜單連結已由 MenuComposer 統一處理，無需在此定義 --}}

@section("content")
<style type="text/css">
    .col{
        border:1px solid rgb(33,66,109);
    }

</style>
<div class="container-fluid">
<div class="row" style="font-size:36px;font-family:Microsoft JhengHei;">
  <div class="col text-center">
    <a href="s_dropout?year={{$nowyear}}">校</a>
  </div>
  <div class="col text-center" >
    <a href="s_dropout_college?year={{$nowyear}}">院</a>
  </div>
  <div class="col text-center" style="background-color:rgb(33,66,109);">
    <a href="s_dropout_department?value=學士班(日間)&year={{$nowyear}}" style="color:white;" >系</a>
  </div>
</div>
</div>
<script>
function express學士班日間(){
var value="學士班(日間)";
location.href="s_dropout_department?year={{$nowyear}}&value=" +value;
}

function express碩士班日間(){
var value="碩士班(日間)";
location.href="s_dropout_department?year={{$nowyear}}&value=" +value;
}

function express學士班進修(){
var value="學士班(進修)";
location.href="s_dropout_department?year={{$nowyear}}&value=" +value;
}
      
function express五專(){
var value="五專";
location.href="s_dropout_department?year={{$nowyear}}&value=" +value;
}
      
function express碩士在職專班(){
var value="碩士在職專班";
location.href="s_dropout_department?year={{$nowyear}}&value=" +value;
}
function express總人數(){
var value="總人數";
location.href="s_dropout_department?year={{$nowyear}}&value=" +value;
}
</script>
@php

if($_GET['value']=="學士班(日間)")
{
    $b1="btn btn-info";
    $b2="btn btn-secondary";
    $b3="btn btn-secondary";
    $b4="btn btn-secondary";
    $b5="btn btn-secondary";
    $b6="btn btn-secondary";
}
elseif($_GET['value']=="五專"){
    $b1="btn btn-secondary";
    $b2="btn btn-success";
    $b3="btn btn-secondary";
    $b4="btn btn-secondary";
    $b5="btn btn-secondary";
    $b6="btn btn-secondary";
}    
elseif($_GET['value']=="碩士班(日間)"){
    $b1="btn btn-secondary";
    $b2="btn btn-secondary";
    $b3="btn btn-danger";
    $b4="btn btn-secondary";
    $b5="btn btn-secondary";
    $b6="btn btn-secondary";
}
elseif($_GET['value']=="碩士在職專班"){
    $b1="btn btn-secondary";
    $b2="btn btn-secondary";
    $b3="btn btn-secondary";
    $b4="btn btn-warning";
    $b5="btn btn-secondary";
    $b6="btn btn-secondary";
}        
elseif($_GET['value']=="學士班(進修)"){
    $b1="btn btn-secondary";
    $b2="btn btn-secondary";
    $b3="btn btn-secondary";
    $b4="btn btn-secondary";
    $b5="btn btn-primary";
    $b6="btn btn-secondary";
}
elseif($_GET['value']=="總人數"){
    $b1="btn btn-secondary";
    $b2="btn btn-secondary";
    $b3="btn btn-secondary";
    $b4="btn btn-secondary";
    $b5="btn btn-secondary";
    $b6="btn btn-danger";
}
else{
    $b1="btn btn-secondary";
    $b2="btn btn-secondary";
    $b3="btn btn-secondary";
    $b4="btn btn-secondary";
    $b5="btn btn-secondary";
    $b6="btn btn-secondary";
}   

@endphp
<table  width=100% border="0">
    <tr>
      <td colspan="3">

        <input type="button" class="<?php echo $b1;?>" id="b1" value="學士班日間" onclick="express學士班日間();" style="width:120px;margin:5px">
        <input type="button" class="<?php echo $b2;?>" value="五專" onclick="express五專()"style="width:120px;margin:5px">
        <input type="button" class="<?php echo $b3;?>" value="碩士班日間" onclick="express碩士班日間()"style="width:120px;margin:5px">
        <input type="button" class="<?php echo $b4;?>" value="碩士在職專班" onclick="express碩士在職專班()"style="width:120px;margin:5px">
        <input type="button" class="<?php echo $b5;?>" value="學士班進修" onclick="express學士班進修()"style="width:120px;margin:5px">
        <input type="button" class="<?php echo $b6;?>" value="總人數" onclick="express總人數()"style="width:120px;margin:5px">
        
        <div class="row" style="font-size:20px;font-family:Microsoft JhengHei;width:100%;padding:0%">
            @php
                //以College做整理
                $NUM = collect($NUM)->groupby("College");
                // dd($NUM);
            @endphp
            @foreach($NUM as $college => $colrow)
                @php
                    // department 科系
                    // 以DEP_SIMPLE做整理
                    // $deps = collect($colrow)->groupby("DEP_SIMPLE");

                    // foreach($deps as $dep => $sum){
                    
                    // //拉取各科系6年資料並合併
                    // $join6 = $sum->pluck("STU_SUM")->toArray();
                    // dd($join6);
                    // $join6 = join(",",$join6);
                    // }
                @endphp
                <div class="col-md-6" style="margin:0 0 50px 0">
                    {{-- 商學院歷年學士班(日間)各系人數折線圖: --}}
                    {{$college}}歷年<span>{{$educational}}</span>各系人數折線圖:<br>
                    <div id="CID{{ $loop->index }}" style="max-width:90vw;"></div>
                </div>
            @endforeach
          </div>  
            

        </div>
       </td> 
    </tr>        
</table>

@stop

@push('scripts')
<script>
// 輪詢等待 Highcharts 載入完成，最多等待 5 秒
(function initCharts() {
    var maxAttempts = 50;
    var attempts = 0;
    
    function tryInit() {
        attempts++;
        
        if (typeof Highcharts === 'undefined') {
            if (attempts >= maxAttempts) {
                console.error('Highcharts 超時未載入');
                alert('Highcharts 圖表庫載入失敗，請刷新頁面重試。');
                return;
            }
            setTimeout(tryInit, 100);
            return;
        }
        
        @foreach($NUM as $college => $colrow)
            @php
                $deps = collect($colrow)->groupby("DEP_SIMPLE");
            @endphp
            
            try {
                Highcharts.chart('CID{{ $loop->index }}', {
                        chart: {
                        type: 'line',
                        marginLeft: 0,
                        marginRight: 0,
                        marginTop: 40,
                        },
                        title: {
                            text:'',
                        },
                        credits: {
                          enabled: false   //刪除右下標籤
                        },    
                        xAxis: {
                            categories: [
                               @php  
                                $beforey = $nowyear-5; 
                                for($i=$beforey;$i<=$nowyear;$i++){
                                    echo "'".$i."年',";
                                } 
                               @endphp
                            ]
                        },
                        yAxis: {
                            labels: {
                                align: 'left',
                                x: 0,
                                y: -2
                            }
                        },
                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: false
                                },
                                enableMouseTracking: true
                            }
                        },
                        tooltip: {
                            formatter: function () {
                                return '<b>' + this.x + ' ' + this.series.name +' </b><br/>總共: ' + this.y + '%';
                            }
                        },    
                        series: [
                            @php
                                //department 科系
                                //以DEP_SIMPLE做整理
                                $deps = collect($colrow)->groupby("DEP_SIMPLE");
                            @endphp
                            @foreach($deps as $dep => $sum)
                                @php
                                        //拉取各科系6年資料並合併
                                        $join6 = $sum->pluck("STU_SUM");
                                        $multiplied = $join6->map(function ($item, $key) {
                                            return $item *100;
                                        });
                                        $join6 = $multiplied->toArray();
                                        $join6 = join(",",$join6);
                                @endphp
                                {
                                    name:'{{ $dep }}',
                                    data:[{{ $join6 }}]
                                },
                            @endforeach
                        ]
                });
            } catch(e) {
                console.error('Failed to create chart CID{{ $loop->index }}:', e);
            }
        @endforeach
    }
    
    tryInit();
})();
</script>
@endpush