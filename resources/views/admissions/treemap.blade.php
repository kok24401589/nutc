@extends("temp")
@section("title")
{{$nowyear}}學年度學生生源分析-校
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
                    <td style="background-color:rgb(33,66,109);border:1px solid rgb(33,66,109);"><a href="./student.php" style="color:white;" >校</a></td>

                    <td><a href="treemap_department?value=資訊工程系&year={{$nowyear}}">系</a></td>
                </tr>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div id="container"  class="col-md-6 treemapwidth" style="margin: 0 auto;"></div>
                <div class='progress progwidth  border border-5' style='margin:0px auto; font-size: 14px;'>
                    
                @foreach($area as $ar)
                <div class='progress-bar text-dark' 
                     role='progressbar'
                     style='width:{{($ar->人數/$all[0]->人數)*(100)}}%;
                     background-color:{{$ar->顏色}};'
                     aria-valuemin='0'
                     aria-valuemax='100'>
                {{$ar->地區}}
                </div>
                @endforeach
        </div><br><br><br>
            </div>    
            <br>
            <div class="col-md-6">
                <div id="container2" class="col-md-6 treemapwidth" style="margin: 0 auto;"></div>   
                {{-- <?php search2("where 學制 ='五專'");?> --}}
                <div class='progress progwidth  border border-5' style='margin:0px auto; font-size: 14px;'>
                    
                @foreach($area_five as $ar)
                <div class='progress-bar text-dark' 
                     role='progressbar'
                     style='width:{{($ar->人數/$all_five[0]->人數)*(100)}}%;
                     background-color:{{$ar->顏色}};'
                     aria-valuenow='15'
                     aria-valuemin='0'
                     aria-valuemax='100'>
                {{$ar->地區}}
                </div>
                @endforeach
        </div><br><br><br>
            </div>    
            <br>
            <div class="col-md-6">    
                <div id="container3" class="col-md-6 treemapwidth" style="margin: 0 auto;"></div>
                {{-- <?php search2("where 學制 ='四技'");?> --}}
                <div class='progress progwidth  border border-5' style='margin:0px auto; font-size: 14px;'>
                    
                @foreach($area_fs as $ar)
                <div class='progress-bar text-dark' 
                     role='progressbar'
                     style='width:{{($ar->人數/$all_fs[0]->人數)*(100)}}%;
                     background-color:{{$ar->顏色}};'
                     aria-valuenow='15'
                     aria-valuemin='0'
                     aria-valuemax='100'>
                {{$ar->地區}}
                </div>
                @endforeach
        </div><br><br><br>
            </div>    
            <br>
            <div class="col-md-6">    
                <div id="container4" class="col-md-6 treemapwidth" style="margin: 0 auto;"></div>
                {{-- <?php search2("where 學制 ='二技'");?> --}}
                <div class='progress progwidth  border border-5' style='margin:0px auto; font-size: 14px;'>
                    
                @foreach($area_second as $ar)
                <div class='progress-bar text-dark' 
                     role='progressbar'
                     style='width:{{($ar->人數/$all_second[0]->人數)*(100)}}%;
                     background-color:{{$ar->顏色}};'
                     aria-valuenow='15'
                     aria-valuemin='0'
                     aria-valuemax='100'>
                {{$ar->地區}}
                </div>
                @endforeach
        </div><br><br><br>
            </div>    
            <br>
            <div class="col-md-6">    
                <div id="container5" class="col-md-6 treemapwidth" style="margin: 0 auto;"></div>
                {{-- <?php search2("where 學制 ='碩士班'");?> --}}
                <div class='progress progwidth  border border-5' style='margin:0px auto; font-size: 14px;'>
                    
                @foreach($area_master as $ar)
                <div class='progress-bar text-dark' 
                     role='progressbar'
                     style='width:{{($ar->人數/$all_master[0]->人數)*(100)}}%;
                     background-color:{{$ar->顏色}};'
                     aria-valuenow='15'
                     aria-valuemin='0'
                     aria-valuemax='100'>
                {{$ar->地區}}
                </div>
                @endforeach
        </div><br><br><br>
            </div>    
            <br>
        </div>

                    

    @push('scripts')
    <script>

        Highcharts.chart('container', {
            plotOptions: {
                column: {
                    stacking: 'normal',},
                series: {
                    turboThreshold: 2000000 ,// 或者更多，必須大於陣列長度（1440）
                    dataLabels:{textOutline:"0px"}
                }
            },
            credits: {
                enabled: false   //刪除右下標籤
            },           

            series: [{
                type: 'treemap',
                name: '不分校',
                layoutAlgorithm: 'squarified',
                allowDrillToNode: true,
                animationLimit: 1000,
                dataLabels: {
                    enabled: false,
                    color:"#444444",
                    style:{textOutline:"#DDDDDD",fontFamily:'Microsoft JhengHei',}, //字形 外框顏色

                },
                levelIsConstant: false,
                levels: [{
                    level: 1,
                    dataLabels: {
                        enabled: true
                    },
                    borderWidth: 3
                }],
                data:[
                    @php
                      $temp = "";
                      $team = 0;
                    @endphp
                    
                    @foreach($StudentSourceNumber as $ssn)

                        @if($ssn->入學前學校 != $temp)
                          @php
                          $temp = $ssn->入學前學校;
                          $team+=1;
                          @endphp
                          
                           {name:'{{$temp}}<br/>({{$ssn->學校人數}})',
                           id:'id-{{ $team }}',
                           color:'{{$ssn->顏色}}'
                           },
                          {name: '{{$ssn->科系}}<br/>({{$ssn->人數}})',
                           parent: 'id-{{ $team }}',
                           value: {{$ssn->人數}}
                           },
                        @else

                           {name: '{{$ssn->科系}}<br/>({{$ssn->人數}})',
                           parent: 'id-{{ $team }}',
                           value: {{$ssn->人數}}
                           },
                        @endif
                    @endforeach
                ]
            }],

            breadcrumbs: {
                enabled: true,
                showFullPath: true,
                separator: {
                    text: ' / '
                }
            },
            subtitle: {
                text: '<a href="../TreemapMore_test?year={{$nowyear}}">詳細資料</a>.'
            },
            title: {
                text: '日間部來源學校分析(全學制)前20間',
                style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'20px'
                }
            },
            data:{style: {
                fontFamily:'Microsoft JhengHei',
                fontSize:'20px'
            }}

        });

        Highcharts.chart('container2', {
            plotOptions: {
                series: {
                    turboThreshold: 2000000 // 或者更多，必須大於陣列長度（1440）
                }
            },
            credits: {
                enabled: false   //刪除右下標籤
            },   
            series: [{
                type: 'treemap',
                name: '不分校',
                layoutAlgorithm: 'squarified',
                allowDrillToNode: true,
                animationLimit: 1000,
                dataLabels: {
                    enabled: false,
                    color:"#444444",
                    style:{textOutline:"#DDDDDD",fontFamily:'Microsoft JhengHei',},
                },
                levelIsConstant: false,
                levels: [{
                    level: 1,
                    dataLabels: {
                        enabled: true
                    },
                    borderWidth: 3
                }],
                data:[
                    @php
                      $temp = "";
                      $team = 0;
                    @endphp
                    
                    @foreach($StudentSourceNumber_five as $ssn)

                        @if($ssn->入學前學校 != $temp)
                          @php
                          $temp = $ssn->入學前學校;
                          $team+=1;
                          @endphp
                          
                           {name:'{{$temp}}<br/>({{$ssn->學校人數}})',
                           id:'id-{{ $team }}',
                           color:'{{$ssn->顏色}}'
                           },
                          {name: '{{$ssn->科系}}<br/>({{$ssn->人數}})',
                           parent: 'id-{{ $team }}',
                           value: {{$ssn->人數}}
                           },
                        @else

                           {name: '{{$ssn->科系}}<br/>({{$ssn->人數}})',
                           parent: 'id-{{ $team }}',
                           value: {{$ssn->人數}}
                           },
                        @endif
                    @endforeach
                ]
            }],

            breadcrumbs: {
                enabled: true,
                showFullPath: true,
                separator: {
                    text: ' / '
                }
            },
            subtitle: {
                text: '<a href="../TreemapMore_test?system=五專&year={{$nowyear}}">詳細資料</a>.'
            },
            title: {
                text: '日間部來源學校分析(五專)前20間',
                style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'20px'
                }
            },
            data:{style: {
                fontFamily:'Microsoft JhengHei',
                fontSize:'20px'
            }}

        });
        Highcharts.chart('container3', {
            plotOptions: {
                series: {
                    turboThreshold: 2000000 // 或者更多，必須大於陣列長度（1440）
                }
            },
            credits: {
                enabled: false   //刪除右下標籤
            },   
            series: [{
                type: 'treemap',
                name: '不分校',
                layoutAlgorithm: 'squarified',
                allowDrillToNode: true,
                animationLimit: 1000,
                dataLabels: {
                    enabled: false,
                    color:"#444444",
                    style:{textOutline:"#DDDDDD",fontFamily:'Microsoft JhengHei',},
                },
                levelIsConstant: false,
                levels: [{
                    level: 1,
                    dataLabels: {
                        enabled: true
                    },
                    borderWidth: 3
                }],
                data:[
                    @php
                      $temp = "";
                      $team = 0;
                    @endphp
                    
                    @foreach($StudentSourceNumber_fs as $ssn)

                        @if($ssn->入學前學校 != $temp)
                          @php
                          $temp = $ssn->入學前學校;
                          $team+=1;
                          @endphp
                          
                           {name:'{{$temp}}<br/>({{$ssn->學校人數}})',
                           id:'id-{{ $team }}',
                           color:'{{$ssn->顏色}}'
                           },
                          {name: '{{$ssn->科系}}<br/>({{$ssn->人數}})',
                           parent: 'id-{{ $team }}',
                           value: {{$ssn->人數}}
                           },
                        @else

                           {name: '{{$ssn->科系}}<br/>({{$ssn->人數}})',
                           parent: 'id-{{ $team }}',
                           value: {{$ssn->人數}}
                           },
                        @endif
                    @endforeach
                ]
            }],

            breadcrumbs: {
                enabled: true,
                showFullPath: true,
                separator: {
                    text: ' / '
                }
            },
            subtitle: {
                text: '<a href="../TreemapMore_test?system=四技&year={{$nowyear}}">詳細資料</a>.'
            },
            title: {
                text: '日間部來源學校分析(四技)前20間',
                style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'20px'
                }
            },
            data:{style: {
                fontFamily:'Microsoft JhengHei',
                fontSize:'20px'
            }}

        });
        Highcharts.chart('container4', {
            plotOptions: {
                series: {
                    turboThreshold: 2000000 // 或者更多，必須大於陣列長度（1440）
                }
            },credits: {
                enabled: false   //刪除右下標籤
            },   
            series: [{
                type: 'treemap',
                name: '不分校',
                layoutAlgorithm: 'squarified',
                allowDrillToNode: true,
                animationLimit: 1000,
                dataLabels: {
                    enabled: false,
                    color:"#444444",
                    style:{textOutline:"#DDDDDD",fontFamily:'Microsoft JhengHei',} 
                },
                levelIsConstant: false,
                levels: [{
                    level: 1,
                    dataLabels: {
                        enabled: true
                    },
                    borderWidth: 3
                }],
                data:[
                    @php
                      $temp = "";
                      $team = 0;
                    @endphp
                    
                    @foreach($StudentSourceNumber_second as $ssn)

                        @if($ssn->入學前學校 != $temp)
                          @php
                          $temp = $ssn->入學前學校;
                          $team+=1;
                          @endphp
                          
                           {name:'{{$temp}}<br/>({{$ssn->學校人數}})',
                           id:'id-{{ $team }}',
                           color:'{{$ssn->顏色}}'
                           },
                          {name: '{{$ssn->科系}}<br/>({{$ssn->人數}})',
                           parent: 'id-{{ $team }}',
                           value: {{$ssn->人數}}
                           },
                        @else

                           {name: '{{$ssn->科系}}<br/>({{$ssn->人數}})',
                           parent: 'id-{{ $team }}',
                           value: {{$ssn->人數}}
                           },
                        @endif
                    @endforeach
                ]
            }],

            breadcrumbs: {
                enabled: true,
                showFullPath: true,
                separator: {
                    text: ' / '
                }
            },
            subtitle: {
                text: '<a href="../TreemapMore_test?system=二技&year={{$nowyear}}">詳細資料</a>.'
            },
            title: {
                text: '日間部來源學校分析(二技)前20間',
                style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'20px'
                }
            },
            data:{style: {
                fontFamily:'Microsoft JhengHei',
                fontSize:'20px'
            }}

        });
        Highcharts.chart('container5', {
            plotOptions: {
                series: {
                    turboThreshold: 2000000 // 或者更多，必須大於陣列長度（1440）
                }
            },credits: {
                enabled: false   //刪除右下標籤
            },   
            series: [{
                type: 'treemap',
                name: '不分校',
                layoutAlgorithm: 'squarified',
                allowDrillToNode: true,
                animationLimit: 1000,
                dataLabels: {
                    enabled: false,
                    color:"#444444",
                    style:{textOutline:"#DDDDDD",fontFamily:'Microsoft JhengHei',},
                },
                levelIsConstant: false,
                levels: [{
                    level: 1,
                    dataLabels: {
                        enabled: true
                    },
                    borderWidth: 3
                }],
                data:[
                    @php
                      $temp = "";
                      $team = 0;
                    @endphp
                    
                    @foreach($StudentSourceNumber_master as $ssn)

                        @if($ssn->入學前學校 != $temp)
                          @php
                          $temp = $ssn->入學前學校;
                          $team+=1;
                          @endphp
                          
                           {name:'{{$temp}}<br/>({{$ssn->學校人數}})',
                           id:'id-{{ $team }}',
                           color:'{{$ssn->顏色}}'
                           },
                          {name: '{{$ssn->科系}}<br/>({{$ssn->人數}})',
                           parent: 'id-{{ $team }}',
                           value: {{$ssn->人數}}
                           },
                        @else

                           {name: '{{$ssn->科系}}<br/>({{$ssn->人數}})',
                           parent: 'id-{{ $team }}',
                           value: {{$ssn->人數}}
                           },
                        @endif
                    @endforeach
                ]
            }],

            breadcrumbs: {
                enabled: true,
                showFullPath: true,
                separator: {
                    text: ' / '
                }
            },
            subtitle: {
                text: '<a href="../TreemapMore_test?system=碩士班&year={{$nowyear}}">詳細資料</a>.'
            },
            title: {
                text: '日間部來源學校分析(碩士班)前20間',
                style: {
                    fontFamily:'Microsoft JhengHei',
                    fontSize:'20px'
                }
            },
            data:{style: {
                fontFamily:'Microsoft JhengHei',
                fontSize:'20px'
            }}

        });
    </script>
    @endpush
@stop