<?php

namespace App\Imports;

use App\Model\College_System;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
HeadingRowFormatter::default('none');
class Import_College_System implements ToModel,WithHeadingRow,WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new College_System([
            //
                           'AD_YEAR'=>$row['學年度'],
                           // 'SYSTEM_TYPE'=>$row['SYSTEM_TYPE'],
                           // 'College'=>$row['College'],
                           'DEP_CODE'=>$row['系所代碼'],
                           'DEP_NAME'=>$row['系所名稱'],
                           // 'DEP_SIMPLE'=>$row['DEP_SIMPLE'],
                           'SCH_SYS'=>$row['學制班別']
                           // 'DEP_COLOR'=>$row['DEP_COLOR'],
                           // 'COL_COLOR'=>$row['COL_COLOR'],
                           // 'COL_ICON'=>$row['COL_ICON'],
                           // 'DEP_ICON'=>$row['DEP_ICON'],
                           // 'ST_NUM'=>$row['ST_NUM'],
                           // 'SS_NUM'=>$row['SS_NUM'],
                           // 'COL_NUM'=>$row['COL_NUM']            
        ]);
    }
       public function batchSize(): int
    {
        return 85;
    } 
}
