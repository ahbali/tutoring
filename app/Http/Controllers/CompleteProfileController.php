<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileCompleteUpdateRequest;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class CompleteProfileController extends Controller
{
    public function edit(User $user): Response
    {
        return Inertia::render('profile/complete');
    }

    public function update(ProfileCompleteUpdateRequest $request, User $user)
    {
        dd($request->all());
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
    }
}
