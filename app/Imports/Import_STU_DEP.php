<?php

namespace App\Imports;

use App\Model\STU_DEP;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');
use Maatwebsite\Excel\Concerns\WithBatchInserts;
class Import_STU_DEP implements ToModel,WithHeadingRow,WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new STU_DEP([
            //
                           'AD_YEAR'=>$row['學年度'],
                           'PUB_OR_PRI'=>$row['設立別'],
                           'SCH_CTG'=>$row['學校類別'],
                           'SCH_CODE'=>$row['學校統計處代碼'],
                           'SCH_NAME'=>$row['學校名稱'],
                           'DEP_CODE'=>$row['系所代碼'],
                           'DEP_NAME'=>$row['系所名稱'],
                           'SCH_SYS'=>$row['學制班別'],
                           'STU_SUM'=>$row['在學學生數小計'],
                           'STU_MALE'=>$row['在學學生數男'],
                           'STU_FEMALE'=>$row['在學學生數女']
        ]);
    }
        public function batchSize(): int
    {
        return 85;
    }
}
