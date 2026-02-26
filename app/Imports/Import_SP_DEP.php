<?php

namespace App\Imports;

use App\Model\SP_DEP;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');
use Maatwebsite\Excel\Concerns\WithBatchInserts;
class Import_SP_DEP implements ToModel,WithHeadingRow,WithBatchInserts

{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SP_DEP([
            //
                           'AD_YEAR'=>$row['學年度'],
                           'PUB_OR_PRI'=>$row['設立別'],
                           'SCH_CTG'=>$row['學校類別'],
                           'SCH_CODE'=>$row['學校統計處代碼'],
                           'SCH_NAME'=>$row['學校名稱'],
                           'DEP_CODE'=>$row['系所代碼'],
                           'DEP_NAME'=>$row['系所名稱'],
                           'SCH_SYS'=>$row['學制班別'],
                           'GENDER'=>$row['性別'],
                           'STU_SUM'=>$row['在學學生數'],
                           'SP_ED_SUM'=>$row['於學年底處於休學狀態之人數-總計'],
                           'SP_ED_SICK'=>$row['於學年底處於休學狀態之人數-因傷病'],
                           'SP_ED_MONEY'=>$row['於學年底處於休學狀態之人數-因經濟困難'],
                           'SP_ED_SCORE'=>$row['於學年底處於休學狀態之人數-因學業成績不佳'],
                           'SP_ED_INTERESTS'=>$row['於學年底處於休學狀態之人數-因志趣不合'],
                           'SP_ED_WORK'=>$row['於學年底處於休學狀態之人數-因工作需求'],
                           'SP_ED_PREGNANT'=>$row['於學年底處於休學狀態之人數-因懷孕'],
                           'SP_ED_BABY'=>$row['於學年底處於休學狀態之人數-因育嬰'],
                           'SP_ED_MILITARY'=>$row['於學年底處於休學狀態之人數-因兵役'],
                           'SP_ED_TRAVEL'=>$row['於學年底處於休學狀態之人數-因出國'],
                           'SP_ED_PAPER'=>$row['於學年底處於休學狀態之人數-因論文撰寫'],
                           'SP_ED_MALADAPTIVE'=>$row['於學年底處於休學狀態之人數-因適應不良'],
                           'SP_ED_FAMILY'=>$row['於學年底處於休學狀態之人數-因家人傷病'],
                           'SP_ED_EXAM'=>$row['於學年底處於休學狀態之人數-因考試訓練'],
                           'SP_ED_REGISTERED'=>$row['於學年底處於休學狀態之人數-因逾期未註冊、繳費、選課'],
                           'SP_ED_OTHER'=>$row['於學年底處於休學狀態之人數-其他']
        ]);
    }
    public function batchSize(): int
    {
        return 75;
    }
}
