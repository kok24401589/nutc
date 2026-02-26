@extends("temp")
@section("title")
{{$nowyear}}學年度休學人數分析-院
@stop
{{-- ✅ 菜單連結已由 MenuComposer 統一處理，無需在此定義 --}}

@section("link")
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/9.3.3/highcharts-more.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/9.3.3/modules/data.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/9.3.3/modules/accessibility.min.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@500&display=swap" rel="stylesheet">
@stop
@section("tigger")
@foreach($colrow as $t)
{{$t->COL_NUM}}()
@endforeach
@stop
@section("tigger2")
@foreach($colrow as $a)
{{$a->COL_NUM}}2()
@endforeach
@stop
@section("tigger3")
@foreach($colrow as $a)
{{$a->COL_NUM}}3()
@endforeach
@stop

@section("tigger4")
@foreach($colrow as $a)
{{$a->COL_NUM}}4()
@endforeach
@stop

{{-- @section("tigger5")
@foreach($colrow as $a)
{{$a->COL_NUM}}5()
@endforeach
@stop --}}

@section("tigger6")
@foreach($colrow as $a)
{{$a->COL_NUM}}6()
@endforeach
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
  <div class="col text-center">
    <a href="s_suspension?year={{$nowyear}}">校</a>
  </div>
  <div class="col text-center" style="background-color:rgb(33,66,109);">
    <a href="s_suspension_college?year={{$nowyear}}"  style="color:white;">院</a>
  </div>
  <div class="col text-center" >
    <a href="s_suspension_department?value=學士班(日間)&year={{$nowyear}}">系</a>
  </div>
</div>
</div>

<div style="text-align:center;">
 <div class="col-md-12" id="5college"  style="max-width:100%; height:400px;"></div>
</div>

 @foreach($colrow as $row)


<div class="col-md-12" style="padding:2px">
        <div class="panel panel-default" >
               <div class="panel-heading table-danger" align="center" style="border-width:0px;border-style:solid;border-radius:10px;background-color:{{$row->COL_COLOR}}">
      @php
        $rowid = $row->COL_NUM;

      @endphp
      
       <script>
        
function {{$rowid}}(){
           $.ajax({
                    url: '{{url("api/asc")}}',
                    type: "POST",
                    method: "POST",
                    dataType: "json",
                    data:{College:"{{$row->COL}}",year:"{{$nowyear}}"}
                  })
   .done(function(msg) {

  $('#{{$rowid}}1').append( Number(msg.College[0].SP_SUM)+'人' );
  $('#{{$rowid}}2').append( '('+(msg.College[0].SPpi *100).toFixed(1) + ')%');
   
var data1 = [] ,d=msg.Department;

for ( var i=0; i< d.length; i++) {
    data1.push({name:d[i].SYSTEM_TYPE+':<br><p style="font-size:10px;">('+Number(d[i].SP_SUM)+'/'+Number(d[i].STU_SUM)+")%</p>",y:d[i].SPpi*100})

} 

Highcharts.chart('{{$row->COL}}部別', {
    chart: {
        type: 'bar',
        style: {
            fontFamily: 'Microsoft JhengHei',            
        }
    },
    credits: {
      enabled: false   //刪除右下標籤
    },
    title: {
        text: '依部別',
        style: {
                    font:'20px',
                    fontWeight: 'bold',
                }  
    },
    
    xAxis: {
        type: 'category',
        labels: {
                style: {
                    fontSize:'15px',  
                }
            },
    },
    yAxis: {
        title: {
        text: '',
        
       },
        labels: {
                style: {
                    fontSize:'15px',
                    
                },
             formatter: function() {
             return this.value+"%";
                },
            },
    },
    legend: {
        enabled: false
    },
    plotOptions: {
        column:{
        colorByPoint:true,
         
        },
        series: {
            borderWidth: 0,
            dataLabels: {
                style: {
                    fontSize:'15px',   
                },
                enabled: true,
                format: '{point.y:,.1f}%',
            },colors:['red','black']
        }
    },
    tooltip: {
        headerFormat: '',
        pointFormat: '<span style="color:black">休學比例</span>: <b>{point.y:,.1f}%</b>'
    },
            series:[{
                        name: "Browsers",
                        colorByPoint: true,
                        data:data1
                    

                        }],
   
   });

   });
}
function {{$rowid}}2(){
           $.ajax({
                    url: '{{url("api/asc2")}}',
                    type: "POST",
                    method: "POST",
                    dataType: "json",
                    data:{College:"{{$row->COL}}",year:"{{$nowyear}}"}
                  })
   .done(function(msg) {
    
 var data2=[];
for ( var i1=0; i1< msg.SCH_SYS.length; i1++) {
    data2.push({name:msg.SCH_SYS[i1].SCH_SYS+":<br><p style='font-size:10px;'>("+Number(msg.SCH_SYS[i1].SP_SUM)+'/'+Number(msg.SCH_SYS[i1].STU_SUM)+")%</p>", y:msg.SCH_SYS[i1].SPpi*100})
}
// Highcharts.setOptions({colors: ['rgb(149, 206, 255)']});
Highcharts.chart('{{$row->COL}}學制', {
    chart: {
        type: 'bar',
        style: {
            fontFamily: 'Microsoft JhengHei',
            
        }
    },
    credits: {
      enabled: false   //刪除右下標籤
    },
    title: {
        text: '依學制',
        style: {
                    font:'20px',
                    fontWeight: 'bold',
                }
    },
    subtitle: {
        
    },
    xAxis: {
        type: 'category',
        labels: {
                style:{fontSize:'15px', }
            },
    },
    yAxis: {
        title: {
        text: '',
       },
         labels: {
                style: {
                    fontSize:'15px',
                    
                },
             formatter: function() {
             return this.value+"%";
                },
            },
    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            dataLabels: {
                style: {
                    fontSize:'12px', 
                     
                },
                enabled: true,
                format: '{point.y:,.1f}%'
            },
            colors: ['rgb(149, 206, 255)']
        }
    },

    tooltip: {
       
        pointFormat: '<span style="color:black">休學比例</span>: <b>{point.y:,.1f}%</b>'
    },

    series:[{
           name: "Browsers",
           colorByPoint: true,
            data:data2
        }
    ],
    });
   });
}
function {{$rowid}}3(){
           $.ajax({
                    url: '{{url("api/asc3")}}',
                    type: "POST",
                    method: "POST",
                    dataType: "json",
                    data:{College:"{{$row->COL}}",year:"{{$nowyear}}"}
                  })
   .done(function(msg) {
    
var sp=[],sp2=[],sparry=msg.sp;
for(var s=0;s<sparry.length;s++){
     sp2[s]=Number(((sparry[s].SP_SUM/sparry[s].STU_SUM)*100).toFixed(2));
    sp.push(sparry[s].DEP_SIMPLE+":<br>("+Number(sparry[s].SP_SUM)+"/"+Number(sparry[s].STU_SUM)+")%");
}

// Highcharts.setOptions({
//     // colors: ['rgb(178, 255, 164)','rgb(144, 237, 125)','rgb(252, 225, 142)','rgb(247, 163, 92)']
// });  
   
Highcharts.chart('{{$row->COL}}科系', {

    chart: {
        type: 'bar',
        style: {
            fontFamily: 'Microsoft JhengHei',
            
        }
    },
    credits: {
      enabled: false   //刪除右下標籤
    },
    title: {
        text: '依科系',
         style: {   
                    fontWeight: 'bold',
                    fontSize:'20px',
                    
                }
    },colors:['rgb(178, 255, 164)'],

    xAxis: {

        min: 0,
        categories:sp,
        labels: {
                style: {
                    fontSize:'15px',
                    
                }
            }
    },

    yAxis: {
        allowDecimals: false,
        min: 0,
        title:{
            text:'',
            
        },
        labels: {
                style: {
                    fontSize:'15px',
                    
                },
             formatter: function() {
             return this.value+"%";
                },
            }
    },legend: {
        enabled: false
    },
    
    tooltip: {
        formatter: function () {
            return '<b>休學比例' +this.y+'%</b>';
        }
    },

    plotOptions: {
        series: {
            borderWidth: 0,
                    dataLabels: {
                style: {
                    fontSize:'12px', 
                     
                },
                enabled: true,
                
                format: '{point.y:,.1f}%',
                

            }
        }
    },

    series: [{
        name: '休學人數',
        data:sp2,
        
    },  ]
}); 
   
    });
}

function {{$rowid}}4(){
           $.ajax({
                    url: '{{url("api/asc5")}}',
                    type: "POST",
                    method: "POST",
                    dataType: "json",
                    data:{College:"{{$row->COL}}",year:"{{$nowyear}}"}
                  })
   .done(function(msg) {
    var sp=[],sparry=msg.sp,sp1=[],sp2=[],sp3=[],sp4=[],sp5=[],sp6=[],sp7=[],sp8=[],sp9=[],sp10=[],sp11=[],sp12=[],sp13=[],sp14=[]
for(var s=0;s<sparry.length;s++){
 sp1[s]=Number(sparry[s].SP_ED_SICK)
 sp2[s]=Number(sparry[s].SP_ED_MONEY)
 sp3[s]=Number(sparry[s].SP_ED_SCORE)
 sp4[s]=Number(sparry[s].SP_ED_INTERESTS)
 sp5[s]=Number(sparry[s].SP_ED_WORK)
 sp6[s]=Number(sparry[s].SP_ED_PREGNANT)
 sp7[s]=Number(sparry[s].SP_ED_BABY )
 sp8[s]=Number(sparry[s].SP_ED_MILITARY)
 sp9[s]=Number(sparry[s].SP_ED_TRAVEL)
 sp10[s]=Number(sparry[s].SP_ED_PAPER)
 sp11[s]=Number(sparry[s].SP_ED_MALADAPTIVE)
 sp12[s]=Number(sparry[s].SP_ED_FAMILY)
 sp13[s]=Number(sparry[s].SP_ED_EXAM)
 sp14[s]=Number(sparry[s].SP_ED_OTHER )
 sp.push(sparry[s].DEP_SIMPLE);
 
}

    Highcharts.chart('{{$row->COL}}因傷病', {
    
    chart: {
        polar: true,
        type: 'column'
    }, credits: {
      enabled: false   //刪除右下標籤
    },

    title: {
        text: '因傷病',
        align: 'center',
        style: {   
                    fontWeight: 'bold',
                    fontSize:'20px',                   
                }
    },

   

    pane: {
        size: '85%'
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
  },colors:['#20A87F'],

    xAxis: {
        tickmarkPlacement: 'on',
         categories:sp,
         labels: {
            style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'15px',

                }
            }
    },

    yAxis: {
        min: 0,
        endOnTick: false,
        showLastLabel: true,
        title: {
            text: ''
        },
        labels: {
            formatter: function () {
                return this.value + '人';
            }
        },
        reversedStacks: false
    },

    tooltip: {
        valueSuffix: '人'
    },

    plotOptions: {
        series: {
            stacking: 'normal',
            shadow: false,
            groupPadding: 0,
            pointPlacement: 'on',
           showInLegend:false

        }
    },

    series: [{
        
        name:'因傷病',
        data:sp1,
        
    }]

});


    Highcharts.chart('{{$row->COL}}因經濟困難', {
    
    chart: {
        polar: true,
        type: 'column'
    }, credits: {
      enabled: false   //刪除右下標籤
    },

    title: {
        text: '因經濟困難',
        align: 'center',
        style: {   
                    fontWeight: 'bold',
                    fontSize:'20px',                   
                }
    },

   

    pane: {
        size: '85%'
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
  },colors:['#DF5FF5'],

    xAxis: {
        tickmarkPlacement: 'on',
         categories:sp,
         labels: {
            style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'15px'
                }
            }
    },

    yAxis: {
        min: 0,
        endOnTick: false,
        showLastLabel: true,
        title: {
            text: ''
        },
        labels: {
            formatter: function () {
                return this.value + '人';
            }
        },
        reversedStacks: false
    },

    tooltip: {
        valueSuffix: '人'
    },

    plotOptions: {
        series: {
            stacking: 'normal',
            shadow: false,
            groupPadding: 0,
            pointPlacement: 'on',
            showInLegend:false

        }
    },

    series: [
       {
       
        name:'因經濟困難',
        data:sp2,
        
    } ]

});

    Highcharts.chart('{{$row->COL}}因學業成績', {
    
    chart: {
        polar: true,
        type: 'column'
    }, credits: {
      enabled: false   //刪除右下標籤
    },

    title: {
        text: '因學業成績',
        align: 'center',
        style: {   
                    fontWeight: 'bold',
                    fontSize:'20px',                   
                }
    },

   

    pane: {
        size: '85%'
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
  },colors:['#46F5C0'],

    xAxis: {
        tickmarkPlacement: 'on',
         categories:sp,
         labels: {
            style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'15px'
                }
            }
    },

    yAxis: {
        min: 0,
        endOnTick: false,
        showLastLabel: true,
        title: {
            text: ''
        },
        labels: {
            formatter: function () {
                return this.value + '人';
            }
        },
        reversedStacks: false
    },

    tooltip: {
        valueSuffix: '人'
    },

    plotOptions: {
        series: {
            stacking: 'normal',
            shadow: false,
            groupPadding: 0,
            pointPlacement: 'on',
            showInLegend:false

        }
    },

    series: [
        {
        
        name:'因學業成績',
        data:sp3
    } ]

});

    Highcharts.chart('{{$row->COL}}因志趣不合', {
    
    chart: {
        polar: true,
        type: 'column'
    }, credits: {
      enabled: false   //刪除右下標籤
    },

    title: {
        text: '因志趣不合',
        align: 'center',
        style: {   
                    fontWeight: 'bold',
                    fontSize:'20px',                   
                }
    },

   

    pane: {
        size: '85%'
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
  },colors:['#B176DB'],

    xAxis: {
        tickmarkPlacement: 'on',
         categories:sp,
         labels: {
            style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'15px'
                }
            }
    },

    yAxis: {
        min: 0,
        endOnTick: false,
        showLastLabel: true,
        title: {
            text: ''
        },
        labels: {
            formatter: function () {
                return this.value + '人';
            }
        },
        reversedStacks: false
    },

    tooltip: {
        valueSuffix: '人'
    },

    plotOptions: {
        series: {
            stacking: 'normal',
            shadow: false,
            groupPadding: 0,
            pointPlacement: 'on',
            showInLegend:false

        }
    },

    series: [{
        
        name:'因志趣不合',
        data:sp4,
        
    }  ]

}); 
    Highcharts.chart('{{$row->COL}}因工作需求', {
    
    chart: {
        polar: true,
        type: 'column'
    }, credits: {
      enabled: false   //刪除右下標籤
    },

    title: {
        text: '因工作需求',
        align: 'center',
        style: {   
                    fontWeight: 'bold',
                    fontSize:'20px',                   
                }
    },

   

    pane: {
        size: '85%'
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
  },colors:['#08A80B'],

    xAxis: {
        tickmarkPlacement: 'on',
         categories:sp,
         labels: {
            style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'15px'
                }
            }
    },

    yAxis: {
        min: 0,
        endOnTick: false,
        showLastLabel: true,
        title: {
            text: ''
        },
        labels: {
            formatter: function () {
                return this.value + '人';
            }
        },
        reversedStacks: false
    },

    tooltip: {
        valueSuffix: '人'
    },

    plotOptions: {
        series: {
            stacking: 'normal',
            shadow: false,
            groupPadding: 0,
            pointPlacement: 'on',
            showInLegend:false

        }
    },

    series: [{
        
        name:'因工作需求',
        data:sp5,
        
    }  ]

});
    Highcharts.chart('{{$row->COL}}因懷孕', {
    
    chart: {
        polar: true,
        type: 'column'
    }, credits: {
      enabled: false   //刪除右下標籤
    },

    title: {
        text: '因懷孕',
        align: 'center',
        style: {   
                    fontWeight: 'bold',
                    fontSize:'20px',                   
                }
    },

   

    pane: {
        size: '85%'
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
  },colors:['#623DF5'],

    xAxis: {
        tickmarkPlacement: 'on',
         categories:sp,
         labels: {
            style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'15px'
                }
            }
    },

    yAxis: {
        min: 0,
        endOnTick: false,
        showLastLabel: true,
        title: {
            text: ''
        },
        labels: {
            formatter: function () {
                return this.value + '人';
            }
        },
        reversedStacks: false
    },

    tooltip: {
        valueSuffix: '人'
    },

    plotOptions: {
        series: {
            stacking: 'normal',
            shadow: false,
            groupPadding: 0,
            pointPlacement: 'on',
            showInLegend:false

        }
    },

    series: [{

        
        name:'因懷孕',
        data:sp6,
        
    }  ]

}); 
    Highcharts.chart('{{$row->COL}}因育嬰', {
    
    chart: {
        polar: true,
        type: 'column'
    }, credits: {
      enabled: false   //刪除右下標籤
    },

    title: {
        text: '因育嬰',
        align: 'center',
        style: {   
                    fontWeight: 'bold',
                    fontSize:'20px',                   
                }
    },

   

    pane: {
        size: '85%'
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
  },colors:['#25F527'],

    xAxis: {
        tickmarkPlacement: 'on',
         categories:sp,
         labels: {
            style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'15px'
                }
            }
    },

    yAxis: {
        min: 0,
        endOnTick: false,
        showLastLabel: true,
        title: {
            text: ''
        },
        labels: {
            formatter: function () {
                return this.value + '人';
            }
        },
        reversedStacks: false
    },

    tooltip: {
        valueSuffix: '人'
    },

    plotOptions: {
        series: {
            stacking: 'normal',
            shadow: false,
            groupPadding: 0,
            pointPlacement: 'on',
            showInLegend:false

        }
    },

    series: [{
        
        name:'因育嬰',
        data:sp7,
        
    }  ]

});
    Highcharts.chart('{{$row->COL}}因兵役', {
    
    chart: {
        polar: true,
        type: 'column'
    }, credits: {
      enabled: false   //刪除右下標籤
    },

    title: {
        text: '因兵役',
        align: 'center',
        style: {   
                    fontWeight: 'bold',
                    fontSize:'20px',                   
                }
    },

   

    pane: {
        size: '85%'
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
  },colors:['#F5740C'],

    xAxis: {
        tickmarkPlacement: 'on',
         categories:sp,
         labels: {
            style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'15px'
                }
            }
    },

    yAxis: {
        min: 0,
        endOnTick: false,
        showLastLabel: true,
        title: {
            text: ''
        },
        labels: {
            formatter: function () {
                return this.value + '人';
            }
        },
        reversedStacks: false
    },

    tooltip: {
        valueSuffix: '人'
    },

    plotOptions: {
        series: {
            stacking: 'normal',
            shadow: false,
            groupPadding: 0,
            pointPlacement: 'on',
            showInLegend:false

        }
    },

    series: [{
        
        name:'因兵役',
        data:sp8,
        
    }  ]

});
        Highcharts.chart('{{$row->COL}}因出國', {
    
    chart: {
        polar: true,
        type: 'column'
    }, credits: {
      enabled: false   //刪除右下標籤
    },

    title: {
        text: '因出國',
        align: 'center',
        style: {   
                    fontWeight: 'bold',
                    fontSize:'20px',                   
                }
    },

   

    pane: {
        size: '85%'
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
  },colors:['#A85411'],

    xAxis: {
        tickmarkPlacement: 'on',
         categories:sp,
         labels: {
            style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'15px'
                }
            }
    },

    yAxis: {
        min: 0,
        endOnTick: false,
        showLastLabel: true,
        title: {
            text: ''
        },
        labels: {
            formatter: function () {
                return this.value + '人';
            }
        },
        reversedStacks: false
    },

    tooltip: {
        valueSuffix: '人'
    },

    plotOptions: {
        series: {
            stacking: 'normal',
            shadow: false,
            groupPadding: 0,
            pointPlacement: 'on',
            showInLegend:false

        }
    },

    series: [{
        
        name:'因出國',
        data:sp9,
        
    }  ]

});
        Highcharts.chart('{{$row->COL}}因論文', {
    
    chart: {
        polar: true,
        type: 'column'
    }, credits: {
      enabled: false   //刪除右下標籤
    },

    title: {
        text: '因論文',
        align: 'center',
        style: {   
                    fontWeight: 'bold',
                    fontSize:'20px',                   
                }
    },

   

    pane: {
        size: '85%'
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
  },colors:['#DB3251'],

    xAxis: {
        tickmarkPlacement: 'on',
         categories:sp,
         labels: {
            style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'15px'
                }
            }
    },

    yAxis: {
        min: 0,
        endOnTick: false,
        showLastLabel: true,
        title: {
            text: ''
        },
        labels: {
            formatter: function () {
                return this.value + '人';
            }
        },
        reversedStacks: false
    },

    tooltip: {
        valueSuffix: '人'
    },

    plotOptions: {
        series: {
            stacking: 'normal',
            shadow: false,
            groupPadding: 0,
            pointPlacement: 'on',
            showInLegend:false

        }
    },

    series: [{
        
        name:'因論文',
        data:sp10,
        
    } ]

});
    Highcharts.chart('{{$row->COL}}因適應不良', {
    
    chart: {
        polar: true,
        type: 'column'
    }, credits: {
      enabled: false   //刪除右下標籤
    },

    title: {
        text: '因適應不良',
        align: 'center',
        style: {   
                    fontWeight: 'bold',
                    fontSize:'20px',                   
                }
    },

   

    pane: {
        size: '85%'
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
  },colors:['#89DAF5'],

    xAxis: {
        tickmarkPlacement: 'on',
         categories:sp,
         
         labels: {
            style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'15px'
                },
              padding: 2
            }
    },

    yAxis: {
        min: 0,
        endOnTick: false,
        showLastLabel: true,
        title: {
            text: ''
        },
        labels: {
            formatter: function () {
                return this.value + '人';
            }
        },
        reversedStacks: false
    },

    tooltip: {
        valueSuffix: '人'
    },

    plotOptions: {
        series: {
            stacking: 'normal',
            shadow: false,
            groupPadding: 0,
            pointPlacement: 'on',
            showInLegend:false

        }
    },

    series: [{
        
        name:'因適應不良',
        data:sp11,
        
    } ]

});

     Highcharts.chart('{{$row->COL}}因家人傷病', {
    
    chart: {
        polar: true,
        type: 'column'
    }, credits: {
      enabled: false   //刪除右下標籤
    },

    title: {
        text: '因家人傷病',
        align: 'center',
        style: {   
                    fontWeight: 'bold',
                    fontSize:'20px',                   
                }
    },

   

    pane: {
        size: '85%'
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
  },colors:['#F5EC70'],

    xAxis: {
        tickmarkPlacement: 'on',
         categories:sp,
         labels: {
            style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'15px'
                }
            }
    },

    yAxis: {
        min: 0,
        endOnTick: false,
        showLastLabel: true,
        title: {
            text: ''
        },
        labels: {
            formatter: function () {
                return this.value + '人';
            }
        },
        reversedStacks: false
    },

    tooltip: {
        valueSuffix: '人'
    },

    plotOptions: {
        series: {
            stacking: 'normal',
            shadow: false,
            groupPadding: 0,
            pointPlacement: 'on',
            showInLegend:false

        }
    },

    series: [{
        
        name:'因家人傷病',
        data:sp12,
        
    } ]

});
Highcharts.chart('{{$row->COL}}因考試訓練', {
    
    chart: {
        polar: true,
        type: 'column'
    }, credits: {
      enabled: false   //刪除右下標籤
    },

    title: {
        text: '因考試訓練',
        align: 'center',
        style: {   
                    fontWeight: 'bold',
                    fontSize:'20px',                   
                }
    },

   

    pane: {
        size: '85%'
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
  },colors:['#F5EC70'],

    xAxis: {
        tickmarkPlacement: 'on',
         categories:sp,
         labels: {
            style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'15px'
                }
            }
    },

    yAxis: {
        min: 0,
        endOnTick: false,
        showLastLabel: true,
        title: {
            text: ''
        },
        labels: {
            formatter: function () {
                return this.value + '人';
            }
        },
        reversedStacks: false
    },

    tooltip: {
        valueSuffix: '人'
    },

    plotOptions: {
        series: {
            stacking: 'normal',
            shadow: false,
            groupPadding: 0,
            pointPlacement: 'on',
            showInLegend:false

        }
    },

    series: [{
        
        name:'因考試訓練',
        data:sp13,
        
    } ]

});
                         Highcharts.chart('{{$row->COL}}其他', {
    
    chart: {
        polar: true,
        type: 'column'
    }, credits: {
      enabled: false   //刪除右下標籤
    },

    title: {
        text: '其他',
        align: 'center',
        style: {   
                    fontWeight: 'bold',
                    fontSize:'20px',                   
                }
    },

   

    pane: {
        size: '85%'
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
  },colors:['#A8455F'],

    xAxis: {
        tickmarkPlacement: 'on',
         categories:sp,
         labels: {
            style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'15px'
                }
            }
    },

    yAxis: {
        min: 0,
        endOnTick: false,
        showLastLabel: true,
        title: {
            text: ''
        },
        labels: {
            formatter: function () {
                return this.value + '人';
            }
        },
        reversedStacks: false
    },

    tooltip: {
        valueSuffix: '人'
    },

    plotOptions: {
        series: {
            stacking: 'normal',
            shadow: false,
            groupPadding: 0,
            pointPlacement: 'on',
            showInLegend:false

        }
    },

    series: [{
        
        name:'其他',
        data:sp14,
        
    },  ]

});
              });

  }
  function {{$rowid}}6(){
           $.ajax({
                    url: '{{url("api/asc6")}}',
                    type: "POST",
                    method: "POST",
                    dataType: "json",
                    data:{College:"{{$row->COL}}",year:"{{$nowyear}}"}
                  })
   .done(function(msg) {
     var sp=[],sparry=msg.sp,spname=[]
// for(var s=0;s<sparry.length;s++){
//  sp.push(sparry[s].COL);
// }

var array13=[Number(((sparry[0].SP_ED_SICK/sparry[0].SP_SUM)*100).toFixed(2)),
             Number(((sparry[0].SP_ED_MONEY/sparry[0].SP_SUM)*100).toFixed(2)),
             Number(((sparry[0].SP_ED_SCORE/sparry[0].SP_SUM)*100).toFixed(2)),
             Number(((sparry[0].SP_ED_INTERESTS/sparry[0].SP_SUM)*100).toFixed(2)),
             Number(((sparry[0].SP_ED_WORK/sparry[0].SP_SUM)*100).toFixed(2)),
             Number(((sparry[0].SP_ED_PREGNANT/sparry[0].SP_SUM)*100).toFixed(2)),
             Number(((sparry[0].SP_ED_BABY/sparry[0].SP_SUM)*100).toFixed(2) ),
             Number(((sparry[0].SP_ED_MILITARY/sparry[0].SP_SUM)*100).toFixed(2)),
             Number(((sparry[0].SP_ED_TRAVEL/sparry[0].SP_SUM)*100).toFixed(2)),
             Number(((sparry[0].SP_ED_PAPER/sparry[0].SP_SUM)*100).toFixed(2)),
             Number(((sparry[0].SP_ED_MALADAPTIVE/sparry[0].SP_SUM)*100).toFixed(2)),
             Number(((sparry[0].SP_ED_FAMILY/sparry[0].SP_SUM)*100).toFixed(2)),
             Number(((sparry[0].SP_ED_EXAM/sparry[0].SP_SUM)*100).toFixed(2)),
             Number(((sparry[0].SP_ED_OTHER/sparry[0].SP_SUM)*100).toFixed(2))]
            
            spname.push("因傷病:<br><p style='font-size:10px;'>("+Number(sparry[0].SP_ED_SICK)+"/"+Number(sparry[0].STU_SUM)+")%</p>");
            spname.push("因經濟困難:<br><p style='font-size:10px;'>("+Number(sparry[0].SP_ED_MONEY)+"/"+Number(sparry[0].STU_SUM)+")%</p>");
            spname.push("因學業成績:<br><p style='font-size:10px;'>("+Number(sparry[0].SP_ED_SCORE)+"/"+Number(sparry[0].STU_SUM)+")%</p>");
            spname.push("因志趣不合:<br><p style='font-size:10px;'>("+Number(sparry[0].SP_ED_INTERESTS)+"/"+Number(sparry[0].STU_SUM)+")%</p>");
            spname.push("因工作需求:<br><p style='font-size:10px;'>("+Number(sparry[0].SP_ED_WORK)+"/"+Number(sparry[0].STU_SUM)+")%</p>");
            spname.push("因懷孕:<br><p style='font-size:10px;'>("+Number(sparry[0].SP_ED_PREGNANT)+"/"+Number(sparry[0].STU_SUM)+")%</p>");
            spname.push("因育嬰:<br><p style='font-size:10px;'>("+Number(sparry[0].SP_ED_BABY)+"/"+Number(sparry[0].STU_SUM)+")%</p>");
            spname.push("因兵役:<br><p style='font-size:10px;'>("+Number(sparry[0].SP_ED_MILITARY)+"/"+Number(sparry[0].STU_SUM)+")%</p>");
            spname.push("因出國:<br><p style='font-size:10px;'>("+Number(sparry[0].SP_ED_TRAVEL)+"/"+Number(sparry[0].STU_SUM)+")%</p>");
            spname.push("因論文:<br><p style='font-size:10px;'>("+Number(sparry[0].SP_ED_PAPER)+"/"+Number(sparry[0].STU_SUM)+")%</p>");
            spname.push("因適應不良:<br><p style='font-size:10px;'>("+Number(sparry[0].SP_ED_MALADAPTIVE)+"/"+Number(sparry[0].STU_SUM)+")%</p>");
            spname.push("因家人傷病:<br><p style='font-size:10px;'>("+Number(sparry[0].SP_ED_FAMILY)+"/"+Number(sparry[0].STU_SUM)+")%</p>");
            spname.push("因考試訓練:<br><p style='font-size:10px;'>("+Number(sparry[0].SP_ED_EXAM)+"/"+Number(sparry[0].STU_SUM)+")%</p>");
            spname.push("其他:<br><p style='font-size:10px;'>("+Number(sparry[0].SP_ED_OTHER)+"/"+Number(sparry[0].STU_SUM)+")%</p>");
Highcharts.chart('{{$row->COL}}test', {

    chart: {
        type: 'bar',
        style: {
            fontFamily: 'Microsoft JhengHei',
            
        }
    },
    credits: {
      enabled: false   //刪除右下標籤
    },
    title: {
        text: '依休學原因',
         style: {   
                    fontWeight: 'bold',
                    fontSize:'20px',
                    
                }
    },colors:['#F5B25F'],

    xAxis: {

        min: 0,
        categories:spname,
        labels: {
                style: {
                    fontSize:'15px',
                    
                }
            }
    },

    yAxis: {
        allowDecimals: false,
        min: 0,
        title:{
            text:'',
            
        },
        labels: {
                style: {
                    fontSize:'15px',
                    
                },
             formatter: function() {
             return this.value+"%";
                },
            }
    },legend: {
        enabled: false
    },
    
    tooltip: {
        formatter: function () {
            return '<b>休學比例' +this.y+'%</b>';
        }
    },

    plotOptions: {
        series: {
            borderWidth: 0,
                    dataLabels: {
                style: {
                    fontSize:'12px', 
                     
                },
                enabled: true,
                
                format: '{point.y:,.1f}%',
                

            }
        },column : { 
         
//         groupPadding : 0.5 ,
　　　　　pointWidth: 20
    } 
    },

    series: [{
        name: '休學人數',
        data:array13,
        
    },  ]
}); 



                  });

  }
</script>

                    <a data-toggle="collapse" data-parent="#accordion" 
                        href="#{{$rowid}}">
                        <span style="font-size:4.5vh;">
                        <table width="100%" style="line-height:40px">
                            <tr>
                                <td style="text-align:left;width:50%"><img src="img/{{$rowid}}.png"  style="width:10vh;margin:7px">
                                </td>
                                <td style="text-align:right;color:#666666;margin:0px 0px 0px 5px">
                                    {{$row->COL}}
                                    <br>
                                    <span style="font-size:24px;margin-right:-10px;margin-bottom:100px;"id="{{$rowid}}1">
                                        </span>
                                     <span style='font-size:15px'id="{{$rowid}}2"></span>
                                </td>
                                                
                            </tr>
                        </table>
                        </span>
                                    
                     </a>
            </div>
                <div id="{{$rowid}}" class="panel-collapse collapse in">
                                <div class="panel-body" style="text-align:center;">
                                <div id="{{$row->COL}}部別"  style="max-width:100%; height:400px;"></div>
                                <div id="{{$row->COL}}學制"  style="max-width:100%; height:500px;"></div>
                                <div id="{{$row->COL}}科系"  style="max-width:100%; height:500px;"></div>
                                {{-- <div id="{{$row->COL}}測試"  style="max-width:100%; height:500px;"></div> --}}
                                <div id="{{$row->COL}}test"  style="max-width:100%; height:500px;"></div>
                                  <div class="container-fluid">
                                    <div class="row">
                                    <div class="col-12" style="font-family:'Noto Sans TC', sans-serif;font-size: 30px;padding-right: 15px;background-color:{{$row->COL_COLOR}}">
                                        依科系休學原因比例
                                    </div>
                                    
                                  </div>
                                  <div class="row">
                                    <div class="col-12 col-md-6" id="{{$row->COL}}因傷病">
                                    </div>
                                    <div class="col-12 col-md-6" id="{{$row->COL}}因經濟困難">
                                    </div>
                                  </div>
                                  
                                  <div class="row">
                                    <div class="col-12 col-md-6" id="{{$row->COL}}因學業成績">
                                    </div>
                                    <div class="col-12 col-md-6" id="{{$row->COL}}因志趣不合">
                                    </div>
                                  </div>
                                <div class="row">
                                    <div class="col-12 col-md-6" id="{{$row->COL}}因工作需求">
                                    </div>
                                    <div class="col-12 col-md-6" id="{{$row->COL}}因懷孕">
                                    </div>
                                  </div>
                                   <div class="row">
                                    <div class="col-12 col-md-6" id="{{$row->COL}}因育嬰">
                                    </div>
                                    <div class="col-12 col-md-6" id="{{$row->COL}}因兵役">
                                    </div>
                                  </div>
                                   <div class="row">
                                    <div class="col-12 col-md-6" id="{{$row->COL}}因出國">
                                    </div>
                                    <div class="col-12 col-md-6" id="{{$row->COL}}因論文">
                                    </div>
                                  </div>
                                   <div class="row">
                                    <div class="col-12 col-md-6" id="{{$row->COL}}因適應不良">
                                    </div>
                                    <div class="col-12 col-md-6" id="{{$row->COL}}因家人傷病">
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12 col-md-6" id="{{$row->COL}}因考試訓練">
                                    </div>
                                    <div class="col-12 col-md-6" id="{{$row->COL}}其他">
                                    </div>
                                  </div>
                              </div>
                        </div>
                        </div>
                    </div><br>
    </div>@endforeach
@stop

@push('scripts')
<script>

Highcharts.setOptions({
    colors: ['rgb(253, 98, 94)', 'rgb(190, 145, 212)', 'rgb(25, 181, 255)', 'rgb(246, 171, 56)', 'rgb(29, 188, 96)']
});
    
 Highcharts.chart('5college', {
    chart: {
        type: 'bar',
        style: {
            fontFamily: 'Microsoft JhengHei',
            
        }
    },
    credits: {
      enabled: false   //刪除右下標籤
    },
    title: {
        text: '依學院',
        style: {
                    font:'20px',
                    fontWeight: 'bold',
                }
        
    },
    subtitle: {
        
    },
    xAxis: {
        type: 'category',
        labels: {
                style: {
                    fontSize:'15px',
                    
                },
                
            },

    },
    yAxis: {
        title: {
        text: '',    
        
       },
         labels: {
               
                style: {
                    fontSize:'15px',
                    
                },
             formatter: function() {
             return this.value+"%";
                },
            }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                style: {
                    fontSize:'12px', 
                     
                },
                enabled: true,
                format: '{point.y:,.1f}%',
            },
            
            align:'left',
             
        }
    },

    tooltip: {
        headerFormat: '',
        pointFormat: '<span style="color:black">休學比例</span>: <b>{point.y:,.1f}%</b>'
    },

    series: [
        {
            name: "Browsers",
            colorByPoint: true,
            data: [
           
             @foreach($College as $college)
                    
                    {
                "name":"{{ $college->COL }}<br><p style='font-size:10px;'>({{ (int)$college->SP_SUM }}人/{{(int)$college->STU_SUM}}人)</p>",
                   "y":{{ $college->SPpi*100 }},
                    },
                @endforeach
            ]
        }
    ],
   
});
 </script>
@endpush
