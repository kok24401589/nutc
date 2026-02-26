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
                <th>學期</th>
                <th>設立別</th>
                <th>學校類別</th>
                <th>學校統計處代碼</th>
                <th>學校名稱</th>
                <th>學制班別</th>
                <th>性別</th>
                <th>在學學生數</th>
                <th>學期內退學人數小計</th>
                <th>因學業成績學期內退學人數</th>
                <th>因操行成績學期內退學人數</th>
                <th>因志趣不合學期內退學人數</th>
                <th>因逾期未註冊學期內退學人數</th>
                <th>因休學逾期未復學學期內退學人數</th>
                <th>因懷孕學期內退學人數</th>
                <th>因育嬰學期內退學人數</th>
                <th>因傷病學期內退學人數</th>
                <th>因工作需求學期內退學人數</th>
                <th>因經濟困難學期內退學人數</th>
                <th>因生涯規劃學期內退學人數</th>
                <th>其他(不含死亡)學期內退學人數</th>
           </tr>
		</thead>
		<tbody>
			@foreach($all as $list)
              <tr>
                   <td>{{$list->AD_YEAR}}</td>
                   <td>{{$list->SMST}}</td>
                   <td>{{$list->PUB_OR_PRI}}</td>
                   <td>{{$list->SCH_CTG}}</td>
                   <td>{{$list->SCH_CODE}}</td>
                   <td>{{$list->SCH_NAME}}</td>
                   <td>{{$list->SCH_SYS}}</td>
                   <td>{{$list->GENDER}}</td>
                   <td>{{$list->STU_SUM}}</td>
                   <td>{{$list->DP_SUM}}</td>
                   <td>{{$list->DP_SCORE}}</td>
                   <td>{{$list->DP_CONDUCT}}</td>
                   <td>{{$list->DP_INTERESTS}}</td>
                   <td>{{$list->DP_OVEFDUE}}</td>
                   <td>{{$list->DP_NORETURN}}</td>
                   <td>{{$list->DP_PREGNANT}}</td>
                   <td>{{$list->DP_BABY}}</td>
                   <td>{{$list->DP_SICK}}</td>
                   <td>{{$list->DP_WORK}}</td>
                   <td>{{$list->DP_MONEY}}</td>
                   <td>{{$list->DP_PLAN}}</td>
                   <td>{{$list->DP_OTHER}}</td>


              </tr>
			@endforeach
		</tbody>
	</table>
	
@stop