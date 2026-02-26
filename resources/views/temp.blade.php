<!DOCTYPE html>
<html lang="zh-TW">
<head>
  @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nutc</title>
    
    <link rel="Shortcut Icon" type="image/x-icon" href="img/icon.jpg" />
    {{-- b4-cdn-css --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
{{-- 新版本有些功能停止支援 --}}
{{--     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> --}}

    {{-- b4-cdn-js: 使用完整版 jQuery 以支援動畫效果 (fadeIn/fadeOut) --}}
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
{{-- 新版本有些功能停止支援 --}}
{{--     <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
{{-- 新版本有些功能停止支援 --}}
{{--     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script> --}}
    
    {{-- Polyfills: 現代瀏覽器通常不需要，如需支援舊版 IE 再啟用 --}}
    {{-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> --}}
    
<link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sidebars/">
   <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    
  

    <style type="text/css">
    /*header*/
        .fontvmin {
            font-size:4vmin;
        }
        .tlfontvmin {
            font-size:6vmin;
        }

    @media screen and (max-width: 766px) {
        .fontvmin {
            font-size:7vmin;
        }
        .tlfontvmin {
            font-size:10vmin;
        }
    }
    /*footer*/
        .footerbg {
        background-color:rgb(33,66,109);
        color:white;
        font-family:Microsoft JhengHei;
        text-align: center;
        padding-top:1vh;
    }
    .footerfont {
        font-size:1vw;
    }
    .footerimg {
        width:5vw;
    }
    .footerimg2 {
        width:15vw;
    }
    .footerdiv {
        height:50vh;
    }
    @media screen and (max-width: 795px) {
        .footerfont {
            font-size:2vw;
        }
        .footerimg {
            width:8vw;
        }
        .footerdiv {
            height:17vh;
        }
        .footerimg2 {
            width:20vw;
        } 
    }

    /*--- sticky footer ---*/
    html, body {
        height: 100%;
    }
    .mm-page {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    .mm-page__content-wrapper {
        flex: 1;
    }

    </style>
    <link rel="stylesheet" href="{{URL::asset('css/normalize.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/side.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/canvi.css')}}">
    <link rel="stylesheet" href="{{URL::asset('mmenu/mmenu.css')}}">

</head>
<body  onload="@yield('tigger')@yield('tigger2')@yield('tigger3')@yield('tigger4')@yield('tigger5')@yield('tigger6')">


 <aside class="myCanvasNav canvi-navbar">
        <div class="canvi-user-info">
            
            <div class="canvi-user-info__data">
                <span class="canvi-user-info__title"><i class="far fa-link fa-2x"style="color: white;"></i>頁面選單</span>
                <div class="canvi-user-info__close" onclick="t.close();"></div>
            </div>
        </div>
      <ul class="list-unstyled ps-0">
        <li class="mb-1">
        <button class="btn-lg btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home" aria-expanded="false">
          回首頁
        </button>
        <div class="collapse" id="home">
           <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
           <li style="margin-left:18px;"><a href="ir"class="link-dark ">
                首頁連結  </a>
             </li>
           </ul>
        </div>
      </li>
      <li class="mb-1">
        <button class="btn-lg btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
          學生類
        </button>
        <div class="collapse" id="dashboard-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
        <li class="link-dark ">
            <button style="margin-left: 18px;"class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#student" aria-expanded="false">
               學生人數分析
              </button>
           <div class="collapse" id="student">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                @if(isset($menuLinks['link_student']) && $menuLinks['link_student'])
                    @for($i = 0; $i < $menuLinks['link_student'] - 105 && $i < 5; $i++)
                        @php $year = (int)$menuLinks['link_student'] - $i; @endphp
                        <li style="margin-left:18px;"><a href="{{ url('student/?year=' . $year) }}" class="link-dark">{{ $year }}</a></li>
                    @endfor
                @endif
              </ul>
          </div>
        </li>

        <li>
            <button style="margin-left: 18px;" class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#s_suspension" aria-expanded="false">
               休學人數分析
              </button>
           <div class="collapse" id="s_suspension">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                @if(isset($menuLinks['link_s_suspension']) && $menuLinks['link_s_suspension'])
                    @for($i = 0; $i < $menuLinks['link_s_suspension'] - 105 && $i < 5; $i++)
                        @php $year = (int)$menuLinks['link_s_suspension'] - $i; @endphp
                        <li style="margin-left:18px;"><a href="{{ url('s_suspension/?year=' . $year) }}" class="link-dark">{{ $year }}</a></li>
                    @endfor
                @endif
              </ul>
          </div>
        </li>

        <li>
            <button style="margin-left: 18px;" class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#s_dropout" aria-expanded="false">
               退學人數分析
              </button>
           <div class="collapse" id="s_dropout">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                @if(isset($menuLinks['link_s_dropout']) && $menuLinks['link_s_dropout'])
                    @for($i = 0; $i < $menuLinks['link_s_dropout'] - 105 && $i < 5; $i++)
                        @php $year = (int)$menuLinks['link_s_dropout'] - $i; @endphp
                        <li style="margin-left:18px;"><a href="{{ url('s_dropout/?year=' . $year) }}" class="link-dark">{{ $year }}</a></li>
                    @endfor
                @endif
              </ul>
          </div>
        </li>
            
          </ul>
        </div>
      </li>
      <li class="mb-1">
        <button  class="btn-lg btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#teacher-collapse" aria-expanded="false">
          教師類
        </button>
        <div class="collapse" id="teacher-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            
            <li>
        <button style="margin-left: 18px;" class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#teacher" aria-expanded="false">
          教師人數分析
        </button>
             <div class="collapse" id="teacher">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                @if(isset($menuLinks['link_teacher']) && $menuLinks['link_teacher'])
                    @for($i = 0; $i < $menuLinks['link_teacher'] - 105 && $i < 5; $i++)
                        @php $year = (int)$menuLinks['link_teacher'] - $i; @endphp
                        <li style="margin-left:18px;"><a href="{{ url('teacher/?year=' . $year) }}" class="link-dark">{{ $year }}</a></li>
                    @endfor
                @endif
              </ul>
          </div>
         </li>


            <li>
        <button style="margin-left: 18px;" class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#tpr" aria-expanded="false">
          生師比率分析
        </button>
             <div class="collapse" id="tpr">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                @if(isset($menuLinks['link_tpr']) && $menuLinks['link_tpr'])
                    @for($i = 0; $i < 5; $i++)
                        @php $year = (int)$menuLinks['link_tpr'] - $i; @endphp
                        <li style="margin-left:18px;"><a href="{{ url('tpr/?year=' . $year) }}" class="link-dark">{{ $year }}</a></li>
                    @endfor
                @endif
              </ul>
          </div>
         </li>


            <li>
        <button style="margin-left: 18px;" class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#teacherHour" aria-expanded="false">
          每週授課時數分析
        </button>
             <div class="collapse" id="teacherHour">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                @if(isset($menuLinks['link_teacherHour']) && $menuLinks['link_teacherHour'])
                    @for($i = 0; $i < $menuLinks['link_teacherHour'] - 105 && $i < 5; $i++)
                        @php $year = (int)$menuLinks['link_teacherHour'] - $i; @endphp
                        <li style="margin-left:18px;"><a href="{{ url('TeachHour/?year=' . $year) }}" class="link-dark">{{ $year }}</a></li>
                    @endfor
                @endif
              </ul>
          </div>
         </li>

            
          </ul>
        </div>
      </li>
       <li class="mb-1">
        <button class="btn-lg btn-toggle align-items-center  collapsed" data-bs-toggle="collapse" data-bs-target="#Admissions-collapse" aria-expanded="false">
          招生類
        </button>
        <div class="collapse" id="Admissions-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li>
        <button style="margin-left: 18px;" class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#treemap" aria-expanded="false">
          學生生源分析
        </button>
             <div class="collapse" id="treemap">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                @if(isset($menuLinks['link_treemap']) && $menuLinks['link_treemap'])
                    @for($i = 0; $i <= $menuLinks['link_treemap'] - 109 && $i < 3; $i++)
                        @php $year = (int)$menuLinks['link_treemap'] - $i; @endphp
                        <li style="margin-left:18px;"><a href="{{ url('treemap/?year=' . $year) }}" class="link-dark">{{ $year }}</a></li>
                    @endfor
                @endif
              </ul>
          </div>
         </li>

            <li>
        <button style="margin-left: 18px;" class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#EnrollmentAnalysis" aria-expanded="false">
          入學管道分析
        </button>
             <div class="collapse" id="EnrollmentAnalysis">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                @if(isset($menuLinks['link_EnrollmentAnalysis']) && $menuLinks['link_EnrollmentAnalysis'])
                    @for($i = 0; $i < $menuLinks['link_EnrollmentAnalysis'] - 105 && $i < 3; $i++)
                        @php $year = (int)$menuLinks['link_EnrollmentAnalysis'] - $i; @endphp
                        <li style="margin-left:18px;"><a href="{{ url('EnrollmentAnalysis?value=資訊工程系&year=' . $year) }}" class="link-dark">{{ $year }}</a></li>
                    @endfor
                @endif
              </ul>
          </div>
         </li>


         <button style="margin-left: 18px;" class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#enrollment-dashboard" aria-expanded="false">
          群類招生分析
        </button>
             <div class="collapse" id="enrollment-dashboard">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li style="margin-left:18px;"><a href="{{ url('EnrollmentDashboard') }}" class="link-dark" style="font-size:14px;">群類招生試算平台</a></li>
              </ul>
          </div>
         </li>

          </ul>
        </div>
      </li>
     </ul>
    </aside>


    {{-- header --}}
        <!-- <div class="container-fluid" style="
            height:13vw; 
            background-color:rgb(33,66,109);
            min-height:70px;
            max-height:120px;
            padding:0px;">

            <table style="width:100%;height:100%">
                <tr>
                    <td align="center">
                    
                     <button class="js-canvi-open-button--left btn js-canvi-content canvi-content"type="button"style="background-color:rgb(33,66,109);" >
                        <i class="fas fa-bars fa-2x"style="color: white;"></i>
                     </button>
               
                  {{-- <div  style="padding:0px">
                            <a href="#menu"><i class="fas fa-bars fa-2x"style="color: white;"></i></a>
                        </div> --}}

                    </td>

                    <td>
                        <span class="text-white" style="font-size:4vw;font-family:Microsoft JhengHei;">
                            　@yield("title")
                        </span>
                    </td>
                    <td align="right" style="padding:2vh;">
                      <a href="ir" >  <img src="img/school.png" style="height:7vw;max-height:8vh" ></a>
                    </td>
                </tr>
            </table>
            </div> -->
                      <div class="container-fluid px-3"
               style="background-color:rgb(33,66,109);">

              <div class="d-flex align-items-center"
                   style="min-height:90px;">

                  {{-- 左：漢堡選單（⚠️ class 必須保留） --}}
                  <button
                      class="btn js-canvi-open-button--left btn js-canvi-content canvi-content p-0 mr-3"
                      type="button"
                      style="background-color:transparent;">
                      <i class="fas fa-bars fa-2x text-white"></i>
                  </button>

                  {{-- 中：標題（靠左） --}}
                  <div class="text-white"
                       style="
                          font-family: Microsoft JhengHei;
                          font-size: clamp(1.2rem, 2.5vw, 2rem);
                          white-space: nowrap;
                          overflow: hidden;
                          text-overflow: ellipsis;
                          font-weight: 700;
                       ">
                     @yield("title")
                  </div>

                  {{-- 右：Logo（固定靠右） --}}
                  <div class="ml-auto">
                      <a href="ir">
                          <img src="img/school.png"
                               alt="NUTC"
                               style="height:40px; max-height:50px;">
                      </a>
                  </div>

              </div>
          </div>




            <div class='modal fade' id='newcontent' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true' style='font-family:Microsoft JhengHei;'>
              <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <h3 class='modal-title' id='exampleModalLongTitle'>資料更新紀錄</h3>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>&times;</span>
                    </button>
                  </div>
                  <div class='modal-body'>
                  <h5>配合大專校院公開資料庫資料更新進度新增</h5>
                  </div>
                  <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>關閉</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
    {{-- content --}}
    <div class="mm-page mm-slideout" id="mm-0">
        <div class="mm-page__content-wrapper" style="flex: 1;">  
        <div id="container-fluid" >
            @yield("content")
        </div>
    </div>
    </div>
    
    {{-- Chart Libraries: 先加载，使用可靠的 CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    
    {{-- 使用 cdnjs 作为主要来源（更稳定） --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/9.3.3/highcharts.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/9.3.3/modules/exporting.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/9.3.3/modules/export-data.min.js"></script>
    
    {{-- 验证加载状态 --}}
    <script>
        window.addEventListener('load', function() {
            if (typeof Highcharts !== 'undefined') {
                console.log('✓ Highcharts loaded successfully');
            } else {
                console.error('✗ Highcharts failed to load');
            }
        });
    </script>

    {{-- 頁面自訂附加 scripts（如 Highcharts modules: data.js, heatmap.js, treemap.js 等）--}}
    @yield('link')

    {{-- 页面自定义 scripts --}}
    @stack('scripts')
    
        {{-- footer --}}
        <footer class='footerbg' >
            <table width='100%'>
                <tr>
                    <td width='33%'>
                    </td>    
                    <td width='33%'>
        
                        <a href='https://www.nutc.edu.tw/bin/home.php' target='_blank'><img class='footerimg2' src='img/logo_w.png'></a>
                    </td>
                    <td width='33%' valign='bottom' align='right' style='padding-right:2%;'>
                        <a style='text-decoration:none;margin-right:1vw;' data-toggle='modal' data-target='#newcontent' > <img class='footerimg'  src='img/new.png'></a>
                       {{--  <a style='text-decoration:none;' href='https://lin.ee/C0bvLxC' target='_blank' > <img class='footerimg' src='img/linefix.png'></a><br> --}}
                    </td>    
                </tr>
            </table>
            <span class="footerfont"> Copyright ©國立臺中科技大學校務研究中心 {{date("Y")}}版權所有</span>
        </footer>
    </div>

<script  src="{{URL::asset('js/canvi.js')}}"></script>
<script type="text/javascript">
        var t = new Canvi({
            content: ".js-canvi-content",
            isDebug: !1,
            navbar: ".myCanvasNav",
            openButton: ".js-canvi-open-button--left",
            position: "left",
            pushContent: !1,
            speed: "0.4s",
            width: "100vw",
            responsiveWidths: [{
                breakpoint: "600px",
                width: "280px"
            }, {
                breakpoint: "1280px",
                width: "300px"
            }, {
                breakpoint: "1600px",
                width: "280px"
            }]
        })
    </script>
<script src="{{URL::asset('js/bootstrap.bundle.min.js')}}"></script>
<script  src="{{URL::asset('js/sidebars.js')}}"></script>

{{-- 新版菜單：由 MenuComposer 自動提供資料，已整合在側邊欄中 --}}
{{-- 舊版 mmenu 已停用 --}}
{{-- @include('components.menu') --}}
{{-- <script src="{{URL::asset('menu.js')}}"></script> --}}
{{-- <script src="{{URL::asset('mmenu/mmenu.js')}}"></script>
<script src="{{URL::asset('mmenu/mmenu.debugger.js')}}"></script>
<script>
    new Mmenu( document.querySelector( '#menu' ) );

    document.addEventListener( 'click', ( evnt ) => {
        let anchor = evnt.target.closest( 'a[href^="#/"]' );
        if ( anchor ) {
            alert('Thank you for clicking, but that\'s a demo link.');
            evnt.preventDefault();
        }
    });
</script> --}}

        <script>
//<![CDATA[
(function () {
$("body").append("<img id='goTopButton' style='display: none; z-index: 5; cursor: pointer;' title='回到頂端'/>");
var img = "https://1.bp.blogspot.com/-zMfrIkyhlVs/Uh7FePoKU8I/AAAAAAAAHnA/WA0H_vbWAWc/s1600/go-top.png",
locatioin = 1/2, // 按鈕出現在螢幕的高度
right = 10, // 距離右邊 px 值
opacity = 1, // 透明度
speed = 500, // 捲動速度
$button = $("#goTopButton"),
$body = $(document),
$win = $(window);
$button.attr("src", img);
$button.on({
mouseover: function() {$button.css("opacity", 1);},
mouseout: function() {$button.css("opacity", opacity);},
click: function() {$("html, body").animate({scrollTop: 0}, speed);}
});
window.goTopMove = function () {
var scrollH = $body.scrollTop(),
winH = $win.height(),
css = {"top": winH * locatioin + "px", "position": "fixed", "right": right, "opacity": opacity};
if(scrollH > 20) {
$button.css(css);
$button.fadeIn("slow");
} else {
$button.fadeOut("slow");
}
};
$win.on({
scroll: function() {goTopMove();},
resize: function() {goTopMove();}
});
} )();
//]]>
</script>
@livewireScripts
</body>
</html>

