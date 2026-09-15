<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($request->hasFile('profile_picture')) 
        {

            $image = $request->file('profile_picture');

            $base64 = base64_encode(
                file_get_contents($image->getRealPath())
            );

            $user->update([
                'profile_picture' => $base64,
                'profile_picture_type' => $image->getMimeType(),
            ]);
        }

        return redirect()->back()->with(
            'success',
            'Profile updated successfully.'
        );
    }
}
