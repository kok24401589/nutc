<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <!-- b4-cdn-css -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <!-- b4-cdn-js -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <link rel="Shortcut Icon" type="image/x-icon" href="img/icon.jpg" />
</head>
<body>
    @if($errors AND count($errors))
        <div class="alert alert-danger" style="width: 300px; margin: 0 auto; margin-top: 15px; ">
            <ul>
                @foreach($errors->all() as $err)
                    <li> {{ $err }} </li>
                @endforeach
            </ul>
        </div>
    @endif
  <form method="post">
    {{ csrf_field() }}    <div style="width:400px; margin: 0 auto; margin-top: 10px;">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th class="bg-dark text-center text-white" colspan="2">管理員登入</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="right">
                        <label class="col-form-label font-weight-bold">信箱</label>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="user_email" value="{{ old("user_account") }}"placeholder="請輸入信箱">
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label class="col-form-label font-weight-bold">密碼</label>
                    </td>
                    <td>
                        <input type="password" class="form-control" name="user_pw" placeholder="請輸入密碼">
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center">
          <input type="submit" name="login" class="btn btn-success" value="登入">
        </div>
    </div>
  </form>
</body>
</html>