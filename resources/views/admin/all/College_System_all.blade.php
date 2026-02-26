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
<div>
	<table id="tb">
		<thead>
		  <tr>
			<th>AD_YEAR</th>
			<th>SYSTEM_TYPE</th>
			<th>College</th>
			<th>DEP_CODE</th>
			<th>DEP_NAME</th>
			<th>DEP_SIMPLE</th>
			<th>SCH_SYS</th>
			<th>DEP_COLOR</th>
			<th>COL_COLOR</th>
			<th>COL_ICON</th>
			<th>DEP_ICON</th>
			<th>ST_NUM</th>
			<th>SS_NUM</th>
            <th>COL_NUM</th>
           </tr>
		</thead>
		<tbody>
			@foreach($all as $list)
              <tr>
              	<td>{{ $list->AD_YEAR }}</td>
              	<td>{{ $list->SYSTEM_TYPE }}</td>
              	<td>{{ $list->College }}</td>
              	<td>{{ $list->DEP_CODE }}</td>
              	<td>{{ $list->DEP_NAME }}</td>
              	<td>{{ $list->DEP_SIMPLE }}</td>
              	<td>{{ $list->SCH_SYS }}</td>
              	<td>{{ $list->DEP_COLOR }}</td>
              	<td>{{ $list->COL_COLOR }}</td>
              	<td>{{ $list->COL_ICON }}</td>
              	<td>{{ $list->DEP_ICON }}</td>
              	<td>{{ $list->ST_NUM }}</td>
              	<td>{{ $list->SS_NUM }}</td>
              	<td>{{ $list->COL_NUM }}</td>
              </tr>
			@endforeach
		</tbody>
	</table>

@stop
