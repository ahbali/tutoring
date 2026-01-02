<?php

use App\Models\Booking;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('confirmed is set to false right after booking', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Tutor::factory()->for(User::factory())->create();
    Student::factory()->for($user)->create();

    $this->post('/bookings', [
        'tutor_id' => 1,
        'start' => '2026-01-02T08:00:00Z',
        'end' => '2026-01-02T10:00:00Z',
    ]);

    $this->assertDatabaseHas('bookings', [
        'confirmed' => false
    ]);
});

it('student cannot book unavailable time slot', function () {
    $user = User::factory()->create(['role' => 'student']);
    $this->actingAs($user);

    Tutor::factory()->for(User::factory())->create();
    Student::factory()->for($user)->create();

    Booking::query()->create([
        'tutor_id' => 1,
        'student_id' => 1,
        'start' => '2026-01-01T00:00:00Z',
        'end' => '2026-01-01T02:00:00Z',
        'confirmed' => true
    ]);

    $this->post('/bookings', [
        'tutor_id' => 1,
        'start' => '2026-01-01T00:00:00Z',
        'end' => '2026-01-01T02:00:00Z',
    ]);

    $this->post('/bookings', [
        'tutor_id' => 1,
        'start' => '2026-01-01T00:30:00Z',
        'end' => '2026-01-01T01:30:00Z',
    ]);

    $this->assertDatabaseCount('bookings', 1);
});
