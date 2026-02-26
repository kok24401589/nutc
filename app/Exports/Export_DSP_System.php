<?php

namespace App\Exports;

use App\Model\DSP_System;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class Export_DSP_System implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array
	{
		return[ '學年度',
            '系所代碼',
            '系所名稱',
            '學制班別',
		];
	}    
    public function collection()
    {
        return collect(DSP_System::Export());
    }
}
