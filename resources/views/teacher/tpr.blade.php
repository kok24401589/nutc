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
@section("title")
{{(int)$nowyear}}學年度日間部生師比排名-校
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
    <div class="col text-center" style="background-color:rgb(33,66,109);color:white;">
      校
    </div>
    <div class="col text-center" >
      <a href="tpr_college?year={{$nowyear}}">院</a>
    </div>
    <div class="col text-center" >
      <a href="tpr_department?year={{$nowyear}}">系</a>
    </div>
  </div>
  <div class="container-fluid" style="font-family:Microsoft JhengHei;">
    <div class="row" style="font-size:20px;width:100%;margin: 0 auto;">
        <div class="col-md-12" style="padding-top:20px;font-weight:bold;font-size:4vw;">
          <span >
            @foreach($StudentTeacherRatio as $STR)
              @if($STR->學校名稱 == $schoolname)
                {{$schoolname}} 名次：
                <span  style='color: red;font-weight:bold;'>{{$STR->RANK}}</span>名
                <br>
                生師比：
                <span  style='color: red;font-weight:bold;'>{{round($STR->生師比,3)}}</span>%
              @endif
            @endforeach
          
          </span>
          <br><br>
            <Select class="form-select form-select-lg mb-3" 
                    aria-label="Default select example" 
                    style="float:left;" 
                    onchange="tpr(this.value)">
                  <option value="str">依生師比</option>
                  <option value="strs" >依學生</option>
                  <option value="strt">依老師</option>      
            </Select>
          <span>排序與全臺學校比較</span>    
        </div>
    </div>
    <div style="margin: 0 auto;">
        <button type="button" 
                style="float:right" 
                class="btn btn-warning " 
                data-container="body" 
                data-toggle="pop" 
                data-placement="bottom" 
                data-content="本資料是依據大專校院校務資訊公開資料庫全臺國立技專校院生師比做排名，日間學制係指【二專(日間)、五專(含七)、學士班(日間)、碩士班(日間)、博士班】，日間學制專任教師數係指授課於日間學制【二專(日間)、五專、學士班(日間)、碩士班(日間)、博士班】">
              資料說明(？)
        </button>
        <table class="table 
                      table-borderless 
                      table-striped" 
               style="font-size:2vw;">
            <thead class="bg-success border-success">
              <tr style="color:white;">
                <th>名次</th>    
                <th>學校名稱</th>
                <th>學生/老師 (人數)</th>
                <th>生師比 (%)</th>
              </tr>
            </thead>
            <tbody id="str" style="display:">
                @foreach($StudentTeacherRatio as $STR)
                  @if($STR->學校名稱 == $schoolname)
                    <tr style='color:red;font-weight:bold;'>
                  @else
                    <tr>
                  @endif
                      <td>{{$STR->RANK}}</td>
                      <td>{{$STR->學校名稱}}</td>
                      <td>{{(int)$STR->學生}}/{{(int)$STR->教師}}</td>
                      <td>{{round($STR->生師比,3)}}</td>
                  </tr>
                @endforeach
            </tbody>
            <tbody id="strs" style="display:none">
                @foreach($StudentTeacherRatioS as $STRS)
                  @if($STRS->學校名稱 == $schoolname)
                    <tr style='color:red;font-weight:bold;'>
                  @else
                    <tr>
                  @endif
                      <td>{{$STRS->RANK}}</td>
                      <td>{{$STRS->學校名稱}}</td>
                      <td>{{(int)$STRS->學生}}/{{(int)$STRS->教師}}</td>
                      <td>{{round($STRS->生師比,3)}}</td>
                  </tr>
                @endforeach
            </tbody>
            <tbody id="strt" style="display:none">
                @foreach($StudentTeacherRatioT as $STRT)
                  @if($STRT->學校名稱 == $schoolname)
                    <tr style='color:red;font-weight:bold;'>
                  @else
                    <tr>
                  @endif
                      <td>{{$STRT->RANK}}</td>
                      <td>{{$STRT->學校名稱}}</td>
                      <td>{{(int)$STRT->學生}}/{{(int)$STRT->教師}}</td>
                      <td>{{round($STRT->生師比,3)}}</td>
                  </tr>
                @endforeach
            </tbody>
        </table>
    </div> 
  </div>
</div>
<script>
  function tpr(str) {
    if (str == "str") {
      document.getElementById("str").style.display='';
      document.getElementById("strs").style.display='none';
      document.getElementById("strt").style.display='none';
    }else if(str=="strs"){
      document.getElementById("str").style.display='none';
      document.getElementById("strs").style.display='';
      document.getElementById("strt").style.display='none';
    }else if(str=="strt"){
      document.getElementById("str").style.display='none';
      document.getElementById("strs").style.display='none';
      document.getElementById("strt").style.display='';
    }
  }
</script>
<script>
  $("[data-toggle=pop]").popover();
</script>

@endsection