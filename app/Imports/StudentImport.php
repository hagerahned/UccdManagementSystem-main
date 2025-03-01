<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithGroupedHeadingRow;

class StudentImport implements ToModel, WithGroupedHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name'     => $row['name'],
            'email'    => $row['email'],
            'password' => bcrypt('123456789'),
            'gender' => $row['gender'],
            'disability' => $row['disability'],
            'national_id' => $row['national_id'],
            'university_id' => $row['university_id'],
            'phone' => $row['phone'],
            'university' => $row['university'],
            'faculty' => $row['faculty'],
            'department' => $row['department'],
            'specialization' => $row['specialization'],
            'current_year' => $row['current_year'],
            'expected_graduation_year' => Carbon::parseFromLocale($row['expected_graduation_year']),
            'address' => $row['address'],
            'birth_date' => Carbon::parse($row['birth_date']),
        ]);
    }
}
