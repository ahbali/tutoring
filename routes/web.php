<?php

use App\Http\Middleware\EnsureUserHasRole;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware(EnsureUserHasRole::class.':tutor')->group(function () {
        Route::get('tutor/dashboard', function () {
            return Inertia::render('tutor/dashboard');
        })->name('tutor.dashboard');
    });

    Route::middleware(EnsureUserHasRole::class.':student')->group(function () {
        Route::get('student/dashboard', function () {
            return Inertia::render('student/dashboard');
        })->name('student.dashboard');
    });
});

require __DIR__.'/settings.php';
