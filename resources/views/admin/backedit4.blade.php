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
    echo session("ID");
@endphp
    <div class="content">
        <div style="width: auto; margin: 0 auto; margin-top: 15px;">
        <form method="post">
        {{ csrf_field() }}
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="bg-primary text-center" colspan="20">休退學院系科編輯</th>
                </tr>
                <tr>
                    <td colspan="20">
                        系所代碼
                        <select class="custom-select" name="search_DEP_CODE">
                            <option value="">無</option>
                            @foreach($s_dep_code as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                            @endforeach
                        </select>
                        學制班別
                        <select name="search_SCH_SYS">
                            <option value="">無</option>
                            @foreach($s_sch_sys as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                            @endforeach
                        </select>
                        <input class="btn btn-success" type="submit" name="search" value="搜尋">
                        <input type="submit"  name="duplicate" class="btn btn-danger text-center pull-right" value="清除重複資料">
                        <input type="submit"  name="up" class="btn btn-danger text-center pull-right" value="執行預存">
{{--                         <input class="btn btn-outline-secondary" type="submit" name="clear" value="清空搜尋" href="{{ url('/backedit') }}"> --}}
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
                    <th class="text-center bg-primary" width="30">功能</th>
                    <th class="text-center bg-primary" width="10">ID</th>
{{--                     @foreach($Field_name as $FN)
                        <th class="text-center bg-primary" width="100">{{$FN->column_name}}</th>
                    @endforeach --}}
                    <th class="text-center bg-primary" width="30">學年</th>
                    <th class="text-center bg-success text-white" width="100">學制</th>
                    <th class="text-center bg-success text-white" width="120">學院</th>
                    <th class="text-center bg-primary" width="60">系所代碼</th>
                    <th class="text-center bg-primary" width="100">系所名稱</th>
                    <th class="text-center bg-success text-white" width="100">系所簡單名稱</th>
                    <th class="text-center bg-primary" width="80">學制班別</th>
                    <th class="text-center bg-success text-white" width="30">系所顏色</th>
                    <th class="text-center bg-success text-white" width="30">學院顏色</th>
                    {{-- <th class="text-center bg-primary" width="100">學院圖示</th> --}}
                    {{-- <th class="text-center bg-primary" width="100">系所圖示</th> --}}
                    <th class="text-center bg-success text-white" width="90">學制代碼</th>
                    <th class="text-center bg-success text-white" width="90">班別代碼</th>
                    <th class="text-center bg-success text-white" width="90">學院代碼</th>
                </tr>
            </thead>
            @foreach($College as $col)
            @if ($col->SYSTEM_TYPE == null or
                 $col->COL == null or
                 $col->DEP_SIMPLE == null or
                 $col->DEP_COLOR == null or
                 $col->COL_COLOR == null or
                 $col->ST_NUM == null or
                 $col->SS_NUM == null or
                 $col->COL_NUM == null 
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
                <td>
                    @if( $edit_id == $col->ID )
                        {{-- <select name="edit_SYSTEM_TYPE" style="font-size:16px;"> --}}
                <input class="form-control" list="edit_SYSTEM_TYPE" name="edit_SYSTEM_TYPE" style="font-size:16px;"  value="{{$col->SYSTEM_TYPE}}">
                        <datalist id="edit_SYSTEM_TYPE">
                        @foreach($s_system_type as $s)
                            @if($s == $col->SYSTEM_TYPE)
                                <option value="{{$s}}" selected>{{$s}}</option>
                            @else
                                <option value="{{$s}}">{{$s}}</option>
                            @endif
                        @endforeach
                        </datalist>
                    @else
                        {{$col->SYSTEM_TYPE}}
                    @endif
                </td>
                <td>
                    @if( $edit_id == $col->ID )
                        {{-- <select name="edit_College" style="font-size:16px;"> --}}
                <input class="form-control" list="edit_College" name="edit_College" style="font-size:16px;"  value="{{$col->COL}}">
                        <datalist id="edit_College">
                        @foreach($s_college as $s)
                            @if($s == $col->COL)
                                <option value="{{$s}}" selected>{{$s}}</option>
                            @else
                                <option value="{{$s}}">{{$s}}</option>
                            @endif
                        @endforeach
                        </datalist>
                    @else
                        {{$col->COL}}
                    @endif
                </td>
                <td>{{$col->DEP_CODE}}</td>
                <td>{{$col->DEP_NAME}}</td>
                <td>
                    @if( $edit_id == $col->ID )
                        {{-- <select name="edit_DEP_SIMPLE" style="font-size:16px;" > --}}
                <input class="form-control" list="edit_DEP_SIMPLE" name="edit_DEP_SIMPLE" style="font-size:16px;"  value="{{$col->DEP_SIMPLE}}">
                        <datalist id="edit_DEP_SIMPLE">
                        @foreach($s_dep_simple as $s)
                            @if($s == $col->DEP_SIMPLE)
                                <option value="{{$s}}" selected>{{$s}}</option>
                            @else
                                <option value="{{$s}}">{{$s}}</option>
                            @endif
                        @endforeach
                        </datalist>
                    @else
                        {{$col->DEP_SIMPLE}}
                    @endif
                </td>
                <td>{{$col->SCH_SYS}}</td>
                <td align="center" style="color:{{$col->DEP_COLOR}}">
                    @if( $edit_id == $col->ID )
                        {{-- <input type="text" 
                               class="form-control"
                               name="edit_DEP_COLOR"
                               value="{{$col->DEP_COLOR}}"
                               style="color:{{$col->DEP_COLOR}}"
                        > --}}
                        <input type="color" class="form-control-lg form-control-color" name="edit_DEP_COLOR"id="edit_DEP_COLOR" value="{{$col->DEP_COLOR}}" title="選擇顏色">
                    @else
                        {{$col->DEP_COLOR}}
                    @endif
                </td>
                <td align="center" style="color:{{$col->COL_COLOR}}">
                    @if( $edit_id == $col->ID )
                       {{--  <input type="text"
                               class="form-control"
                               name="edit_COL_COLOR"
                               value="{{$col->COL_COLOR}}"
                               style="color:{{$col->COL_COLOR}}"
                        > --}}
                        <input type="color" class="form-control-lg form-control-color" name="edit_COL_COLOR"id="edit_COL_COLOR" value="{{$col->COL_COLOR}}" title="選擇顏色">
                    @else
                        {{$col->COL_COLOR}}
                    @endif
                </td>
{{--                 <td>
                    @if( $edit_id == $col->ID )
                        <input type="text"
                               class="form-control"
                               name="edit_COL_ICON"
                               value="{{$col->COL_ICON}}"
                        >
                    @else
                        {{$col->COL_ICON}}
                    @endif
                </td>
                <td>
                    @if( $edit_id == $col->ID )
                        <input type="text"
                               class="form-control"
                               name="edit_DEP_ICON"
                               value="{{$col->DEP_ICON}}"
                        >
                    @else
                        {{$col->DEP_ICON}}
                    @endif
                </td> --}}
                <td>
                    @if( $edit_id == $col->ID )
                       {{--  <select name="edit_ST_NUM" style="font-size:16px;"> --}}
                    <input class="form-control" list="edit_ST_NUM" name="edit_ST_NUM" style="font-size:16px;"  value="{{$col->ST_NUM}}">
                        <datalist id="edit_ST_NUM">
                        @foreach($s_st_num as $s)
                            @if($s == $col->ST_NUM)
                                <option value="{{$s}}" selected>{{$s}}</option>
                            @else
                                <option value="{{$s}}">{{$s}}</option>
                            @endif
                        @endforeach
                        </datalist>
                    @else
                        {{$col->ST_NUM}}
                    @endif
                </td>
                <td>
                    @if( $edit_id == $col->ID )
                       {{--  <select name="edit_SS_NUM" style="font-size:16px;"> --}}
                        <input class="form-control" list="edit_SS_NUM" name="edit_SS_NUM" style="font-size:16px;"  value="{{$col->SS_NUM}}">
                        <datalist id="edit_SS_NUM">
                        @foreach($s_ss_num as $s)
                            @if($s == $col->SS_NUM)
                                <option value="{{$s}}" selected>{{$s}}</option>
                            @else
                                <option value="{{$s}}">{{$s}}</option>
                            @endif
                        @endforeach
                        </datalist>
                    @else
                        {{$col->SS_NUM}}
                    @endif
                </td>
                <td>
                    @if( $edit_id == $col->ID )
                        {{-- <select name="edit_COL_NUM" style="font-size:16px;"> --}}
                    <input class="form-control" list="edit_COL_NUM" name="edit_COL_NUM" style="font-size:16px;"  value="{{$col->COL_NUM}}">
                    <datalist id="edit_COL_NUM">
                        @foreach($s_col_num as $s)
                            @if($s == $col->COL_NUM)
                                <option value="{{$s}}" selected>{{$s}}</option>
                            @else
                                <option value="{{$s}}">{{$s}}</option>
                            @endif
                        @endforeach
                        </datalist>
                    @else
                        {{$col->COL_NUM}}
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
