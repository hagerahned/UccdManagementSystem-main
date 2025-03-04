<?php
namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $profile = Auth::user()->profile;
        return view('profile.show', compact('profile'));
    }

    public function edit()
    {
        $profile = Auth::user()->profile;
        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'bio' => 'nullable|string',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $profile = $user->profile;

        if ($request->hasFile('profile_picture')) {
            if ($profile->profile_picture) {
                Storage::delete($profile->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures');
            $profile->profile_picture = $path;
        }

        $profile->update($request->only(['bio', 'phone', 'address']));

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
}
