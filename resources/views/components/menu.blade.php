<nav id='menu'>
    <ul>
        <li><a href='{{ url("index") }}'>回首頁</a></li>
        
        <li><span>學生類</span>
            <ul>
                <li><span>學生人數分析</span>
                    <ul>
                        @if(isset($menuLinks['link_student']) && $menuLinks['link_student'])
                            @for($i = 0; $i < $menuLinks['link_student'] - 105 && $i < 5; $i++)
                                @php $year = (int)$menuLinks['link_student'] - $i; @endphp
                                <li><a href='{{ url("student/?year=" . $year) }}'>學生人數分析{{ $year }}</a></li>
                            @endfor
                        @endif
                    </ul>
                </li>
                
                <li><span>休學人數分析</span>
                    <ul>
                        @if(isset($menuLinks['link_s_suspension']) && $menuLinks['link_s_suspension'])
                            @for($i = 0; $i < $menuLinks['link_s_suspension'] - 105 && $i < 5; $i++)
                                @php $year = (int)$menuLinks['link_s_suspension'] - $i; @endphp
                                <li><a href='{{ url("s_suspension/?year=" . $year) }}'>休學人數分析{{ $year }}</a></li>
                            @endfor
                        @endif
                    </ul>
                </li>
                
                <li><span>退學人數分析</span>
                    <ul>
                        @if(isset($menuLinks['link_s_dropout']) && $menuLinks['link_s_dropout'])
                            @for($i = 0; $i < $menuLinks['link_s_dropout'] - 105 && $i < 5; $i++)
                                @php $year = (int)$menuLinks['link_s_dropout'] - $i; @endphp
                                <li><a href='{{ url("s_dropout/?year=" . $year) }}'>退學人數分析{{ $year }}</a></li>
                            @endfor
                        @endif
                    </ul>
                </li>
            </ul>
        </li>
        
        <li><span>教師類</span>
            <ul>
                <li><span>教師人數分析</span>
                    <ul>
                        @if(isset($menuLinks['link_teacher']) && $menuLinks['link_teacher'])
                            @for($i = 0; $i < $menuLinks['link_teacher'] - 105 && $i < 5; $i++)
                                @php $year = (int)$menuLinks['link_teacher'] - $i; @endphp
                                <li><a href='{{ url("teacher/?year=" . $year) }}'>教師人數分析{{ $year }}</a></li>
                            @endfor
                        @endif
                    </ul>
                </li>
                
                <li><span>生師比率分析</span>
                    <ul>
                        @if(isset($menuLinks['link_tpr']) && $menuLinks['link_tpr'])
                            @for($i = 0; $i < 5; $i++)
                                @php $year = (int)$menuLinks['link_tpr'] - $i; @endphp
                                <li><a href='{{ url("tpr/?year=" . $year) }}'>生師比率分析{{ $year }}</a></li>
                            @endfor
                        @endif
                    </ul>
                </li>
                
                <li><span>教師授課時數</span>
                    <ul>
                        @if(isset($menuLinks['link_teacherHour']) && $menuLinks['link_teacherHour'])
                            @for($i = 0; $i < $menuLinks['link_teacherHour'] - 105 && $i < 5; $i++)
                                @php $year = (int)$menuLinks['link_teacherHour'] - $i; @endphp
                                <li><a href='{{ url("TeachHour/?year=" . $year) }}'>教師授課時數{{ $year }}</a></li>
                            @endfor
                        @endif
                    </ul>
                </li>
            </ul>
        </li>
        
        <li><span>招生類</span>
            <ul>
                <li><a href='{{ url("../fivetotwo/fivetotwo.php") }}'>五專升二技分析</a></li>
                
                <li><span>入學管道分析</span>
                    <ul>
                        @if(isset($menuLinks['link_EnrollmentAnalysis']) && $menuLinks['link_EnrollmentAnalysis'])
                            @for($i = 0; $i < $menuLinks['link_EnrollmentAnalysis'] - 105 && $i < 3; $i++)
                                @php $year = (int)$menuLinks['link_EnrollmentAnalysis'] - $i; @endphp
                                <li><a href='{{ url("EnrollmentAnalysis?value=資訊工程系&year=" . $year) }}'>入學管道分析{{ $year }}</a></li>
                            @endfor
                        @endif
                    </ul>
                </li>
                
                <li><span>學生來源地區分析</span>
                    <ul>
                        @if(isset($menuLinks['link_treemap']) && $menuLinks['link_treemap'])
                            @for($i = 0; $i <= $menuLinks['link_treemap'] - 109 && $i < 3; $i++)
                                @php $year = (int)$menuLinks['link_treemap'] - $i; @endphp
                                <li><a href='{{ url("treemap/?year=" . $year) }}'>學生來源地區{{ $year }}</a></li>
                            @endfor
                        @endif
                    </ul>
                </li>
            </ul>
        </li>
        
        <li><a href='{{ url("Link_teacher") }}'>其他教育資料庫</a></li>
    </ul>
</nav>
