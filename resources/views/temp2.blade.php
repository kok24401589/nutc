<!DOCTYPE html>
<html lang="zh-TW">
<head>
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

    {{-- b4-cdn-js --}}
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
{{-- 新版本有些功能停止支援 --}}
{{--     <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script> --}}

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
{{-- 新版本有些功能停止支援 --}}
{{--     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script> --}}
    {{-- 1 --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    {{-- IE 10 and 11 polyfills --}}
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
    {{-- others --}}
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js'></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?flags=gated&features=Array.prototype.filter%2CArray.prototype.forEach%2CArray.prototype.map%2CElement.prototype.cloneNode%2Cdocument.querySelector"></script>
    
<link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sidebars/">
   <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    
    @yield("link")

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
        height: 100%;

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


    </style>
    <link rel="stylesheet" href="{{URL::asset('css/normalize.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/side.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/canvi.css')}}">
    <link rel="stylesheet" href="{{URL::asset('mmenu/mmenu.css')}}">

</head>
<body  onload="@yield('tigger')@yield('tigger2')@yield('tigger3')@yield('tigger4')@yield('tigger5')@yield('tigger6')">
    <nav id=menu>
        <ul>
            <li><a href=ir>回首頁</a></li>
            <li><span>學生類</span>
                <ul>
                    <li><span>學生人數分析</span>
                        <ul>
                            @yield("link_student")
{{--                           <li><a href=student/?year=109>109</a></li>
                          <li><a href=student/?year=108>108</a></li>
                          <li><a href=student/?year=107>107</a></li>
                          <li><a href=student/?year=106>106</a></li> --}}
                        </ul>
                    </li>
                    <li><span>休學人數分析</span>
                        <ul>
                            @yield("link_s_suspension")
{{--                             <li><a href=s_suspension/?year=108>108</a></li>
                            <li><a href=s_suspension/?year=107>107</a></li>
                            <li><a href=s_suspension/?year=106>106</a></li> --}}
                        </ul>
                    </li>
                    <li><span>退學人數分析</span>
                        <ul>
                            @yield("link_s_dropout")
{{--                             <li><a href=s_dropout/?year=108>108</a></li>
                            <li><a href=s_dropout/?year=107>107</a></li>
                            <li><a href=s_dropout/?year=106>06</a></li> --}}
                        </ul>
                    </li>
                </ul>
            </li>
            <li><span>教師類</span>
                  <ul>
                    <li><span>教師人數分析</span>
                       <ul>
                            @yield("link_teacher")
{{--                             <li><a href=teacher/?year=109>109</a></li>
                            <li><a href=teacher/?year=108>108</a></li>
                            <li><a href=teacher/?year=107>107</a></li>
                            <li><a href=teacher/?year=106>106</a></li> --}}
                       </ul>
                     </li>
                    <li><a href=tpr>生師比率分析</a></li>
                    <li><a href=TeachHour>教師授課時數</a></li>
                </ul>
            </li>
              <li><span>招生類</span>
                <ul>
                    <li><a href=treemap>本校生源分析</a>
                    </li>
                </ul>
            </li>
              <li><span>資料來源</span>
                <ul>
                    <li><a href=https://udb.moe.edu.tw/>大專校院校務資訊公開</a>
                    </li>
                    <li><a >教務處</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    
    
        {{-- header --}}
    <div class="container-fluid" style="
        height:13vw; 
        background-color:rgb(33,66,109);
        min-height:70px;
        max-height:120px;
        padding:0px;">
    
        <table style="width:100%;height:100%">
            <tr>
                <td align="center">
               {{--  <main class="js-canvi-content canvi-content"style="background-color:rgb(33,66,109);">
                 <button class="js-canvi-open-button--left btn"type="button"style="background-color:rgb(    33,66,109);" >
                    <i class="fas fa-bars fa-2x"style="color: white;"></i>
                 </button>
             </main> --}}
              <div style="padding:0px">
                        <a href="#menu"><i class="fas fa-bars fa-2x"style="color: white;"></i></a>
                    </div>
    
                </td>
    
                <td>
                    <span class="text-white" style="font-size:4vw;font-family:Microsoft JhengHei;">
                        　@yield("title")
                    </span>
                </td>
                <td align="right" style="padding:2vh;">
                    <img src="img/school.png" style="height:7vw;max-height:8vh" >
                </td>
            </tr>
        </table>
    </div>
       
   
    {{-- content --}}
    <div class="mm-page mm-slideout" id="mm-0">
        <div style="padding-bottom: 10vw;">  
            <div id="container-fluid" >
                @yield("content")
            </div>
        </div>
    </div>
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
                <a style='text-decoration:none;margin-right:1vw;' data-toggle='modal' data-target=' #newcontent' > <img class='footerimg'  src='img/new.png'></a>
               {{--  <a style='text-decoration:none;' href='https://lin.ee/C0bvLxC' target='_blank' > <img class='footerimg' src='img/linefix.png'></a><br> --}}
            </td>    
        </tr>
    </table>
    <span class="footerfont"> Copyright ©國立臺中科技大學校務研究中心 {{date("Y")}}版權所有</span>
</footer>

<script  src="{{URL::asset('js/canvi.js')}}"></script>
<script type="text/javascript">
        var t = new Canvi({
            content: ".js-canvi-content",
            isDebug: !1,
            navbar: ".myCanvasNav",
            openButton: ".js-canvi-open-button--left",
            position: "left",
            pushContent: !1,
            speed: "0.2s",
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

        <script src="{{URL::asset('mmenu/mmenu.js')}}"></script>
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
        </script>
        <script>
//<![CDATA[
(function () {
$("body").append("<img id='goTopButton' style='display: none; z-index: 5; cursor: pointer;' title='回到頂端'/>");
var img = "http://1.bp.blogspot.com/-zMfrIkyhlVs/Uh7FePoKU8I/AAAAAAAAHnA/WA0H_vbWAWc/s1600/go-top.png",
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
</body>
</html>