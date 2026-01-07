<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class InfoUserController extends Controller
{

    public function create()
    {
        return view('laravel-examples/user-profile');
    }

    public function store(Request $request)
    {

        $user = User::findOrFail(Auth::id());

        $attributes = $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'max:50'],
            'location' => ['nullable', 'max:70'],
            'about_me' => ['nullable', 'max:150'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if (env('IS_DEMO') && $user->id == 1 && ($attributes['email'] ?? null) !== $user->email) {
            return redirect()->back()
                ->withErrors(['msg2' => 'You are in a demo version, you can\'t change the email address.'])
                ->withInput();
        }

        $updateData = [
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'phone' => $attributes['phone'] ?? null,
            'location' => $attributes['location'] ?? null,
            'about_me' => $attributes['about_me'] ?? null,
        ];

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $updateData['profile_photo_path'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user->update($updateData);


        return redirect('/user-profile')->with('success','Profile updated successfully');
    }
}
