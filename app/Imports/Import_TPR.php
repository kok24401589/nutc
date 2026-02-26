<?php

namespace App\Imports;

use App\Model\TPR;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');
use Maatwebsite\Excel\Concerns\WithBatchInserts;
class Import_TPR implements ToModel,WithHeadingRow,WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new TPR([
            //
            '學年度'=>$row['學年度'],
            '設立別'=>$row['設立別'],
            '學校類別'=>$row['學校類別'],
            '學校統計處代碼'=>$row['學校統計處代碼'],
            '學校名稱'=>$row['學校名稱'],
            '日間學制學生數'=>$row['日間學制學生數'],
            '日間專任教師'=>$row['日間專任教師(含助教)'],
            '日間生師比'=>$row['日間生師比(%)']

        ]);
    }
           public function batchSize(): int
    {
        return 85;
    } 
}
