<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->count(20)->create([
            'name' => fake()->name(),
            'email' => fake()->unique()->email(),
            'password' => bcrypt('123456789'),
            'gender' => 'male',
            'disability' => 'no',
            'national_id' => fake()->numberBetween(10000000000,99999999999),
            'university_id' => fake()->numberBetween(100000000,999999999),
            'phone' => fake()->phoneNumber(),
            'university' => 'korean university',
            'faculty' => 'korean university',
            'department' => "it",
            'specialization' => "it,software",
            'current_year' => 'fourth',
            'expected_graduation_year' => fake()->date(),
            'address' => fake()->address(),
            'birth_date' => fake()->date(),

            
        ]);
    }
}
