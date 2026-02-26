@extends("temp")
@section("title")
{{$nowyear}}學年度學生人數分析-院
@stop
@section("tigger")
@foreach($colrow as $t)
{{$t->COL_NUM}}()
@endforeach
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
    <a href="student/?year={{$nowyear}}">校</a>
  </div>
  <div class="col text-center" style="background-color:rgb(33,66,109);">
    <a href="student_college/?year={{$nowyear}}" style="color:white;">院</a>
  </div>
  <div class="col text-center">
    <a href="student_department?value=學士班(日間)&year={{$nowyear}}">系</a>
  </div>
</div>
</div>
{{-- content --}}
<div class="row" style="font-size:24px;font-family:Microsoft JhengHei;width:100%;padding:2%;margin:0px">
  <div class="col-md-12">
    <div class="row">
@foreach($colrow as $row)

<div class="col-md-4" style="padding:2px">
  <div class="panel panel-default" >
    <div 
      class="panel-heading table-danger" 
      align="center" 
      style="
        border-width:0px;
        border-style:solid;
        border-radius:10px;
        background-color:{{$row->COL_COLOR}}"
    >
      @php
        $rowid = $row->COL_NUM;
        $College= $row->College;
      @endphp


<script>
 function {{$rowid}}(){
    $.ajax({
    url: '{{url("api/stcollegeapi")}}',
    type: "POST",
    method: "POST",
    dataType: "json",
    data:{College:"{{$College}}",year:"{{$nowyear}}"}
})
.done(function( msg ) {
    

  $('#{{$rowid}}1').append('<p style="color:white;">' + msg.College[0].STU_SUM + '人</p>');
  for(i=0;i<msg.Department.length;i++){

   $('#{{$rowid}}2').append('<li>' + msg.Department[i].SYSTEM_TYPE +':'+ msg.Department[i].STU_SUM  + '</li>');
  }
  for(i=0;i<msg.Sch_sys.length;i++){

   $('#{{$rowid}}3').append('<li>' + msg.Sch_sys[i].SCH_SYS+':'+ msg.Sch_sys[i].STU_SUM  + '</li>');
  }
  for(i=0;i<msg.department.length;i++){

   $('#{{$rowid}}4').append('<tr><td>' + msg.department[i].DEP_NAME+'</td><td>'+ msg.department[i].STU_SUM  + '</td></tr>');
  }
console.log(msg)

  });
 }
</script>


      <a data-toggle="collapse" data-parent="#accordion"()
        href="#{{$rowid}}">
        <span style="font-size:4.5vh;">
          <table width="100%" style="line-height:40px">
          <tr>
            <td style="text-align:left;width:50%">
              <img src="img/{{$rowid}}.png"  style="width:10vh;margin:7px">
            </td>
            <td style="text-align:right;color:white;font-weight:bold;margin:0px 0px 0px 5px">
              {{$row->College}}
              <br>
              <span style="font-size:25px;margin-bottom:100px;">
                <div id="{{$rowid}}1">{{-- 學院總人數 --}}
                {{-- @foreach($College as $col)
                  {{$col->STU_SUM}}人
                @endforeach --}}
              </div>
              </span>
            </td>
         </tr>
         </table>
        </span>                    
      </a>
    </div>
    <div id="{{$rowid}}" class="panel-collapse collapse in">
      <div class="panel-body">
        <table  width=100% >
          <tr>
            <td align="left" style="font-size:60px;font-weight:bold;font-weight:bold;">
              部別
            </td>
                                        
          </tr>
          <tr>
            <td align="left" style="padding:10px;color:#6F7678">
              <div class="row">
                <ul id="{{$rowid}}2">
                 
                </ul>
              </div>
            </td>
          </tr>
          <tr>
            <td align="left" style="font-size:60px;font-weight:bold;font-weight:bold;">
              學制
            </td>
          </tr>
          <tr>
            <td align="left" style="padding:10px;color:#6F7678">
              <div class="row">
                <ul id="{{$rowid}}3">
                 
                </ul>
              </div>
            </td>
          </tr>
          <tr>
            <td align="left" style="font-size:60px;font-weight:bold;font-weight:bold;">
              科系<br>
            </td>
          </tr>
          <tr>
            <td align="center" style="width:70%">
              <table style="width:90%" class="table table-striped"id="{{$rowid}}4">
                
              </table>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div><br>
</div>
@endforeach
    </div>
  </div> 
</div>

@stop