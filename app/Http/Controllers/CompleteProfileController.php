<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CompleteProfileController extends Controller
{
    public function edit(User $user): Response
    {
        return Inertia::render('profile/complete');
    }

    public function update(Request $request, User $user)
    {
        //
    }
}
