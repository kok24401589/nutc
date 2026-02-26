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
@section("tigger")
@foreach($College as $a)
{{$a->COL_NUM}}()
@endforeach
@stop
@section("title")
{{(int)$nowyear}}學年度生師比排名-院
@stop

{{-- ✅ 菜單連結已由 MenuComposer 統一處理，無需在此定義 --}}
@section("content")
<style type="text/css">
    .col{
        border:1px solid rgb(33,66,109);
    }
</style>
 <script>

        @foreach($College as $api)
function {{$api->COL_NUM}}(){
           $.ajax({
                    url: '{{url("api/tprcollege")}}',
                    type: "POST",
                    method: "POST",
                    dataType: "json",
                    data:{college:"{{$api->College}}",year:"{{$api->AD_YEAR}}",schoolname:"國立臺中科技大學"}
                  })
   .done(function(msg) {
       function Student(arr){
return arr.map(el=>Number(el.Student)).reduce((a,b)=>a+b);
}
       function Teacher(arr){
return arr.map(el=>Number(el.Teacher)).reduce((a,b)=>a+b);
}

 $('#{{$api->COL_NUM}}t').append(
   '<td  colspan="2" style="text-align:center;">總計</td><td>'+Student(msg.CollegeTPR)+'/'+Teacher(msg.CollegeTPR)+'</td><td>'+[Number(Student(msg.CollegeTPR)/Teacher(msg.CollegeTPR)).toFixed(2)]+'</td>'
 );  
    $.each(msg.CollegeTPR, function(index, tpr) {
        
      $('#{{$api->COL_NUM}}tr').append(
              '<tr><td>'+[index+1]+'</td><td>'+tpr.DEP_SIMPLE+'</td><td>'+tpr.Student+'/'+Number(tpr.Teacher)+'</td><td>'+Number(tpr.TPR).toFixed(2)+'</td></tr>'
              );   
    });      
    $.each(msg.CollegeS, function(index, tpr) {
      $('#{{$api->COL_NUM}}trs').append(
              '<tr><td>'+[index+1]+'</td><td>'+tpr.DEP_SIMPLE+'</td><td>'+tpr.Student+'/'+Number(tpr.Teacher)+'</td><td>'+Number(tpr.TPR).toFixed(2)+'</td></tr>'
              );   
    });
    $.each(msg.CollegeT, function(index, tpr) {
      $('#{{$api->COL_NUM}}trt').append(
              '<tr><td>'+[index+1]+'</td><td>'+tpr.DEP_SIMPLE+'</td><td>'+tpr.Student+'/'+Number(tpr.Teacher)+'</td><td>'+Number(tpr.TPR).toFixed(2)+'</td></tr>'
              );   
    });
   });
   var dataobj=[
    {
        name:'Yowko',
        salary:10000,
        age:30
    },{
        name:'Test',
        salary:20000,
        age:20
    },{
        name:'MVC',
        salary:15000,
        age:25
    }];


}
@endforeach
</script>
{{-- 校院系 --}}
<div class="container-fluid">
    <div class="row" style="font-size:36px;font-family:Microsoft JhengHei;">
      <div class="col text-center">
        <a href="tpr?year={{$nowyear}}">校</a>
      </div>
      <div class="col text-center" style="background-color:rgb(33,66,109);color:white;">
        院
      </div>
      <div class="col text-center" >
        <a href="tpr_department?year={{$nowyear}}">系</a>
      </div>
    </div>
    <div  style="padding-top:20px;padding-bottom:20px;"> 
        <nav id="navbar-example2">
            <span style="font-size:5vw;font-weight:bold;">請選擇學院:</span>
            <ul class="nav justify-content-center"  >
              @foreach($College as $img)
                <li class="nav-item" >
                    <a class="nav-link" href="#{{$img->COL_NUM}}"><img src="img/{{$img->COL_NUM}}.png" style="width:9.5vw;" ></a>
                </li>
                @endforeach    
            </ul>    
        </nav>   
    </div>
    <div class="row" data-spy="scroll" data-target="#navbar-example2" data-offset="0" >
        <div class="col-md-12" style="font-size:2.5vw;">
            <button type="button"
                    style="float:right"
                    class="btn btn-warning"
                    data-container="body"
                    data-toggle="pop"
                    data-placement="bottom"
                    data-content="本資料是依據大專校院校務資訊公開資料庫本校{{$schoolname}}各學院生師比做排名,學生及老師學制包括【學士班(日間)、碩士班(日間)、博士班、五專、二專(日間)、學士班(進修)、碩士在職專班、二專(進修)】">資料說明(?)
            </button>   
            <table class="table table-borderless  table-striped">  
               <thead class="bg-info" style="color:white;">
                   <tr>
                      <th colspan="5">
                          <span style="font-size:4vw;font-weight:bold;">學院生師比排名</span>
                      </th>
                   </tr>  
                   <tr>     
                      <th width="8%">名次</th>
                      <th width="45%">學院</th>
                      <th width="30%">學生/老師(人數)</th>    
                      <th width="20%">生師比(%)</th>   
                   </tr>
               </thead>  
               <tbody>
                  @foreach($college as $col)
                    <tr>
                      <td>{{$loop->index+1}}</td>
                      <td>{{$col->College}}</td>
                      <td>{{$col->Student}}/{{(int)$col->Teacher}}</td>
                      <td>{{round($col->TPR,2)}}%</td>
                    </tr>
                  @endforeach
               </tbody>
            </table>
            @foreach($College as $item)
            <table class="table table-borderless table-striped" id="{{$item ->COL_NUM}}">  
                  <thead style="background-color:{{$item ->COL_COLOR}};color:white;" >
                      <tr>
                        <th colspan="5">
                          <span style="font-size:4vw;font-weight:bold;">
                            {{$item ->College}}生師比 
                          </span>
                          <Select class="form-select form-select-lg mb-3" 
                                  aria-label="Default select example" 
                                  style="float:right;font-size:3vw;" 
                                  onchange="{{$item ->COL_NUM}}tpr(this.value)">
                              <option value="{{$item ->COL_NUM}}tr">依生師比</option>
                              <option value="{{$item ->COL_NUM}}trs" >依學生</option>
                              <option value="{{$item ->COL_NUM}}trt">依老師</option>      
                          </Select>
                          </th>
                      </tr>
                      <tr>   
                          <th width="8%">名次</th>
                          <th width="45%">學院</th>
                          <th width="30%">學生/老師(人數)</th>    
                          <th width="20%">生師比(%)</th>    
                      </tr>
                  </thead>
{{--                    @php
                     $StudentAll = 0;
                     $TeacherAll = 0;
                   @endphp --}}
                  <tbody id="{{$item ->COL_NUM}}tr" style="display:">
                   
{{--                       @foreach($ComCollegeTPR as $col)
                        @php
                          $StudentAll+=(int)$col->Student;
                          $TeacherAll+=(int)$col->Teacher;
                        @endphp
                        <tr>
                          <td>{{$loop->index+1}}</td>
                          <td>{{$col->DEP_SIMPLE}}</td>
                          <td>{{$col->Student}}/{{(int)$col->Teacher}}</td>
                          <td>{{round($col->TPR,2)}}</td>
                        </tr>
                      @endforeach --}}
                  </tbody>
                  <tbody id="{{$item ->COL_NUM}}trs" style="display:none">
{{--                       @foreach($ComCollegeS as $col)
                        <tr>
                          <td>{{$loop->index+1}}</td>
                          <td>{{$col->DEP_SIMPLE}}</td>
                          <td>{{$col->Student}}/{{(int)$col->Teacher}}</td>
                          <td>{{round($col->TPR,2)}}</td>
                        </tr>
                      @endforeach --}}
                  </tbody>
                  <tbody id="{{$item ->COL_NUM}}trt" style="display:none">
{{--                       @foreach($ComCollegeT as $col)
                        <tr>
                          <td>{{$loop->index+1}}</td>
                          <td>{{$col->DEP_SIMPLE}}</td>
                          <td>{{$col->Student}}/{{(int)$col->Teacher}}</td>
                          <td>{{round($col->TPR,2)}}</td>
                        </tr>
                      @endforeach --}}
                  </tbody>
                  <tr class="table-warning"id="{{$item ->COL_NUM}}t">
                    

                  </tr>
            </table>
 @endforeach
{{--             <table class="table table-borderless table-striped" id="cod">  
                  <thead style="background-color:rgb(190, 145, 212);color:white;" >
                      <tr>
                        <th colspan="5">
                          <span style="font-size:4vw;font-weight:bold;">
                            設計學院生師比 
                          </span>
                          <Select class="form-select form-select-lg mb-3" 
                                  aria-label="Default select example" 
                                  style="float:right;font-size:3vw;" 
                                  onchange="codtpr(this.value)">
                              <option value="codstr">依生師比</option>
                              <option value="codstrs" >依學生</option>
                              <option value="codstrt">依老師</option>      
                          </Select>
                          </th>
                      </tr>
                      <tr>   
                          <th width="8%">名次</th>
                          <th width="45%">學院</th>
                          <th width="30%">學生/老師(人數)</th>    
                          <th width="20%">生師比(%)</th>    
                      </tr>
                  </thead>
                   @php
                     $StudentAll = 0;
                     $TeacherAll = 0;
                   @endphp
                  <tbody id="codstr" style="display:">
                      @foreach($CodCollegeTPR as $col)
                        @php
                          $StudentAll+=(int)$col->Student;
                          $TeacherAll+=(int)$col->Teacher;
                        @endphp
                        <tr>
                          <td>{{$loop->index+1}}</td>
                          <td>{{$col->DEP_SIMPLE}}</td>
                          <td>{{$col->Student}}/{{(int)$col->Teacher}}</td>
                          <td>{{round($col->TPR,2)}}</td>
                        </tr>
                      @endforeach
                  </tbody>
                  <tbody id="codstrs" style="display:none">
                      @foreach($CodCollegeS as $col)
                        <tr>
                          <td>{{$loop->index+1}}</td>
                          <td>{{$col->DEP_SIMPLE}}</td>
                          <td>{{$col->Student}}/{{(int)$col->Teacher}}</td>
                          <td>{{round($col->TPR,2)}}</td>
                        </tr>
                      @endforeach
                  </tbody>
                  <tbody id="codstrt" style="display:none">
                      @foreach($CodCollegeT as $col)
                        <tr>
                          <td>{{$loop->index+1}}</td>
                          <td>{{$col->DEP_SIMPLE}}</td>
                          <td>{{$col->Student}}/{{(int)$col->Teacher}}</td>
                          <td>{{round($col->TPR,2)}}</td>
                        </tr>
                      @endforeach
                  </tbody>
                  <tr class="table-warning">
                    <td colspan="2" style="text-align:center;">總計</td>
                    <td>{{$StudentAll}}/{{$TeacherAll}}</td>
                    <td>{{round($StudentAll/$TeacherAll,2)}}</td>
                  </tr>
            </table>
            <table class="table table-borderless table-striped" id="cids">  
                  <thead style="background-color:rgb(25, 181, 255);color:white;" >
                      <tr>
                        <th colspan="5">
                          <span style="font-size:4vw;font-weight:bold;">
                            資訊流通學院 
                          </span>
                          <Select class="form-select form-select-lg mb-3" 
                                  aria-label="Default select example" 
                                  style="float:right;font-size:3vw;" 
                                  onchange="cidstpr(this.value)">
                              <option value="cidsstr">依生師比</option>
                              <option value="cidsstrs" >依學生</option>
                              <option value="cidsstrt">依老師</option>      
                          </Select>
                          </th>
                      </tr>
                      <tr>   
                          <th width="8%">名次</th>
                          <th width="45%">學院</th>
                          <th width="30%">學生/老師(人數)</th>    
                          <th width="20%">生師比(%)</th>    
                      </tr>
                  </thead>
                   @php
                     $StudentAll = 0;
                     $TeacherAll = 0;
                   @endphp
                  <tbody id="cidsstr" style="display:">
                      @foreach($CidsCollegeTPR as $col)
                        @php
                          $StudentAll+=(int)$col->Student;
                          $TeacherAll+=(int)$col->Teacher;
                        @endphp
                        <tr>
                          <td>{{$loop->index+1}}</td>
                          <td>{{$col->DEP_SIMPLE}}</td>
                          <td>{{$col->Student}}/{{(int)$col->Teacher}}</td>
                          <td>{{round($col->TPR,2)}}</td>
                        </tr>
                      @endforeach
                  </tbody>
                  <tbody id="cidsstrs" style="display:none">
                      @foreach($CidsCollegeS as $col)
                        <tr>
                          <td>{{$loop->index+1}}</td>
                          <td>{{$col->DEP_SIMPLE}}</td>
                          <td>{{$col->Student}}/{{(int)$col->Teacher}}</td>
                          <td>{{round($col->TPR,2)}}</td>
                        </tr>
                      @endforeach
                  </tbody>
                  <tbody id="cidsstrt" style="display:none">
                      @foreach($CidsCollegeT as $col)
                        <tr>
                          <td>{{$loop->index+1}}</td>
                          <td>{{$col->DEP_SIMPLE}}</td>
                          <td>{{$col->Student}}/{{(int)$col->Teacher}}</td>
                          <td>{{round($col->TPR,2)}}</td>
                        </tr>
                      @endforeach
                  </tbody>
                  <tr class="table-warning">
                    <td colspan="2" style="text-align:center;">總計</td>
                    <td>{{$StudentAll}}/{{$TeacherAll}}</td>
                    <td>{{round($StudentAll/$TeacherAll,2)}}</td>
                  </tr>
            </table>
            <table class="table table-borderless table-striped" id="col">  
                  <thead style="background-color:rgb(246, 171, 56);color:white;" >
                      <tr>
                        <th colspan="5">
                          <span style="font-size:4vw;font-weight:bold;">
                            語文學院生師比 
                          </span>
                          <Select class="form-select form-select-lg mb-3" 
                                  aria-label="Default select example" 
                                  style="float:right;font-size:3vw;" 
                                  onchange="coltpr(this.value)">
                              <option value="colstr">依生師比</option>
                              <option value="colstrs" >依學生</option>
                              <option value="colstrt">依老師</option>      
                          </Select>
                          </th>
                      </tr>
                      <tr>   
                          <th width="8%">名次</th>
                          <th width="45%">學院</th>
                          <th width="30%">學生/老師(人數)</th>    
                          <th width="20%">生師比(%)</th>    
                      </tr>
                  </thead>
                   @php
                     $StudentAll = 0;
                     $TeacherAll = 0;
                   @endphp
                  <tbody id="colstr" style="display:">
                      @foreach($ColCollegeTPR as $col)
                        @php
                          $StudentAll+=(int)$col->Student;
                          $TeacherAll+=(int)$col->Teacher;
                        @endphp
                        <tr>
                          <td>{{$loop->index+1}}</td>
                          <td>{{$col->DEP_SIMPLE}}</td>
                          <td>{{$col->Student}}/{{(int)$col->Teacher}}</td>
                          <td>{{round($col->TPR,2)}}</td>
                        </tr>
                      @endforeach
                  </tbody>
                  <tbody id="colstrs" style="display:none">
                      @foreach($ColCollegeS as $col)
                        <tr>
                          <td>{{$loop->index+1}}</td>
                          <td>{{$col->DEP_SIMPLE}}</td>
                          <td>{{$col->Student}}/{{(int)$col->Teacher}}</td>
                          <td>{{round($col->TPR,2)}}</td>
                        </tr>
                      @endforeach
                  </tbody>
                  <tbody id="colstrt" style="display:none">
                      @foreach($ColCollegeT as $col)
                        <tr>
                          <td>{{$loop->index+1}}</td>
                          <td>{{$col->DEP_SIMPLE}}</td>
                          <td>{{$col->Student}}/{{(int)$col->Teacher}}</td>
                          <td>{{round($col->TPR,2)}}</td>
                        </tr>
                      @endforeach
                  </tbody>
                  <tr class="table-warning">
                    <td colspan="2" style="text-align:center;">總計</td>
                    <td>{{$StudentAll}}/{{$TeacherAll}}</td>
                    <td>{{round($StudentAll/$TeacherAll,2)}}</td>
                  </tr>
            </table>
            <table class="table table-borderless table-striped" id="ntcnc">  
                  <thead style="background-color:rgb(29, 188, 96);color:white;" >
                      <tr>
                        <th colspan="5">
                          <span style="font-size:4vw;font-weight:bold;">
                            中護健康學院生師比 
                          </span>
                          <Select class="form-select form-select-lg mb-3" 
                                  aria-label="Default select example" 
                                  style="float:right;font-size:3vw;" 
                                  onchange="ntcnctpr(this.value)">
                              <option value="ntcncstr">依生師比</option>
                              <option value="ntcncstrs" >依學生</option>
                              <option value="ntcncstrt">依老師</option>      
                          </Select>
                          </th>
                      </tr>
                      <tr>   
                          <th width="8%">名次</th>
                          <th width="45%">學院</th>
                          <th width="30%">學生/老師(人數)</th>    
                          <th width="20%">生師比(%)</th>    
                      </tr>
                  </thead>
                   @php
                     $StudentAll = 0;
                     $TeacherAll = 0;
                   @endphp
                  <tbody id="ntcncstr" style="display:">
                      @foreach($NtcncCollegeTPR as $col)
                        @php
                          $StudentAll+=(int)$col->Student;
                          $TeacherAll+=(int)$col->Teacher;
                        @endphp
                        <tr>
                          <td>{{$loop->index+1}}</td>
                          <td>{{$col->DEP_SIMPLE}}</td>
                          <td>{{$col->Student}}/{{(int)$col->Teacher}}</td>
                          <td>{{round($col->TPR,2)}}</td>
                        </tr>
                      @endforeach
                  </tbody>
                  <tbody id="ntcncstrs" style="display:none">
                      @foreach($NtcncCollegeS as $col)
                        <tr>
                          <td>{{$loop->index+1}}</td>
                          <td>{{$col->DEP_SIMPLE}}</td>
                          <td>{{$col->Student}}/{{(int)$col->Teacher}}</td>
                          <td>{{round($col->TPR,2)}}</td>
                        </tr>
                      @endforeach
                  </tbody>
                  <tbody id="ntcncstrt" style="display:none">
                      @foreach($NtcncCollegeT as $col)
                        <tr>
                          <td>{{$loop->index+1}}</td>
                          <td>{{$col->DEP_SIMPLE}}</td>
                          <td>{{$col->Student}}/{{(int)$col->Teacher}}</td>
                          <td>{{round($col->TPR,2)}}</td>
                        </tr>
                      @endforeach
                  </tbody>
                  <tr class="table-warning">
                    <td colspan="2" style="text-align:center;">總計</td>
                    <td>{{$StudentAll}}/{{$TeacherAll}}</td>
                    <td>{{round($StudentAll/$TeacherAll,2)}}</td>
                  </tr>
            </table> --}}

          </div>
    </div>
</div>
<script>
  @foreach($College as $js)
  function {{$js->COL_NUM}}tpr(str) {
    if (str == "{{$js->COL_NUM}}tr") {
      document.getElementById("{{$js->COL_NUM}}tr").style.display='';
      document.getElementById("{{$js->COL_NUM}}trs").style.display='none';
      document.getElementById("{{$js->COL_NUM}}trt").style.display='none';
    }else if(str=="{{$js->COL_NUM}}trs"){
      document.getElementById("{{$js->COL_NUM}}tr").style.display='none';
      document.getElementById("{{$js->COL_NUM}}trs").style.display='';
      document.getElementById("{{$js->COL_NUM}}trt").style.display='none';
    }else if(str=="{{$js->COL_NUM}}trt"){
      document.getElementById("{{$js->COL_NUM}}tr").style.display='none';
      document.getElementById("{{$js->COL_NUM}}trs").style.display='none';
      document.getElementById("{{$js->COL_NUM}}trt").style.display='';
    }
  }
  @endforeach
</script>
<script>
  $("[data-toggle=pop]").popover();
</script>
@endsection