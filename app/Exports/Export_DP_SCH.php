<?php

namespace App\Exports;

use App\Model\DP_SCH;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Export_DP_SCH implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

   public function headings():array
	{
		return[
			 '學年度',
             '學期',
             '設立別',
             '學校類別',
             '學校統計處代碼',
             '學校名稱',
             '學制班別',
             '性別',
             '在學學生數',
             '學期內退學人數小計',
             '因學業成績學期內退學人數',
             '因操行成績學期內退學人數',
             '因志趣不合學期內退學人數',
             '因逾期未註冊學期內退學人數',
             '因休學逾期未復學學期內退學人數',
             '因懷孕學期內退學人數',
             '因育嬰學期內退學人數',
             '因病學期內退學人數',
             '因工作需求學期內退學人數',
             '因經濟困難',
             '因生涯規劃',
             '其他(不含死亡)學期內退學人數'
		];
	}

    public function collection()
    {
       return collect(DP_SCH::Export());
    }
}
