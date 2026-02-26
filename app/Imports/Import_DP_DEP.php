<?php

namespace App\Imports;

use App\Model\DP_DEP;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

HeadingRowFormatter::default('none');

class Import_DP_DEP implements ToModel,WithBatchInserts,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DP_DEP([
              "AD_YEAR"=>$row['學年度'],
              "SMST"=>$row['學期'],
              "PUB_OR_PRI"=>$row['設立別'],
              "SCH_CTG"=>$row['學校類別'],
              "SCH_CODE"=>$row['學校統計處代碼'],
              "SCH_NAME"=>$row['學校名稱'],
              "DEP_CODE"=>$row['系所代碼'],
              "DEP_NAME"=>$row['系所名稱'],
              "SCH_SYS"=>$row['學制班別'],
              "GENDER"=>$row['性別'],
              "STU_SUM"=>$row['在學學生數'],
             'DP_SUM'=>$row['學期間退學人數-小計'],
            'DP_SCORE'=>$row['學期間退學人數-因成績不佳或曠課時數過多'],
            'DP_CONDUCT'=>$row['學期間退學人數-因操行成績'],
            'DP_INTERESTS'=>$row['學期間退學人數-因志趣不合'],
            'DP_OVEFDUE'=>$row['學期間退學人數-因逾期未註冊'],
            'DP_NORETURN'=>$row['學期間退學人數-因休學逾期未復學'],
            'DP_PREGNANT'=>$row['學期間退學人數-因懷孕'],
            'DP_BABY'=>$row['學期間退學人數-因育嬰'],
            'DP_SICK'=>$row['學期間退學人數-因傷病'],
            'DP_WORK'=>$row['學期間退學人數-因工作需求'],
            'DP_MONEY'=>$row['學期間退學人數-因經濟困難'],
            'DP_PLAN'=>$row['學期間退學人數-因生涯規劃'],
            'DP_OTHER'=>$row['學期間退學人數-其他(不含死亡)']
        ]);
    }
   public function batchSize(): int
    {
        return 85;
    } 

}
