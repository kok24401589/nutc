<?php

namespace App\Exports;

use App\Model\STU_DEP;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class Export_STU_DEP implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array
	{
		return['AD_YEAR',
          'PUB_OR_PRI',
          'SCH_CTG',
          'SCH_CODE',
          'SCH_NAME',
          'DEP_CODE',
          'DEP_NAME',
          'SCH_SYS',
          'STU_SUM',
          'STU_MALE',
          'STU_FEMALE'
		];
	}
    public function collection()
    {
        return collect(STU_DEP::Export());
    }
}
