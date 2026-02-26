<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
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
</head>
<body style="font-family:Microsoft JhengHei;background-color:#FFD700;">
    <div class="full-height" style="padding-top:80px;text-align:center;margin-bottom:150px;">
        <div class="card text-warning border-0" style="background-color:#FFD700;">
            <img class="card-img" src="img/數據校園.png" alt="Card image" width="80%" style="max-width:600px; display:block; margin:auto;">
           {{--  <div class="card-img-overlay" width="80%" style="font-size: 10vmin;
                            font-weight: bold; 
                            -webkit-text-stroke: 1px #FFD700;
                            font-family: arial; 
                            color: black;">
                    <br>{{$SchoolTitle}}<br>　　{{$SchoolSecTitle}}
                    <br>

            </div> --}}
        </div>
        {{-- <img src="img/數據校園.png" width="80%" style="max-width:600px; display:block; margin:auto;"> --}}
        <br><br>
        <a class="btn btn-primary" data-toggle="collapse" href="#student" role="button" aria-expanded="false" aria-controls="multiCollapseExample1" style="border-radius:80px;padding-right:59px;padding-left:30px;">
            <table>
            <tr>
                <td style="padding-right:20px;">
                    <img src="img/graduation.png" class="img-fluid" style="width:10vh;">
                </td>
                <td><h2>學生類</h2></td>
            </tr>
            </table>
        </a>

        <div class="collapse multi-collapse" id="student">
            <div style="margin-top:20px;">
                <a href="student" class="btn btn-primary" role="button" style="border-radius: 80px;" >
                    <h2 style="color:white;">學生人數分析</h2>
                </a>
            </div>

            <div style="margin-top:20px;">
                <a href="s_suspension" class="btn btn-primary" role="button" style="border-radius: 80px;">
                    <h2 style="color:white;">休學人數分析</h2>
                </a>
            </div>

            <div style="margin-top:20px;">
                <a href="s_dropout" class="btn btn-primary" role="button" style="border-radius: 80px;">
                    <h2 style="color:white;">退學人數分析</h2>
                </a>
            </div>
        </div>
        <br>
        <a class="btn btn-danger" data-toggle="collapse" href="#teacher" role="button" aria-expanded="false" aria-controls="multiCollapseExample1" style="border-radius:80px;padding-right:59px;margin-top:40px;padding-left:30px;">
            <table>
                <tr>
                    <td style="padding-right:20px;">
                        <img src="img/blackboard.png" class="img-fluid" style="width:10vh;">
                    </td>
                    <td><h2>教師類</h2></td>
                </tr>
            </table>
        </a>

        <div class="collapse multi-collapse" id="teacher">
            <div style="margin-top:20px;">
                <a href="teacher" class="btn btn-danger" role="button" style="border-radius: 80px;">
                    <h2 style="color:white;">教師人數分析</h2>
                </a>
            </div>

            <div style="margin-top:20px;">
                <a href="tpr" class="btn btn-danger" role="button" style="border-radius: 80px;">
                    <h2 style="color:white;">生師比率分析</h2>
                </a>
            </div>

            <div style="margin-top:20px;">
                <a href="TeachHour" class="btn btn-danger" role="button" style="border-radius: 80px;">
                    <h2 style="color:white;">授課時數分析</h2>
                </a>
            </div>

        </div>

        <br>
        <a class="btn btn-success" data-toggle="collapse" href="#recruit" role="button" aria-expanded="false" aria-controls="multiCollapseExample1" style="border-radius:80px;padding-right:59px;margin-top:40px;padding-left:30px;">
            <table>
            <tr>
                <td style="padding-right:20px;"><img src="img/research.png" class="img-fluid" style="width:10vh;"></td>
                <td><h2>招生類</h2></td>
            </tr>
            </table>
        </a>

        <div class="collapse multi-collapse" id="recruit">
            <div style="margin-top:20px;">
                <a href="treemap" class="btn btn-success" role="button" style="border-radius: 80px;">
                    <h2 style="color:white;padding-right:15px;padding-left:15px;">學生生源分析</h2>
                </a>
            </div>
            <div style="margin-top:20px;">
                <a href="EnrollmentAnalysis" class="btn btn-success" role="button" style="border-radius: 80px;">
                    <h2 style="color:white;padding-right:15px;padding-left:15px;">入學管道分析</h2>
                </a>
            </div>
            <div style="margin-top:20px;">
                <a href="EnrollmentDashboard" class="btn btn-success" role="button" style="border-radius: 80px;">
                    <h2 style="color:white;padding-right:15px;padding-left:15px;">群類招生分析</h2>
                </a>
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
              <ul>
              </ul>
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>關閉</button>
              </div>
            </div>
          </div>
        </div>
    </div>
    <footer class='footerbg' >
        <table width='100%'>
            <tr>
                <td width='33%'></td>
                <td width='33%'>
                    <a href='https://www.nutc.edu.tw/bin/home.php' target='_blank'><img class='footerimg2' src='img/logo_w.png'></a>
                </td>
                <td width='33%' valign='bottom' align='right' style='padding-right:2%;'>
                    <a style='text-decoration:none;margin-right:1vw;' data-toggle='modal' data-target=' #newcontent' > <img class='footerimg'  src='img/new.png'></a>
                   {{--  line註解 --}}
                    {{-- <a style='text-decoration:none;' href='https://lin.ee/C0bvLxC' target='_blank'><img class='footerimg' src='img/linefix.png'></a><br> --}}
                </td>
            </tr>
        </table>
        <span class="footerfont">Copyright ©國立臺中科技大學校務研究中心 {{date("Y")}}版權所有</span>
    </footer>

</body>
</html>
