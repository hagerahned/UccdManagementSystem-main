<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class StudentExport implements FromCollection,WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::select(
            'name',
            'email',
            'gender',
            'disability',
            'national_id',
            'university_id',
            'phone',
            'university',
            'faculty',
            'department',
            'specialization',
            'current_year',
            'expected_graduation_year',
            'address',
            'birth_date',
        )->get();
    }

    public function headings(): array
    {
        return [
            'name',
            'email',
            'gender',
            'disability',
            'national_id',
            'university_id',
            'phone',
            'university',
            'faculty',
            'department',
            'specialization',
            'current_year',
            'expected_graduation_year',
            'address',
            'birth_date',
        ];
    }
}
