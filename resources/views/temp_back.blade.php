<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>後臺管理</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/offcanvas-navbar/">
   <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sidebars/">
   <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
   <link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.min.css')}}"/>
   <link rel="Shortcut Icon" type="image/x-icon" href="img/icon.jpg" />
	@yield("link")
</head>

<body  @yield("class")>


	<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
  <div class="container-fluid">
    <a class="navbar-brand" href="back_home">後臺管理</a>
    <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">首頁</a>
          <ul class="dropdown-menu" aria-labelledby="dropdown01">
            <li><a class="dropdown-item" href="back_home">後臺首頁</a></li>
            <li><a class="dropdown-item" href="ir">網頁首頁</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">資料上傳</a>
          <ul class="dropdown-menu" aria-labelledby="dropdown01">
            <li><a class="dropdown-item" href="impot_from_student">學生類</a></li>
            <li><a class="dropdown-item" href="impot_from_teacher">教師類</a></li>
            <li><a class="dropdown-item" href="impot_from_EnrollmentAnalysis">學生生源類</a></li>
            <li><a class="dropdown-item" href="impot_from_customized">院系科自訂表</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">資料編輯</a>
          <ul class="dropdown-menu" aria-labelledby="dropdown01">
            <li><a class="dropdown-item" href="backedit">院系科編輯</a></li>
            <li><a class="dropdown-item" href="backedit2">休退學院系科編輯</a></li>
           <li><a class="dropdown-item" href="backedit3">教師學院系科編輯</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
@yield("content")
 <script src="{{URL::asset('js/bootstrap.bundle.min.js')}}"></script>
 @yield("script")
</body>
</html>