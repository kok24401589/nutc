<?php

namespace App\Imports;

use App\Model\EnrollmentAnalysis;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');
use Maatwebsite\Excel\Concerns\WithBatchInserts;
class Import_EnrollmentAnalysis implements ToModel,WithHeadingRow,WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new EnrollmentAnalysis([
            //
            '學制'=>$row['學制'],
            '科系'=>$row['科系'],
            '年級'=>$row['年級'],
            '目前班級'=>$row['目前班級'],
            '入學前學校所在城市'=>$row['入學前學校所在城市'],
            '入學前學歷'=>$row['入學前學歷'],
            '入學前學校'=>$row['入學前學校'],
            '入學前學校科組'=>$row['入學前學校科組'],
            '入學方式'=>$row['入學方式'],
            '在學狀態'=>$row['在學狀態'],
            '入學日期'=>$row['入學日期'],
            '入學學年期'=>$row['入學學年期'],
            '入學其他分類'=>$row['入學管道']

        ]);
    }
               public function batchSize(): int
    {
        return 85;
    } 
}
