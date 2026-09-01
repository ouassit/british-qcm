<?php

namespace App\Exports;

use App\Models\StudentTest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Concerns\WithEvents;
use \Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Support\Facades\DB;



class StudentTestExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    public function headings(): array
    {
        return [
            'Code','Test','First Name', 'Last Name' ,'Birthday','Phone', 'Email', 'Date'
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Native query
        $users = DB::select('select access_code,tests.name, firstname, lastname, birthday, phone, email, date  from student_tests join tests on tests.id=test_id where user_id=?', [auth()->user()->id]);

        // Convert array of stdClass to collection
        return collect($users);
    }
    
}
