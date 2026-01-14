<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Language;
use App\Models\Speciality;
use App\Models\Tag;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Seeder;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Tutor User',
            'email' => 'tutor@example.com',
            'role' => 'tutor',
        ])->each(fn ($user) => $this->createTutorProfile($user, DatabaseSeeder::IMAGES[0]));

        User::factory(5)->create(['role' => 'tutor'])->each(function ($user, $index) {
            $this->createTutorProfile($user, DatabaseSeeder::IMAGES[$index % count(DatabaseSeeder::IMAGES)]);
        });
    }

    private function createTutorProfile(User $user, string $image): void
    {
        $user->update([
            'image' => $image,
        ]);

        $tutor = Tutor::factory()->create([
            'user_id' => $user->id,
            'country_id' => Country::query()->inRandomOrder()->value('id'),
        ]);

        $languages = Language::query()->inRandomOrder()->take(rand(1, 3))->pluck('id');
        $specialities = Speciality::query()->inRandomOrder()->take(rand(1, 3))->pluck('id');

        $tutor->languages()->sync($languages);
        $tutor->specialities()->sync($specialities);

        $tags = Tag::query()->whereIn('speciality_id', $specialities)->inRandomOrder()->take(rand(1, 5))->pluck('id');
        $tutor->tags()->sync($tags);
    }
}
