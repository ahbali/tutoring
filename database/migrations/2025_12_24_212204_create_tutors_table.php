<?php

use App\Models\Country;
use App\Models\Tutor;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tutors', function (Blueprint $table) {
            $table->id();
            $table->text('bio')->nullable();
            $table->foreignIdFor(Country::class)->nullable()->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->timestamps();
        });

        User::factory()->create([
            'name' => 'Tutor User',
            'email' => 'tutor@example.com',
            'role' => 'tutor',
            'image' => DatabaseSeeder::IMAGES[0],
        ])->each(function ($user) {
            Tutor::factory()->create([
                'user_id' => $user->id,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutors');
    }
};
