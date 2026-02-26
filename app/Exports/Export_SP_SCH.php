<?php

namespace App\Exports;

use App\Model\SP_SCH;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class Export_SP_SCH implements FromCollection,WithHeadings
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
                           'SCH_SYS',
                           'GENDER',
                           'STU_SUM',
                           'SP_ED_SUM',
                           'SP_ED_SICK',
                           'SP_ED_MONEY',
                           'SP_ED_SCORE',
                           'SP_ED_INTERESTS',
                           'SP_ED_WORK',
                           'SP_ED_PREGNANT',
                           'SP_ED_BABY',
                           'SP_ED_MILITARY',
                           'SP_ED_TRAVEL',
                           'SP_ED_PAPER',
                           'SP_ED_MALADAPTIVE',
                           'SP_ED_FAMILY',
                           'SP_ED_EXAM',
                           'SP_ED_REGISTERED',
                           'SP_ED_OTHER'
		];}
    public function collection()
    {
        return SP_SCH::all();
    }
}
