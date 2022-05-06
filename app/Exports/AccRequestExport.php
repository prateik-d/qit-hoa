<?php 
namespace App\Exports;
 
use App\Models\AccRequest;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
 
class AccRequestExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */ 
    public function headings():array{
        return[
            'Id',
            'title',
            'user_id',
            'improvement_details',
            'status',
            'created_at',
            'updated_at'
        ];
    } 
    public function collection()
    {
        return AccRequest::all();
    }
}