<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $this->get(route('student.dashboard'))->assertRedirect(route('login'));
});

test('authenticated students can visit the dashboard', function () {
    $this->actingAs($user = User::factory()->create(['role' => 'student']));

    $this->get(route('student.dashboard'))->assertOk();
});

test('authenticated tutors can visit the dashboard', function () {
    $this->actingAs($user = User::factory()->create(['role' => 'tutor']));

    $this->get(route('tutor.dashboard'))->assertOk();
});
