<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CompleteProfileController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Middleware\EnsureUserHasRole;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'tutor' => redirect()->route('tutor.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            default => redirect()->route('login'),
        };
    }

    return redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware(EnsureUserHasRole::class.':tutor')->group(function () {
        Route::get('tutor/dashboard', [\App\Http\Controllers\Tutor\DashboardController::class, 'index'])->name('tutor.dashboard');

        Route::get('tutor/bookings', [\App\Http\Controllers\Tutor\BookingController::class, 'index'])->name('tutor.bookings.index');
        Route::patch('tutor/bookings/{booking}', [\App\Http\Controllers\Tutor\BookingController::class, 'update'])->name('tutor.bookings.update');
    });

    Route::middleware(EnsureUserHasRole::class.':student')->group(function () {
        Route::post('bookings', [BookingController::class, 'store'])->name('booking.store');
        Route::get('bookings/{tutor}', [BookingController::class, 'index'])->name('booking.index');
    });

    Route::get('profile/complete', [CompleteProfileController::class, 'edit'])->name('profile.complete.edit');
    Route::put('profile/complete', [CompleteProfileController::class, 'update'])->name('profile.complete.update');

    Route::middleware(EnsureUserHasRole::class.':student')->group(function () {
        Route::get('student/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');
    });
});

require __DIR__.'/settings.php';
