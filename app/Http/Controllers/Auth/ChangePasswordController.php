<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Add this import


class ChangePasswordController extends Controller
{
    public function edit()
    {

        return view('auth.passwords.profileEdit');
    }

    public function password()
    {

        return view('auth.passwords.changePassword');
    }

public function updateProfile(UpdateProfileRequest $request)
{
    // dd('in');
    $user = auth()->user();
    $data = $request->validated();
// dd($data);
    // Handle profile image upload
    if ($request->hasFile('profile_image')) {
        // Delete old image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        // Store new image
        // $image = $request->file('profile_image');
        // $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
        // $imagePath = $image->storeAs('profile_images', $imageName, 'public');
        // $data['profile_image'] = $imagePath;
        $image = $request->file('profile_image');
        $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('profile_images'), $imageName);
        $data['profile_image'] = 'profile_images/' . $imageName;
// dd('in');
    }

    // Update user data
    $user->update(array_filter($data, function($value) {
        return !is_null($value);
    }));

    // Update password if provided
    if ($request->filled('password')) {
        $user->update([
            'password' => Hash::make($request->password),
        ]);
    }

    return redirect()->route('profile.password.edit')->with('success', __('global.update_profile_success'));
}
    public function destroy()
    {
        $user = auth()->user();

        $user->update([
            'email' => time() . '_' . $user->email,
        ]);

        $user->delete();

        return redirect()->route('login')->with('message', __('global.delete_account_success'));
    }
}