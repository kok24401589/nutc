<?php

namespace App\Imports;

        
use App\Model\Department_GroupBaselines;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');
use Maatwebsite\Excel\Concerns\WithBatchInserts;
class Import_Department_GroupBaselines implements ToModel,WithHeadingRow,WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Department_GroupBaselines([
            //
            'year'=>$row['year'],
            'group_id'=>$row['group_id'],
            'group_name'=>$row['group_name'],
            'DEP_SIMPLE'=>$row['DEP_SIMPLE'],
            'admission_type'=>$row['admission_type']
            
             


        ]);
    }
               public function batchSize(): int
    {
        return 85;
    } 
}
