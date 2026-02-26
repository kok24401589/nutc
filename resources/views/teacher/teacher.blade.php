@extends("temp")
@section("title")
{{$nowyear}}學年度教師人數分析-校
@stop
{{-- ✅ 菜單連結已由 MenuComposer 統一處理，無需在此定義 --}}


@section("content")
<style type="text/css">
    .col{
        border:1px solid rgb(33,66,109);
    }

</style>
{{-- 校院系 --}}
<div class="container-fluid">
<div class="row" style="font-size:36px;font-family:Microsoft JhengHei;">
  <div class="col text-center" style="background-color:rgb(33,66,109);">
    <a href="teacher?year={{$nowyear}}" style="color:white;" >校</a>
  </div>
  <div class="col text-center" >
    <a href="teacher_college?year={{$nowyear}}">院</a>
  </div>
  <div class="col text-center" >
    <a href="teacher_department?year={{$nowyear}}">系</a>
  </div>
</div>
</div>
 
 <div class="row shadow" style="font-family:Microsoft JhengHei;width:100%;padding-bottom:40px;padding-top:20px;text-align:center;margin-left:2px">
                    
                            <div  class="col-md-6">
                                <img src="img/teacher.png"  style="width:60vmin;">
                            </div>
                            <div  class="col-md-6">
                                <br>
                                 <span class="tlfontvmin" style="font-weight:bold;">
                               專任教師人數:{{ (int)$FT_TCH_SCH->TCH_SUM }}</span>
                                 <br><span class="tlfontvmin" style="font-weight:bold;">
                                兼任教師人數:{{ (int)$PT_TCH_SCH->TCH_SUM }}
                            </span>
                            </div>
  
            </div>

            <div class="row" style="font-family:Microsoft JhengHei;width:100%;margin: 0 auto;">
                    <table  width=100% class="col-md-6">
                        <tr>
                            <td  class="tlfontvmin" style="font-weight:bold;">專任教師人數<br></td>
                        </tr>
                        <tr>
                            
                            <td align="center"  class="fontvmin">
                                <ul style="text-align:left;color:#6F7678;">
                                    <li>
                                    
                                     專任教授:
                                     {{($FT_TCH_SCH->PFS_MALE)+($FT_TCH_SCH->PFS_FEMALE)}}
										                                    </li>
                                    <li>
                                    	專任副教授:
                                    {{($FT_TCH_SCH->ASCPFS_MALE)+($FT_TCH_SCH->ASCPFS_FEMALE)}}
                                    </li>

                                    <li>
                                    
                                        專任助理教授:
                                    {{($FT_TCH_SCH->ASTPFS_MALE)+($FT_TCH_SCH->ASTPFS_FEMALE)}}
                                       
                                    </li>
                                    <li>
                                    	
                                        專任講師:
                                    {{($FT_TCH_SCH->LT_MALE)+($FT_TCH_SCH->LT_FEMALE)}}
                                    </li>
                                    <li>
                                        專任其他教師:
                                    {{($FT_TCH_SCH->OT_TCH_MALE)+($FT_TCH_SCH->OT_TCH_FEMALE)}}
                                        
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        </table>
                    <table  width=100% class="col-md-6">
                        <tr>
                            <td   class="tlfontvmin" style="font-weight:bold;">兼任教師人數<br></td>
                        </tr>
                        <tr>
                            
                            
                            <td align="center"  class="fontvmin">
                                <ul style="text-align:left;color:#6F7678;">
                                    <li>
                                        兼任教授:
                                     {{((int)$PT_TCH_SCH->PFS_MALE)+((int)$PT_TCH_SCH->PFS_FEMALE)}}
                                    </li>
                                    <li>
                                        兼任副教授:
                                     {{($PT_TCH_SCH->ASCPFS_MALE)+($PT_TCH_SCH->ASCPFS_FEMALE)}}
                                    </li>
                                    <li>
                                    
                                        兼任助理教授:
                                    {{($PT_TCH_SCH->ASTPFS_MALE)+($PT_TCH_SCH->ASTPFS_FEMALE)}}
                                    </li>
                                    <li>
                                    	
                                        兼任講師:
                                    {{($PT_TCH_SCH->LT_MALE)+($PT_TCH_SCH->LT_FEMALE)}}
                                    </li>
                                    <li>
                                    	
                                        兼任其他教
                                     {{($PT_TCH_SCH->OT_TCH_MALE)+($PT_TCH_SCH->OT_TCH_FEMALE)}}
                                    
                                </ul>
                            </td>
                        </tr>
                    </table>
                    <br>
                    
                    <br>
            </div>
        </td>
    </tr>
  
</table>

@endsection