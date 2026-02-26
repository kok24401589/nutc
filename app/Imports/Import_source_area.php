<?php

namespace App\Imports;

use App\Model\source_area;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');
use Maatwebsite\Excel\Concerns\WithBatchInserts;
class Import_source_area implements ToModel,WithBatchInserts,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new source_area([
            '學制'=>$row['學制'],
            '科系'=>$row['科系'],
            '入學前學校所在城市'=>$row['入學前學校所在城市'],
            '入學前學歷'=>$row['入學前學歷'],
            '入學前學校'=>$row['入學前學校'],
            '入學前學校科組'=>$row['入學前學校科組'],
            '入學方式'=>$row['入學方式'],
            '入學學年期'=>$row['入學學年期']

        
        ]);
    }
      public function batchSize(): int
    {
        return 85;
    }
}
