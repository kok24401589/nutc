@extends("temp")
@section("link")
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    @stop
{{-- ✅ 菜單連結已由 MenuComposer 統一處理，無需在此定義 --}}
@section("title")
 
{{(int)$nowyear}}學年度教師人數分析-院
@stop
@section("tigger")

sendData('{{($nowyear)}}')

@stop
@section("content")
<style type="text/css">
    .col{
        border:1px solid rgb(33,66,109);
    }

</style>
{{-- 校院系 --}}
<div class="container-fluid">
  <div class="row" style="font-size:36px;font-family:Microsoft JhengHei;">
   <div class="col text-center" >
    <a href="teacher?year={{"$nowyear"}}" >校</a>
   </div>
   <div class="col text-center" style="background-color:rgb(33,66,109);">
    <a href="teacher_college?year={{"$nowyear"}}"style="color:white;">院</a>
   </div>
   <div class="col text-center" >
    <a href="teacher_department?year={{"$nowyear"}}">系</a>
   </div>
  </div>
</div>

<div style="text-align:center;">
 <div id="container2" style="max-width:90vw; height: 500px;margin:0 auto; "></div>
 <div id="container" style="max-width:90vw; height: 500px;margin:0 auto; "></div>
</div>

    <script>

    function sendData(ady){
        

postData("{{ url("api/atc") }}", {ab: ady})
 

  .then(function(data){

    var datalong = data.dataPT.length;
        var PT_college = []; 
        var PT_PFS = [];
        var PT_ASCPFS = [];
        var PT_ASTPFS = [];
        var PT_LT = [];
        var PT_OT_TCH = [];
        var PT_PFS = [];
        
      for (var i = 0; i < datalong ; i++) {
        PT_college[i] = data.dataPT[i].college;
        PT_PFS[i] = Number(data.dataPT[i].PFS);
            PT_ASCPFS[i] =  Number(data.dataPT[i].ASCPFS);  
            PT_ASTPFS[i] = Number(data.dataPT[i].ASTPFS);
            PT_LT[i] = Number(data.dataPT[i].LT);
            PT_OT_TCH[i] = Number(data.dataPT[i].OT_TCH);
            PT_PFS[i] = Number(data.dataPT[i].PFS);
      }
    var datalong = data.dataFT.length;
    var FT_college = []; 
    var FT_PFS = [];
    var FT_ASCPFS = [];
    var FT_ASTPFS = [];
    var FT_LT = [];
    var FT_OT_TCH = [];
    var FT_PFS = [];
  for (var a = 0; a < datalong ; a++) {
                FT_college[a] = data.dataFT[a].college;
                FT_PFS[a] = Number(data.dataFT[a].PFS);
                    FT_ASCPFS[a] =  Number(data.dataFT[a].ASCPFS);  
                    FT_ASTPFS[a] = Number(data.dataFT[a].ASTPFS);
                    FT_LT[a] = Number(data.dataFT[a].LT);
                    FT_OT_TCH[a] = Number(data.dataFT[a].OT_TCH);
                    FT_PFS[a] = Number(data.dataFT[a].PFS);
   }
   
console.log(PT_ASTPFS)
 Highcharts.chart('container', {
  chart: {
    type: 'column'
  }, credits: {
      enabled: false   //刪除右下標籤
    },
    shadow:{color:"false"},
  title: {
    text: '各院兼任教師人數',
    style: {
               fontFamily:'Microsoft JhengHei',
                fontSize:'20px'
           }
  },
  xAxis: {
    categories: PT_college,
        labels: {
                  style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'20px'
                      }
               }
  },
  yAxis: {
    min: 0,
    title: {
      text: '總人數'
    },
    labels: {
                style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'20px'
                }
            },
    stackLabels: {
      enabled: true,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
      }
    }
  },
  legend: {
    align: 'center',
    x: 0,
    verticalAlign: 'bottom',
    y:0 ,
    // floating: true,
    backgroundColor:
      Highcharts.defaultOptions.legend.backgroundColor || 'white',
    borderColor: '#CCC',
    borderWidth: 1,
    shadow: true
  },
  tooltip: {
    headerFormat: '<b>{point.x}</b><br/>',
    pointFormat: '{series.name}: {point.y}<br/>總和: {point.stackTotal}'
  },
  plotOptions: {
    column: {
      stacking: 'normal',
      dataLabels: {
        enabled: true,

        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
        style:{
                    textOutline:false
                }
      }
    }
  },
  series: [
              {
                name: '教授',
                data: PT_PFS
              }, 
              {
                name: '副教授',
                data: PT_ASCPFS
              }, 
              {
                name: '助理教授',
                data: PT_ASTPFS
                
              }, 
              {
                name: '講師',
                data: PT_LT
              }, 
              {
                name: '其他教師',
                data: PT_OT_TCH
              }
           ]
  });
 console.log(PT_OT_TCH)
 // -------------------------------------------------------------------------------------
  Highcharts.chart('container2', {
  chart: {
    type: 'column'
  }, credits: {
      enabled: false   //刪除右下標籤
    },
    shadow:{color:"false"},
  title: {
    text: '各院專任教師人數',
    style: {
               fontFamily:'Microsoft JhengHei',
                fontSize:'20px'
           }
  },
  xAxis: {
    categories: FT_college,
        labels: {
                  style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'20px'
                      }
               }
  },
  yAxis: {
    min: 0,
    title: {
      text: '總人數'
    },
    labels: {
                style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'20px'
                }
            },
    stackLabels: {
      enabled: true,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
      }
    }
  },
  legend: {
    align: 'center',
    x: 0,
    verticalAlign: 'bottom',
    y:0 ,
    // floating: true,
    backgroundColor:
      Highcharts.defaultOptions.legend.backgroundColor || 'white',
    borderColor: '#CCC',
    borderWidth: 1,
    shadow: true
  },
  tooltip: {
    headerFormat: '<b>{point.x}</b><br/>',
    pointFormat: '{series.name}: {point.y}<br/>總和: {point.stackTotal}'
  },
  plotOptions: {
    column: {
      stacking: 'normal',
      dataLabels: {
        enabled: true,

        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
        style:{
                    textOutline:false
                }
      }
    }
  },
  series: [
              {
                name: '教授',
                data: FT_PFS
              }, 
              {
                name: '副教授',
                data: FT_ASCPFS
              }, 
              {
                name: '助理教授',
                data: FT_ASTPFS 
              }, 
              {
                name: '講師',
                data: FT_LT
              }, 
              {
                name: '其他教師',
                data: FT_OT_TCH
              }
           ]
  });      

   
    })
    .catch(function(err){
        console.log(err);
    });

function postData(url, data) {
  // Default options are marked with *
  return fetch(url, {
    body: JSON.stringify(data), // must match 'Content-Type' header
    cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
    credentials: 'same-origin', // include, same-origin, *omit
    headers: {
      'user-agent': 'Mozilla/4.0 MDN Example',
      'content-type': 'application/json'
    },
    method: 'POST', // *GET, POST, PUT, DELETE, etc.
    mode: 'cors', // no-cors, cors, *same-origin
    redirect: 'follow', // manual, *follow, error
    referrer: 'no-referrer', // *client, no-referrer
  })
  .then(response => response.json()) // parses response to JSON
  }
}
</script>

@endsection