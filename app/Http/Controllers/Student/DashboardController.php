<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index() {
        $tutors = Tutor::with(['user', 'country'])->get();

        return Inertia::render('student/dashboard', [
            'tutors' => $tutors,
        ]);
    }
}
