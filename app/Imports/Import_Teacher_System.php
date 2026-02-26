<?php

namespace App\Imports;

use App\Model\Teacher_System;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');
use Maatwebsite\Excel\Concerns\WithBatchInserts;
class Import_Teacher_System implements ToModel,WithHeadingRow,WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Teacher_System([
            'AD_YEAR'=>$row['學年度'],
            'department_code'=>$row['單位代碼'],
            'department'=>$row['單位名稱']
        ]);
    }
               public function batchSize(): int
    {
        return 20;
    } 
}
