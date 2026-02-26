@extends("temp")
@section("title")
{{(int)$nowyear}}學年度退學人數分析-校
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
  <div class="col text-center" style="background-color:rgb(33,66,109);">
    <a href="s_dropout?year={{$nowyear}}" style="color:white;" >校</a>
  </div>
  <div class="col text-center" >
    <a href="s_dropout_college?year={{$nowyear}}">院</a>
  </div>
  <div class="col text-center" >
    <a href="s_dropout_department?value=學士班(日間)&year={{$nowyear}}">系</a>
  </div>
</div>
</div>
<div class="fontvmin" style="font-family:Microsoft JhengHei;width:100%;padding:2%">
<h6>本頁面單位為:人數(退學率%)</h6>
<div class="container-fluid">
    {{-- STU_SUM --}}
    <table width="100%" class="shadow-lg ">
        <tr>
            <td align="center" width=50% style="padding:15px">
                <img src="img/student.png" style="width:60%;-webkit-filter:grayscale(1)">
            </td>
            <td align="center">
                <span style="font-size:5vw;font-family:Microsoft JhengHei;font-weight:bold;">
                退學總人數
                    <br>
                    <span style="color:red;font-weight:bold;">

                    {{  (int)($SP_ED_SUM->sum)}}
                    <span style='font-size:4vw'>(
                        {{(round($SP_ED_SUM->sum/$STU_SUM->t,3)*100)}}
                    %)</span>
                    </span>
                    <br>
                </span>
            </td>
        </tr>
    </table>
    <div class="row">
        {{-- SYSTEM_TYPE --}}
        <div class="col-md-4" style="margin:10px 0">
            <table width=100% >
                <tr>
                    <td align="left" class="tlfontvmin">
                        <div style="display: flex;align-items:center;">
                            <img src="img/Academic Program.png" style="width:10vmin;">
                            <span style="font-weight:bolder;">各部別學生人數</span>
                        </div>
                    </td>
                </tr>
                <tr>

                    <td align="left" style="width:70%;padding:5px;color:#6F7678">   
                        <ul>
                          
                          
                          @for($i=0;$i<count($SYSTEM_TYPE);$i++)
                            <li style="font-size:26px;">
                                {{$SYSTEM_TYPE[$i]->SYSTEM_TYPE}}：{{(int)$SYSTEM_TYPE[$i]->DP_SUM}}
                                <span style='font-size:15px'>(     
                               {{ (round($SYSTEM_TYPE[$i]->DP_SUM/$SYSTEM_TYPE_all[$i]->DP_SUM,3)*100) }}
                                 %)</span>
                            </li>
                          
                            @endfor
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        {{-- SCH_SYS --}}
        <div class="col-md-4" style="margin:10px 0">
            <table  width=100% border="0" >
                <tr>
                    <td align="left"  class="tlfontvmin" >
                        <div style="display: flex;align-items:center;">
                            <img src="img/diploma.png" style="width:10vmin;"><b>各學制學生人數</b>
                        </div>    
                    </td>
                </tr>
                <tr>
                    <td align="left" style="width:70%;padding:5px;color:#6F7678">
                        <ul>
                            @foreach($SCH_SYS as $SCH_SYS)
                            <li style="font-size:26px;">
                                {{$SCH_SYS->SCH_SYS}}：{{(int)$SCH_SYS->DP_SUM}}
                                <span style='font-size:15px'>(
                                        {{(round($SCH_SYS->DPpi,3)*100)}}
                                %)</span>
                            </li>
                            @endforeach
                           
                            
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
        {{-- College --}}
        <div class="col-md-4" style="margin:10px 0">
            <table width=100% border="0">
                <tr>
                    <td align="left"  class="tlfontvmin">
                        <div style="display: flex;align-items:center;">
                            <img src="img/College.png" style="width:10vmin;"><b>各學院學生人數</b>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left" style="width:70%;padding:5px;color:#6F7678">
                        <ul>
                            @foreach($College as $College)
                            <li style="font-size:26px;">
                                {{$College->COL}}：{{(int)$College->DP_SUM}}
                                <span style='font-size:15px'>(
                                  {{(round($College->DPpi,3)*100)}}
                            %)</span>
                            </li>
                            @endforeach
                          
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <table  width=100% border="0">
        <tr>
            <td align="center" style="font-size:3vw;">
                <div class="row" style="font-size:16px;font-family:Microsoft JhengHei;width:100%;padding:0%"> 
                    <div class="col-md-6">   
                        <p align="left" style="font-size:6vmin;font-weight:bold;">全臺技專校院休學率前十低：</p>
                        <table class="table table-striped">
                            <tr>
                                <td>排名</td>
                                <td>學校名稱(在學總人數)</td>
                                <td>退學人數</td>
                                <td>退學比例</td>  
                            </tr>
                            
                            @for($x=0 ; $x<10; $x++)
                                @php
                                    $name = $STU_SCH[$x]->SCH_NAME;
                                    
                                @endphp
                                
                                @if ( $name == $schoolname)
                                    <tr style='color:red;font-weight:bold;'> 
                                @else
                                    <tr>
                                @endif
                                        <td>{{$x+1}}</td>
                                        <td>{{$STU_SCH[$x]->SCH_NAME}}({{(int)$STU_SCH[$x]->STU_SUM}})</td>
                                        <td>{{(int)$STU_SCH[$x]->SP_SUM}}</td>
                                        <td>{{($STU_SCH[$x]->DPpi*100)}}%</td>  
                                    </tr>  
                            @endfor

                        </table>
                        <hr>
                    </div>

                    <div class="col-md-6">
                        <p style="font-size:6vmin;font-weight:bold;">歷年國立技專院校退學率比較圖:</p>
                        <div id="container" style="max-width:90vw;"></div>
                        <hr>
                    </div>
                </div>
                </div>
            </td>
        </tr>
    </table>
                
</div>

<script>
    Highcharts.chart('container', {
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
            //'103','104','105','106','107','108'
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
            //以SCH_NAME做整理
            $NUMSQL = collect($NUMSQL)->groupby("SCH_NAME");
        @endphp

        @foreach($NUMSQL as $STU_NAME => $NUM) 
            //前十名的學校
            //name = XX大學
            {name:'{{ $STU_NAME }}',
            @php
            //$join6 該學校6年的資料
            $join6 = $NUM->pluck("sum");
            $multiplied = $join6->map(function ($item, $key) {
             return $item*100;
            });
            $join=$multiplied->toArray();
            $join = join(",",$join);
            @endphp
            //放入該學校的歷年人數
            data:[{{ $join }}]},
        @endforeach   


        ]
      
    });
</script>
@stop