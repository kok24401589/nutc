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
               <th>year</th>
               <th>group_id</th>
               <th>group_name</th>
               <th>predicted_count</th>
               <th>model_version</th>
             

           </tr>
		</thead>
		<tbody>
			@foreach($all as $list)
              <tr>
                    <td>{{$list->year}}</td>
                    <td>{{$list->group_id}}</td>
                    <td>{{$list->group_name}}</td>
                    <td>{{$list->predicted_count}}</td>
                    <td>{{$list->model_version}}</td>
                 


              </tr>
			@endforeach
		</tbody>
	</table>
	
@stop