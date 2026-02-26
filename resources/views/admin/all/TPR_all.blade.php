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
               <th>設立別</th>
               <th>學校類別</th>
               <th>學校統計處代碼</th>
               <th>學校名稱</th>
               <th>日間學制學生數</th>
               <th>日間專任教師(含助教)</th>
               <th>日間生師比(%)</th>

           </tr>
		</thead>
		<tbody>
			@foreach($all as $list)
              <tr>
                   <td>{{$list->學年度}}</td>
                   <td>{{$list->設立別}}</td>
                   <td>{{$list->學校類別}}</td>
                   <td>{{$list->學校統計處代碼}}</td>
                   <td>{{$list->學校名稱}}</td>
                   <td>{{(int)$list->日間學制學生數}}</td>
                   <td>{{(int)$list->日間專任教師}}</td>
                   <td>{{round($list->日間生師比,3)}}</td>

              </tr>
			@endforeach
		</tbody>
	</table>
	
@stop