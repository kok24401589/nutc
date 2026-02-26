@extends("temp_back")
@section("link")
	<style>
		#tb{
			border-collapse: collapse;
			width: 100%;
		}
		#tb td,#tb th{
			border:1px solid #ddd;
			padding:8px;
		}
		#tb tr:nth-child(even){
			background-color: #0bfdfd;
		}
		#tb th{
			padding-top: 12px;
			padding-bottom: 12px;
			text-align: left;
			background-color: #4CAF50;
			color:#fff;
		}
	</style>
@stop
@section("class")
style="margin-top:50px;"
@stop
@section("content")
	<table id="tb">
		<thead>
		  <tr>
               <th>學制</th>
               <th>科系</th>
               <th>入學前學校所在城市</th>
               <th>入學前學歷</th>
               <th>入學前學校</th>
               <th>入學前學校科組</th>
               <th>入學方式</th>
               <th>入學學年期</th>



           </tr>
		</thead>
		<tbody>
			@foreach($all as $list)
              <tr>
                    <td>{{$list->學制}}</td>
                    <td>{{$list->科系}}</td>
                    <td>{{$list->入學前學校所在城市}}</td>
                    <td>{{$list->入學前學歷}}</td>
                    <td>{{$list->入學前學校}}</td>
                    <td>{{$list->入學前學校科組}}</td>
                    <td>{{$list->入學方式}}</td>
                    <td>{{$list->入學學年期}}</td>
              </tr>
			@endforeach
		</tbody>
	</table>
	
@stop