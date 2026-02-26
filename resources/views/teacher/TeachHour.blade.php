@extends("temp")
@section("link")
{{--     <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js'></script>
    @stop
@section("title")
{{$nowyear}}學年專任教師每週授課時數-校
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
{{-- <div class="row" style="font-size:36px;font-family:Microsoft JhengHei;">
  <div class="col text-center" >
    <a href="{{url("teacher")}}" >校</a>
  </div>
  <div class="col text-center" >
    <a href="{{ url("teacher_college")}}">院</a>
  </div>
  <div class="col text-center" style="background-color:rgb(33,66,109);">
    <a href="{{ url("teacher_department")}}"style="color:white;">系</a>
  </div>
</div> --}}
<div class="container-fluid">
    <div class="row ">   
        <div class="col-sm-4" style="border-style:outset;">
            <p align="left" style="font-size:6vmin;font-weight:bold;">教授平均授課時數</p>
            <table class="table table-responsive table-striped">
                <tr class="table-primary">
                    <td>排名</td>
                    <td>學校名稱</td>
                    <td>授課時數</td>  
                </tr>
                @foreach($PROF_hour as $h)
                  @if($h->RANK <11)
                    @if ( $h->SCH_NAME == $schoolname)
                        <tr class="table-danger" style='font-weight:bold;'> 
                    @else
                        <tr>
                    @endif
                            <td>{{$h->RANK}}</td>
                            <td>{{$h->SCH_NAME}}</td>
                            <td>{{ round($h->AVG_TEACH_PROF,3)}}</td>  
                        </tr> 
                  @else
                    @if ( $h->SCH_NAME == $schoolname)
                        <tr class="table-danger" style='font-weight:bold;'> 
                            <td>{{$h->RANK}}</td>
                            <td>{{$h->SCH_NAME}}</td>
                            <td>{{ round($h->AVG_TEACH_PROF,3)}}</td>  
                        </tr> 
                    @else
                        <tr id="other1" style='display:none'> 
                            <td>{{$h->RANK}}</td>
                            <td>{{$h->SCH_NAME}}</td>
                            <td>{{ round($h->AVG_TEACH_PROF,3)}}</td>  
                        </tr> 
                    @endif
                  @endif 
                @endforeach
                <tr>
                    <td colspan='3' align='center'>
                        <input type="button" class="btn btn-secondary" value="查看更多" id="more1">
                    </td>
                </tr>
            </table>

        </div>
        <div class="col-sm-4"style="border-style:outset;">
            <p align="left" style="font-size:6vmin;font-weight:bold;">副教授平均授課時數</p>
            <table class="table table-responsive table-striped">
                <tr class="table-primary">
                    <td>排名</td>
                    <td>學校名稱</td>
                    <td>授課時數</td>  
                </tr>
                @foreach($ASCPROF_hour as $h)
                  @if($h->RANK <11)
                    @if ( $h->SCH_NAME == $schoolname)
                        <tr class="table-danger" style='font-weight:bold;'> 
                    @else
                        <tr>
                    @endif
                            <td>{{$h->RANK}}</td>
                            <td>{{$h->SCH_NAME}}</td>
                            <td>{{ round($h->AVG_TEACH_ASCPROF,3)}}</td>  
                        </tr>
                  @else
                    @if ( $h->SCH_NAME == $schoolname)
                        <tr class="table-danger" style='font-weight:bold;'> 
                            <td>{{$h->RANK}}</td>
                            <td>{{$h->SCH_NAME}}</td>
                            <td>{{ round($h->AVG_TEACH_ASCPROF,3)}}</td>
                        </tr>
                    @else
                        <tr id="other2" style='display:none'>
                            <td>{{$h->RANK}}</td>
                            <td>{{$h->SCH_NAME}}</td>
                            <td>{{ round($h->AVG_TEACH_ASCPROF,3)}}</td>
                        </tr> 
                    @endif
                  @endif  
                @endforeach
                <tr>
                    <td colspan='3' align='center'>
                        <input type="button" class="btn btn-secondary" value="查看更多" id="more2">
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-sm-4"style="border-style:outset;">
            <p align="left" style="font-size:6vmin;font-weight:bold;">助理教授平均授課時數</p>
            <table class="table table-responsive table-striped">
                <tr class="table-primary">
                    <td>排名</td>
                    <td>學校名稱</td>
                    <td>授課時數</td>  
                </tr>
                @foreach($ASTPROF_hour as $h)
                  @if($h->RANK <11)
                    @if ( $h->SCH_NAME == $schoolname)
                        <tr class="table-danger" style='font-weight:bold;'> 
                    @else
                        <tr>
                    @endif
                            <td>{{$h->RANK}}</td>
                            <td>{{$h->SCH_NAME}}</td>
                            <td>{{ round($h->AVG_TEACH_ASTPROF,3)}}</td>  
                        </tr>
                  @else
                    @if ( $h->SCH_NAME == $schoolname)
                        <tr class="table-danger" style='font-weight:bold;'> 
                            <td>{{$h->RANK}}</td>
                            <td>{{$h->SCH_NAME}}</td>
                            <td>{{ round($h->AVG_TEACH_ASTPROF,3)}}</td>
                        </tr>
                    @else
                        <tr id="other3" style='display:none'>
                            <td>{{$h->RANK}}</td>
                            <td>{{$h->SCH_NAME}}</td>
                            <td>{{ round($h->AVG_TEACH_ASTPROF,3)}}</td>
                        </tr>
                    @endif
                  @endif  
                @endforeach
                <tr>
                    <td colspan='3' align='center'>
                        <input type="button" class="btn btn-secondary" value="查看更多" id="more3">
                    </td>
                </tr>
            </table>
        </div>
        <div class="w-100"></div>
        <div class="col-sm-4"style="border-style:outset;">
            <p align="left" style="font-size:6vmin;font-weight:bold;">講師平均授課時數</p>
            <table class="table table-responsive table-striped">
                <tr class="table-primary">
                    <td>排名</td>
                    <td>學校名稱</td>
                    <td>授課時數</td>  
                </tr>
                @foreach($LT_hour as $h)
                  @if($h->RANK <11)
                    @if ( $h->SCH_NAME == $schoolname)
                        <tr class="table-danger" style='font-weight:bold;'> 
                    @else
                        <tr>
                    @endif
                            <td>{{$h->RANK}}</td>
                            <td>{{$h->SCH_NAME}}</td>
                            <td>{{ round($h->AVG_TEACH_LT,3)}}</td>  
                        </tr>
                  @else
                    @if ( $h->SCH_NAME == $schoolname)
                        <tr class="table-danger" style='font-weight:bold;'> 
                            <td>{{$h->RANK}}</td>
                            <td>{{$h->SCH_NAME}}</td>
                            <td>{{ round($h->AVG_TEACH_LT,3)}}</td>
                        </tr>
                    @else
                        <tr id="other4" style='display:none'>
                            <td>{{$h->RANK}}</td>
                            <td>{{$h->SCH_NAME}}</td>
                            <td>{{ round($h->AVG_TEACH_LT,3)}}</td>
                        </tr>
                    @endif
                  @endif
                @endforeach
                <tr>
                    <td colspan='3' align='center'>
                        <input type="button" class="btn btn-secondary" value="查看更多" id="more4">
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="col-sm-4"style="border-style:outset;">
            <p align="left" style="font-size:6vmin;font-weight:bold;">其他教師平均授課時數</p>
            <table class="table table-responsive table-striped">
                <tr class="table-primary">
                    <td>排名</td>
                    <td>學校名稱</td>
                    <td>授課時數</td>  
                </tr>
                @foreach($OT_hour as $h)
                  @if($h->RANK <11)
                    @if ( $h->SCH_NAME == $schoolname)
                        <tr class="table-danger" style='font-weight:bold;'> 
                    @else
                        <tr>
                    @endif
                            <td>{{$h->RANK}}</td>
                            <td>{{$h->SCH_NAME}}</td>
                            <td>{{ round($h->AVG_TEACH_OT,3)}}</td>  
                        </tr>
                  @else
                    @if ( $h->SCH_NAME == $schoolname)
                        <tr class="table-danger" style='font-weight:bold;'> 
                            <td>{{$h->RANK}}</td>
                            <td>{{$h->SCH_NAME}}</td>
                            <td>{{ round($h->AVG_TEACH_OT,3)}}</td>
                        </tr>
                    @else
                        <tr id="other5" style='display:none'>
                            <td>{{$h->RANK}}</td>
                            <td>{{$h->SCH_NAME}}</td>
                            <td>{{ round($h->AVG_TEACH_OT,3)}}</td>
                        </tr> 
                    @endif
                  @endif
                @endforeach
                <tr>
                    <td colspan='3' align='center'>
                        <input type="button" class="btn btn-secondary" value="查看更多" id="more5">
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</div>
<script>
    $('#more1').click(function (){
        var str = document.getElementById('more1').value;
        console.log();
        if(str == '查看更多'){
            more1.value='點此縮小';
            for(i=0;i<other1.length;i++){
              other1[i].style.display='';
            }
        }
        else{
            more1.value='查看更多';
            for(i=0;i<other1.length;i++){
              other1[i].style.display='none';
            }
        }
        
    });

    $('#more2').click(function (){
        var str = document.getElementById('more2').value;
        console.log();
        if(str == '查看更多'){
            more2.value='點此縮小';
            for(i=0;i<other2.length;i++){
              other2[i].style.display='';
            }
        }
        else{
            more2.value='查看更多';
            for(i=0;i<other2.length;i++){
              other2[i].style.display='none';
            }
        }
        
    });

    $('#more3').click(function (){
        var str = document.getElementById('more3').value;
        console.log();
        if(str == '查看更多'){
            more3.value='點此縮小';
            for(i=0;i<other3.length;i++){
              other3[i].style.display='';
            }
        }
        else{
            more3.value='查看更多';
            for(i=0;i<other3.length;i++){
              other3[i].style.display='none';
            }
        }
        
    });

    $('#more4').click(function (){
        var str = document.getElementById('more4').value;
        console.log();
        if(str == '查看更多'){
            more4.value='點此縮小';
            for(i=0;i<other4.length;i++){
              other4[i].style.display='';
            }
        }
        else{
            more4.value='查看更多';
            for(i=0;i<other4.length;i++){
              other4[i].style.display='none';
            }
        }
        
    });

    $('#more5').click(function (){
        var str = document.getElementById('more5').value;
        console.log();
        if(str == '查看更多'){
            more5.value='點此縮小';
            for(i=0;i<other5.length;i++){
              other5[i].style.display='';
            }
        }
        else{
            more5.value='查看更多';
            for(i=0;i<other5.length;i++){
              other5[i].style.display='none';
            }
        }
        
    });

</script>

@endsection

