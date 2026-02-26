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
                    <th class="bg-primary text-center" colspan="20">教師學院系科編輯</th>
                </tr>
                <tr>
                    <td style="border-style: hidden;">
                        系所代碼
                    </td>
                    <td colspan="3" style="border-style: hidden;">
                        <input class="form-control" 
                               list="CODE_Options" 
                               name="search_DEP_CODE" 
                               style="font-size:18px;" 
                        >
                        <datalist id="CODE_Options">
                            @foreach($t_dep_code as $s)
                                <option value="{{ $s }}"></option>
                            @endforeach
                        </datalist>
                    </td>
                    <td colspan="20" style="border-style: hidden;">
                        {{-- 學制班別
                        <select name="search_SCH_SYS">
                            <option value="">無</option>
                            @foreach($s_sch_sys as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                            @endforeach
                        </select> --}}
                        <input class="btn btn-success" type="submit" name="search" value="搜尋">
                        <input type="submit"  name="up" class="btn btn-danger text-center pull-right" value="執行預存">
{{--                         <input class="btn btn-outline-secondary" type="submit" name="clear" value="清空搜尋" href="{{ url('/backedit') }}"> --}}
                    </td>
                </tr>
                <tr>
                    <td colspan="20" style="border-style: hidden;">
                        {{--                         @if($null_list)
                        @else --}}
                        @forelse ($null_list as $n)
                        <div class="alert alert-danger" role="alert">
                            欄位不完整：
                            @foreach($null_list as $n)
                            <a href="#{{ $n }}">{{ $n }}</a> 
                            @endforeach

                        </div>
                        @break
                        @empty
                        @endforelse
                        {{-- @endif --}}
                    </td>
                </tr>
                <tr>
                    <th class="text-center bg-primary" width="50">功能</th>
                    <th class="text-center bg-primary" width="10">ID</th>
{{--                     @foreach($Field_name as $FN)
                        <th class="text-center bg-primary" width="100">{{$FN->column_name}}</th>
                    @endforeach --}}
                    <th class="text-center bg-primary" width="50">學年</th>
                    <th class="text-center bg-primary" width="100">系所代碼</th>
                    <th class="text-center bg-success text-white" width="100">系所名稱</th>
                    <th class="text-center bg-success text-white" width="100">系所簡單名稱</th>
                    <th class="text-center bg-success text-white" width="120">學院</th>
                    <th class="text-center bg-success text-white" width="100">學院代碼</th>
                </tr>
            </thead>
            @foreach($College as $col)
            @if ($col->department == null or
                 $col->department_simple == null or
                 $col->college == null or
                 $col->Collegecode == null
                )
                <tr style="background: orange">
            @else
                <tr>
            @endif
                <td>
                    @if( $edit_id == $col->ID )
                        <input type="submit"  name="save[{{ $col->ID }}]" class="btn btn-success btn-sm text-center" value="存檔">
                        <input type="submit" class="btn btn-secondary btn-sm text-center" value="取消">
                    @else
                        <input type="submit" name="edit[{{ $col->ID }}]" class="btn btn-primary btn-sm text-center" value="編輯" onclick="location.href='#{{ $col->ID }}'">
                    @endif
                </td>
                <td id='{{$col->ID }}'>{{$col->ID }}</td>
                <td>{{$col->AD_YEAR}}</td>
                <td>{{$col->department_code}}</td>
                <td>
                    @if( $edit_id == $col->ID )
                        <input class="form-control" 
                               list="departmentOptions" 
                               name="edit_department" 
                               style="font-size:18px;" 
                               value="{{$col->department}}"
                        >
                        <datalist id="departmentOptions">
                            @foreach($t_department as $s)
                                <option value="{{$s}}">{{$s}}</option>
                            @endforeach
                        </datalist>
                    @else
                        {{$col->department}}
                    @endif
                </td>
                <td>
                    @if( $edit_id == $col->ID )
                        <input class="form-control" 
                               list="department_simpleOptions" 
                               name="edit_department_simple" 
                               style="font-size:18px;" 
                               value="{{$col->department_simple}}"
                        >
                        <datalist id="department_simpleOptions">
                            @foreach($t_dep_simple as $s)
                                <option value="{{$s}}">{{$s}}</option>
                            @endforeach
                        </datalist>
                    @else
                        {{$col->department_simple}}
                    @endif
                </td>
                <td>
                    @if( $edit_id == $col->ID )
                        <input class="form-control" 
                               list="collegeOptions" 
                               name="edit_college" 
                               style="font-size:18px;" 
                               value="{{$col->college}}"
                        >
                        <datalist id="collegeOptions">
                            @foreach($t_college as $s)
                                <option value="{{$s}}">{{$s}}</option>
                            @endforeach
                        </datalist>
                    @else
                        {{$col->college}}
                    @endif
                </td>
                <td>
                    @if( $edit_id == $col->ID )
                        <input class="form-control" 
                               list="CollegecodeOptions" 
                               name="edit_Collegecode" 
                               style="font-size:18px;" 
                               value="{{$col->Collegecode}}"
                        >
                        <datalist id="CollegecodeOptions">
                            @foreach($t_collegecode as $s)
                                <option value="{{$s}}">{{$s}}</option>
                            @endforeach
                        </select>
                        </datalist>
                    @else
                        {{$col->Collegecode}}
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
        </form>
        </div>
        {{-- {{ $user->links() }} --}}
    </div>
@stop
