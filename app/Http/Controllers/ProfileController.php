<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('auth.profile');
    }

    public function update(ProfileUpdateRequest $request, User $user)
    {
        // Task: fill in the code here to update name and email
        // Also, update the password if it is set
        $fieldsToUpdate = $request->except('password_confirmation');

        if (isset($fieldsToUpdate['password'])) {
            $fieldsToUpdate = array_merge($fieldsToUpdate, ['password' => Hash::make($fieldsToUpdate['password'])]);
        }

        $user::query()->update($fieldsToUpdate);

        return redirect()->route('profile.show')->with('success', 'Profile updated.');
    }
}
