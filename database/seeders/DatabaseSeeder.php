<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'tutor@example.com'],
            [
                'name' => 'Tutor',
                'password' => 'password',
                'role' => 'tutor',
                'email_verified_at' => now(),
            ]
        );

        User::query()->firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student',
                'password' => 'password',
                'role' => 'student',
                'email_verified_at' => now(),
            ]
        );

        Tutor::query()->create(['user_id' => 1]);
        Student::query()->create(['user_id' => 2]);

        $this->call([
            LanguageSeeder::class,
            SpecialitySeeder::class,
            TagSeeder::class,
            CountrySeeder::class
        ]);
    }
}
