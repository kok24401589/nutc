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
               <th>學制班別</th>
               <th>在學學生數小計</th>
               <th>在學學生男</th>
               <th>在學學生女</th>
           </tr>
		</thead>
		<tbody>
			@foreach($all as $list)
              <tr>
                  <td>{{ $list->AD_YEAR }}</td>
                  <td>{{ $list->PUB_OR_PRI }}</td>
                  <td>{{ $list->SCH_CTG }}</td>
                  <td>{{ $list->SCH_CODE }}</td>
                  <td>{{ $list->SCH_NAME }}</td>
                  <td>{{ $list->SCH_SYS }}</td>
                  <td>{{ $list->STU_SUM }}</td>
                  <td>{{ $list->STU_MALE }}</td>
                  <td>{{ $list->STU_FEMALE }}</td>
              </tr>
			@endforeach
		</tbody>
	</table>
	
@stop