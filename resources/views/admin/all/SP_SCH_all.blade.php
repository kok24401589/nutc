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
               <th>PUB_OR_PRI</th>
               <th>SCH_CTG</th>
               <th>SCH_CODE</th>
               <th>SCH_NAME</th>
               <th>SCH_SYS</th>
               <th>GENDER</th>
               <th>STU_SUM</th>
               <th>SP_ED_SUM</th>
               <th>SP_ED_SICK</th>
               <th>SP_ED_MONEY</th>
               <th>SP_ED_SCORE</th>
               <th>SP_ED_INTERESTS</th>
               <th>SP_ED_WORK</th>
               <th>SP_ED_PREGNANT</th>
               <th>SP_ED_BABY</th>
               <th>SP_ED_MILITARY</th>
               <th>SP_ED_TRAVEL</th>
               <th>SP_ED_PAPER</th>
               <th>SP_ED_MALADAPTIVE</th>
               <th>SP_ED_FAMILY</th>
               <th>SP_ED_EXAM</th>
               <th>SP_ED_REGISTERED</th>
               <th>SP_ED_OTHER</th>
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
                           <td>{{$list->SCH_SYS}}</td>
                           <td>{{$list->GENDER}}</td>
                           <td>{{$list->STU_SUM}}</td>
                           <td>{{$list->SP_ED_SUM}}</td>
                           <td>{{$list->SP_ED_SICK}}</td>
                           <td>{{$list->SP_ED_MONEY}}</td>
                           <td>{{$list->SP_ED_SCORE}}</td>
                           <td>{{$list->SP_ED_INTERESTS}}</td>
                           <td>{{$list->SP_ED_WORK}}</td>
                           <td>{{$list->SP_ED_PREGNANT}}</td>
                           <td>{{$list->SP_ED_BABY}}</td>
                           <td>{{$list->SP_ED_MILITARY}}</td>
                           <td>{{$list->SP_ED_TRAVEL}}</td>
                           <td>{{$list->SP_ED_PAPER}}</td>
                           <td>{{$list->SP_ED_MALADAPTIVE}}</td>
                           <td>{{$list->SP_ED_FAMILY}}</td>
                           <td>{{$list->SP_ED_EXAM}}</td>
                           <td>{{$list->SP_ED_REGISTERED}}</td>
                           <td>{{$list->SP_ED_OTHER}}</td>
              </tr>
			@endforeach
		</tbody>
	</table>

@stop
