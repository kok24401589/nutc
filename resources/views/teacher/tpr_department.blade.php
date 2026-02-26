@extends("temp")
@section("link")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" 
            integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" 
            integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" 
            crossorigin="anonymous">
    </script>
@stop

{{-- ✅ 菜單連結已由 MenuComposer 統一處理，無需在此定義 --}}

@section("tigger")
@foreach($dp_sname as $a)
{{$a->DEP_SIMPLE}}()
@endforeach
@stop
@section("title")
{{$nowyear}}學年度生師比排名-系
@stop

@section("content")
<style type="text/css">
    .col{
        border:1px solid rgb(33,66,109);
    }
</style>
   <script>

        @foreach($dp_sname as $dp_api)
function {{$dp_api->DEP_SIMPLE}}(){
           $.ajax({
                    url: '{{url("api/tpr")}}',
                    type: "POST",
                    method: "POST",
                    dataType: "json",
                    data:{dp:"{{$dp_api->DEP_LIKE}}",year:"{{$dp_api->AD_YEAR}}"}
                  })
   .done(function(msg) {
        $.each(msg.tpr, function(index, tpr) {
             if(tpr.SCH_NAME == '{{$schoolname}}'){
              $('.{{$dp_api->DEP_SIMPLE}}2').append(
              '<tr style="color:red;font-weight:bold;"><td>'+tpr.tprRanK+'</td>'+'<td>'+tpr.SCH_NAME+'</td>'+'<td>'+tpr.student+'/'+Number(tpr.teacher)+'</td>'+'<td>'+Number(tpr.tpr).toFixed(2)+'</td></tr>'
              );
          $('.{{$dp_api->DEP_SIMPLE}}3').append(
            "<p style='font-size:3vw;'>{{$schoolname}}名次:<span style='color: red;font-weight:bold;'>"+tpr.tprRanK+"</span><br>生師比:<span style='color: red;font-weight:bold;'>"+Number(tpr.tpr).toFixed(2)+"</span></p>"
            );
             }else{
              $('.{{$dp_api->DEP_SIMPLE}}2').append(
              '<tr><td>'+tpr.tprRanK+'</td>'+'<td>'+tpr.SCH_NAME+'</td>'+'<td>'+tpr.student+'/'+Number(tpr.teacher)+'</td>'+'<td>'+Number(tpr.tpr).toFixed(2)+'</td></tr>'
              );
             }

        });

   });
}
@endforeach
</script>


{{-- 校院系 --}}
<div class="container-fluid">
  <div class="row" style="font-size:36px;font-family:Microsoft JhengHei;">
    <div class="col text-center">
      <a href="tpr?year={{$nowyear}}" >校</a>
    </div>
    <div class="col text-center" >
      <a href="tpr_college?year={{$nowyear}}">院</a>
    </div>
    <div class="col text-center" style="background-color:rgb(33,66,109);color:white;">
      系
    </div>
  </div>
</div>
<div class="container-fluid">

  <div style="font-size:3vw;padding-top:20px;padding-bottom:80px;"  >
            <nav id="navbar-example2" >
                <span style="font-size:5vw;font-weight:bold;">請選擇科系:</span>
                <ul class="nav justify-content-center">
                  @foreach($dp_sname as $dp_name)
                  <li class="nav-item">
                    <a class="nav-link" href="#{{$dp_name->DEP_SIMPLE}}"><img src="img/{{$dp_name->DEP_SIMPLE}}.png" width="60vw"></a>
                  </li>  
                  @endforeach 
                </ul>    
            </nav>   
            </div>

  <span style="font-size:5vw;font-weight:bold;">與全臺科系比較</span>
    <div>           
    <button type="button"
            style="float:right"
                    style="float:right"
                    class="btn btn-warning"
                    data-container="body"
                    data-toggle="pop"
                    data-placement="bottom"
            data-content="本資料是依據大專校院校務資訊公開資料庫本校各學院生師比做排名,學生及老師學制包括【學士班(日間)、碩士班(日間)、博士班、五專、二專(日間)、學士班(進修)、碩士在職專班、二專(進修)】">資料說明(?)
    </button>
</div>
@foreach($dp_sname as $dp)
  <div class="table-responsive-md">
    <table style="font-size:2vw;"class="table table-borderless table-striped"id="{{$dp->DEP_SIMPLE}}">
      <thead   style="color:white;background-color:{{$dp->DEP_COLOR}}">
        <tr>
          <th colspan="4">
            <span style="font-size:4vw;font-weight:bold;">{{$dp->DEP_SIMPLE}}</span>
          </th>
          
        </tr>
    <tr>
      <th scope="col">名次</th>
      <th scope="col">學校名稱</th>
      <th scope="col">學生/老師(人數)</th>
      <th scope="col">生師比(%)</th>
    </tr>
  </thead>
  <tbody class='{{$dp->DEP_SIMPLE}}2'>
    
  </tbody>
    </table>
  </div>
  <hr>
  <div class='{{$dp->DEP_SIMPLE}}3'>
  </div>
<hr>
   @endforeach

</div>
<script>
 $("[data-toggle=pop]").popover();
  </script>
@endsection