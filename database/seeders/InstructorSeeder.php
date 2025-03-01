<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Manager::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => bcrypt('password'),
        ]);
    }
}
