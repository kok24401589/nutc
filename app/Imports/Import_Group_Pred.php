<?php

namespace App\Imports;

        
use App\Model\Group_Pred;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');
use Maatwebsite\Excel\Concerns\WithBatchInserts;
class Import_Group_Pred implements ToModel,WithHeadingRow,WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Group_Pred([
            //
            'year'=>$row['year'],
            'group_id'=>$row['group_id'],
            'group_name'=>$row['group_name'],
            'predicted_count'=>$row['predicted_count'],
            'model_version'=>$row['model_version'],
            
             


        ]);
    }
               public function batchSize(): int
    {
        return 85;
    } 
}
