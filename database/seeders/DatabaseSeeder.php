<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public const IMAGES = [
        'https://images.unsplash.com/photo-1615109398623-88346a601842?q=80&w=1287&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?q=80&w=1287&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1590086782957-93c06ef21604?q=80&w=1287&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1602233158242-3ba0ac4d2167?q=80&w=1336&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=1288&auto=format&fit=crop',
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            SpecialitySeeder::class,
            TagSeeder::class,
            CountrySeeder::class,
            TutorSeeder::class,
            StudentSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
