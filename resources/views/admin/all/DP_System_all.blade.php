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
			   <th>學年度</th>
               <th>系所代碼</th>
               <th>系所名稱</th>
               <th>學制班別</th>
           </tr>
		</thead>
		<tbody>
			@foreach($all as $list)
              <tr>
                   <td>{{$list->AD_YEAR}}</td>
                   <td>{{$list->DEP_CODE}}</td>
                   <td>{{$list->DEP_NAME}}</td>
                   <td>{{$list->SCH_SYS}}</td>
              </tr>
			@endforeach
		</tbody>
	</table>
	
@stop