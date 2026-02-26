@extends("temp_back")
@section("link")
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
@stop
@section("class")
@stop
@section("content")
@php
    $edit_id = "";
    if(request()->has("edit"))
        $edit_id = key(request()->input("edit"));
    // echo session("ID");
@endphp
<body>
    <div class="content">
        <div style="width: auto; margin: 0 auto; margin-top: 15px;">
        <form method="post">
        {{ csrf_field() }}
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="bg-primary text-center" colspan="20">管理員編輯</th>
                </tr>
                <tr>
                    <th class="text-center bg-primary" width="50">功能</th>
                    <th class="text-center bg-primary" width="10">ID</th>
{{--                     @foreach($Field_name as $FN)
                        <th class="text-center bg-primary" width="100">{{$FN->column_name}}</th>
                    @endforeach --}}
                    <th class="text-center bg-primary" width="100">信箱</th>
                    <th class="text-center bg-primary" width="80">密碼</th>
                    <th class="text-center bg-primary" width="100">名稱</th>
                    <th class="text-center bg-primary" width="120">創建日期</th>
                    <th class="text-center bg-primary" width="120">更新日期</th>
                </tr>
            </thead>
            @foreach($user as $u)
                <tr>
                <td>
                    @if( $edit_id == $u->id )
                        <input type="submit"  name="save[{{ $u->id }}]" class="btn btn-success btn-sm text-center" value="存檔">
                        <input type="submit" class="btn btn-secondary btn-sm text-center" value="取消">
                    @else
                        <input type="submit" name="edit[{{ $u->id }}]" class="btn btn-primary btn-sm text-center" value="編輯" onclick="location.href='#{{ $u->id }}'">
                    @endif
                </td>
                <td id='{{$u->id }}'>{{$u->id }}</td>
                <td>
                    @if( $edit_id == $u->id )
                        <input type="text" 
                               class="form-control"
                               name="edit_email"
                               value="{{$u->user_email}}"
                        >
                    @else
                        {{$u->user_email}}
                    @endif
                </td>
                <td>
                    @if( $edit_id == $u->id )
                        <input type="text" 
                               class="form-control"
                               name="edit_pw"
                               value="{{$u->user_pw}}"
                        >
                    @else
                        {{$u->user_pw}}
                    @endif
                </td>
                <td>
                    @if( $edit_id == $u->id )
                        <input type="text" 
                               class="form-control"
                               name="edit_name"
                               value="{{$u->user_name}}"
                        >
                    @else
                        {{$u->user_name}}
                    @endif
                </td>
                <td>{{$u->createdate}}</td>
                <td>{{$u->updatedate}}</td>
            </tr>
            @endforeach
        </table>
        </form>
        </div>
        {{-- {{ $user->links() }} --}}
    </div>
@stop
