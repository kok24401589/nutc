<?php

namespace App\Imports;

use App\Model\DSP_System;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');
use Maatwebsite\Excel\Concerns\WithBatchInserts;
class Import_DSP_System implements ToModel,WithHeadingRow,WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DSP_System([
            //
          'AD_YEAR'=>$row['學年度'],
          'DEP_CODE'=>$row['系所代碼'],
          'DEP_NAME'=>$row['系所名稱'],
          'SCH_SYS'=>$row['學制班別'],
                   
        ]);
    }
    public function batchSize(): int
    {
        return 85;
    }
}
