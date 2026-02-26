@extends("temp")
@section("title")
{{$nowyear}}學年度學生生源分析-系(詳細資料)
@stop

{{-- ✅ 菜單連結已由 MenuComposer 統一處理，無需在此定義 --}}

@section("link")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/9.3.3/modules/data.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/9.3.3/modules/heatmap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/9.3.3/modules/treemap.min.js"></script>
    <script src="https://code.highcharts.com/9.3.3/modules/breadcrumbs.js"></script>    <style>
        .progwidth {
            max-width: 550px;
        }
        .treemapwidth{
            max-width: 600px;
        }     
        @media screen and (max-width: 766px) {
            .progwidth {
                max-width: 85%;
            }
            .treemapwidth {
                max-width: 100%;    
            }
        }
    </style>
@stop
@section("content")

<table width=100% border="1">
    <tr align="center" style="font-size:36px;font-family:Microsoft JhengHei;">
        <td><a href="treemap">校</a></td>
        <td style="background-color:rgb(33,66,109);border:1px solid rgb(33,66,109);">
            <a style="color:white;">系</a>
        </td>
    </tr>
</table>
<div id="container" style="min-width: 200px;max-width: 600px;margin: 0 auto;"></div>
<div class='row'>
    <div class='col-md-3'>
        <div style='padding:5px;'><span style='font-size:40px'>北部：{{$North->count()}}間</span><br></div>
        <table class='table table-striped'>
            @foreach($North as $N)
                <tr>
                    <td><span style='font-size:16px;color:#999999'>{{$loop->index+1}}</span></td>
                    <td>{{$N->入學前學校}}</td>
                    <td style='font-size:20px;white-space:nowrap;'>{{$N->人數}}名</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class='col-md-3'>
        <div style='padding:5px;'><span style='font-size:40px'>中部：{{$Central->count()}}間</span><br></div>
        <table class='table table-striped'>
            @foreach($Central as $C)
                <tr>
                    <td><span style='font-size:16px;color:#999999'>{{$loop->index+1}}</span></td>
                    <td>{{$C->入學前學校}}</td>
                    <td style='font-size:20px;white-space:nowrap;'>{{$C->人數}}名</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class='col-md-3'>
        <div style='padding:5px;'><span style='font-size:40px'>南部：{{$South->count()}}間</span><br></div>
        <table class='table table-striped'>
            @foreach($South as $S)
                <tr>
                    <td><span style='font-size:16px;color:#999999'>{{$loop->index+1}}</span></td>
                    <td>{{$S->入學前學校}}</td>
                    <td style='font-size:20px;white-space:nowrap;'>{{$S->人數}}名</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class='col-md-3'>
        <div style='padding:5px;'><span style='font-size:40px'>東部：{{$East->count()}}間</span><br></div>
        <table class='table table-striped'>
            @foreach($East as $E)
                <tr>
                    <td><span style='font-size:16px;color:#999999'>{{$loop->index+1}}</span></td>
                    <td>{{$E->入學前學校}}</td>
                    <td style='font-size:20px;white-space:nowrap;'>{{$E->人數}}名</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class='col-md-3'>
        <div style='padding:5px;'><span style='font-size:40px'>其他：{{$Other->count()}}間</span><br></div>
        <table class='table table-striped'>
            @foreach($Other as $O)
                <tr>
                    <td><span style='font-size:16px;color:#999999'>{{$loop->index+1}}</span></td>
                    <td>{{$O->入學前學校}}</td>
                    <td style='font-size:20px;white-space:nowrap;'>{{$O->人數}}名</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@stop