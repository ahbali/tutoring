<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Seeder;

const images = [
    'https://images.unsplash.com/photo-1615109398623-88346a601842?q=80&w=1287&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?q=80&w=1287&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1590086782957-93c06ef21604?q=80&w=1287&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1602233158242-3ba0ac4d2167?q=80&w=1336&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=1288&auto=format&fit=crop'
];

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
                'image' => images[array_rand(images)]
            ]
        );

        User::query()->firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student',
                'password' => 'password',
                'role' => 'student',
                'email_verified_at' => now(),
                'image' => images[array_rand(images)]
            ]
        );

        $this->call([
            LanguageSeeder::class,
            SpecialitySeeder::class,
            TagSeeder::class,
            CountrySeeder::class
        ]);

        Tutor::query()->create(['user_id' => 1, 'country_id' => 1]);
        Student::query()->create(['user_id' => 2]);


        User::factory(10)->create()->each(function ($user, $index) {
            $user->update([
                'image' => images[$index % count(images)]
            ]);

            Tutor::factory()->create([
                'user_id' => $user->id,
                'country_id' => Country::query()->inRandomOrder()->value('id')
            ]);
        });
    }
}
