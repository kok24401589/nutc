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
              <th>學年度</th>
              <th>設立別</th>
              <th>學校類別</th>
              <th>學校統計處代碼</th>
              <th>學校名稱</th>
              <th>單位代碼</th>
              <th>單位名稱</th>
              <th>專任教師數-教師總數</th>
              <th>專任教師數-教師總數男</th>
              <th>專任教師數-教師總數女</th>
              <th>專任教師數-教授男</th>
              <th>專任教師數-教授女</th>
              <th>專任教師數-副教授男</th>
              <th>專任教師數-副教授女</th>
              <th>專任教師數-助理教授男</th>
              <th>專任教師數-助理教授女</th>
              <th>專任教師數-講師男</th>
              <th>專任教師數-講師女</th>
              <th>專任教師數-其他教師男</th>
              <th>專任教師數-其他教師女</th>
              <th>專任助理教授以上總人數</th>
              <th>專任助理教授以上總人數男</th>
              <th>專任助理教授以上總人數女</th>
              <th>專任講師以上總人數</th>
              <th>專任講師以上總人數男</th>
              <th>專任講師以上總人數女</th>

           </tr>
		</thead>
		<tbody>
			@foreach($all as $list)
              <tr>
                   <td>{{$list->AD_YEAR}}</td>
                   <td>{{$list->PUB_OR_PRI}}</td>
                   <td>{{$list->SCH_CTG}}</td>
                   <td>{{$list->SCH_CODE}}</td>
                   <td>{{$list->SCH_NAME}}</td>
                   <td>{{$list->UNIT_CODE}}</td>
                   <td>{{$list->DEP_NAME}}</td>
                   <td>{{$list->TCH_SUM}}</td>
                   <td>{{$list->TCH_MALE}}</td>
                   <td>{{$list->TCH_FEMALE}}</td>
                   <td>{{$list->PFS_MALE}}</td>
                   <td>{{$list->PFS_FEMALE}}</td>
                   <td>{{$list->ASCPFS_MALE}}</td>
                   <td>{{$list->ASCPFS_FEMALE}}</td>
                   <td>{{$list->ASTPFS_MALE}}</td>
                   <td>{{$list->ASTPFS_FEMALE}}</td>
                   <td>{{$list->LT_MALE}}</td>
                   <td>{{$list->LT_FEMALE}}</td>
                   <td>{{$list->OT_TCH_MALE}}</td>
                   <td>{{$list->OT_TCH_FEMALE}}</td>
                   <td>{{$list->FT_ASTPFS_UP}}</td>
                   <td>{{$list->FT_ASTPFS_UP_MALE}}</td>
                   <td>{{$list->FT_ASTPFS_UP_FEMALE}}</td>
                   <td>{{$list->FT_LT_UP}}</td>
                   <td>{{$list->FT_LT_UP_MALE}}</td>
                   <td>{{$list->FT_LT_UP_FEMALE}}</td>

              </tr>
			@endforeach
		</tbody>
	</table>

@stop
