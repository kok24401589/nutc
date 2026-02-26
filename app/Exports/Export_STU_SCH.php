<?php

namespace App\Exports;

use App\Model\STU_SCH;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class Export_STU_SCH implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array
	{
		return[    '學年度',
               '設立別',
               '學校類別',
               '學校統計處代碼',
               '學校名稱',
               '學制班別',
               '在學學生數小計',
               '在學學生男',
               '在學學生女'
		];
	}
    public function collection()
    {
        return collect(STU_SCH::Export());
    }
}
