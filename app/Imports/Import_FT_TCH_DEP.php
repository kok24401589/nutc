<?php

namespace App\Imports;

use App\Model\FT_TCH_DEP;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');
use Maatwebsite\Excel\Concerns\WithBatchInserts;
class Import_FT_TCH_DEP implements ToModel,WithHeadingRow,WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new FT_TCH_DEP([
            //
             'AD_YEAR'=>$row['學年度'],
             'PUB_OR_PRI'=>$row['設立別'],
             'SCH_CTG'=>$row['學校類別'],
             'SCH_CODE'=>$row['學校統計處代碼'],
             'SCH_NAME'=>$row['學校名稱'],
             'UNIT_CODE'=>$row['單位代碼'],
             'DEP_NAME'=>$row['單位名稱'],
             'TCH_SUM'=>$row['專任教師數-教師總數總計'],
             'TCH_MALE'=>$row['專任教師數-教師總數男'],
             'TCH_FEMALE'=>$row['專任教師數-教師總數女'],
             'PFS_MALE'=>$row['專任教師數-教授男'],
             'PFS_FEMALE'=>$row['專任教師數-教授女'],
             'ASCPFS_MALE'=>$row['專任教師數-副教授男'],
             'ASCPFS_FEMALE'=>$row['專任教師數-副教授女'],
             'ASTPFS_MALE'=>$row['專任教師數-助理教授男'],
             'ASTPFS_FEMALE'=>$row['專任教師數-助理教授女'],
             'LT_MALE'=>$row['專任教師數-講師男'],
             'LT_FEMALE'=>$row['專任教師數-講師女'],
             'OT_TCH_MALE'=>$row['專任教師數-其他教師男'],
             'OT_TCH_FEMALE'=>$row['專任教師數-其他教師女'],
             'FT_ASTPFS_UP'=>$row['專任助理教授以上人數-總計'],
             'FT_ASTPFS_UP_MALE'=>$row['專任助理教授以上人數-男'],
             'FT_ASTPFS_UP_FEMALE'=>$row['專任助理教授以上人數-女'],
             'FT_LT_UP'=>$row['專任講師以上人數-總計'],
             'FT_LT_UP_MALE'=>$row['專任講師以上人數-男'],
             'FT_LT_UP_FEMALE'=>$row['專任講師以上人數-女']
        ]);
    }
        public function batchSize(): int
    {
        return 75;
    }
}
