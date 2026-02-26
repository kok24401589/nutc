@extends("temp_back")
@section("link")
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
@stop
@section("class")
@stop
@section("content")

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
    {{ csrf_field() }}
    <div style="width:500px; margin: 0 auto; margin-top: 10px;">
        <table class="table table-hover table-sm table-bordered">
            <thead>
                <tr>
                    <th align="center" colspan="2" class="text-center bg-dark text-white">
                        <span style="font-size: 20px;">管理員新增</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="right">
                        <label class="col-form-label font-weight-bold">E-mail</label>
                    </td>
                    <td>
                        <input type="text" name="user_email" value="{{ old("user_email") }}"  class="form-control">
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label class="col-form-label font-weight-bold">密碼
                    </td>
                    <td>
                        <input type="password" name="user_pw" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label class="col-form-label font-weight-bold">確認密碼</label>
                    </td>
                    <td>
                        <input type="password" name="user_repw" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label class="col-form-label font-weight-bold">姓名</label>
                    </td>
                    <td>
                        <input type="text" name="user_name" value="{{ old("user_name") }}" class="form-control">
                    </td>
                </tr>

            </tbody>
        </table>
        <div class="text-center">
            <input type="submit" name="register" class="btn btn-success" value="註冊">
        </div>
    </div>
    </form>
@stop
