<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)
            ->withCount(['posts', 'followers', 'following'])
            ->firstOrFail();

        $posts = $user->posts()
            ->where('visibility', 'public')
            ->latest()
            ->paginate(10);

        return Inertia::render('Profile/Show', [
            'user' => $user,
            'posts' => $posts,
            'isFollowing' => Auth::user() ? Auth::user()->isFollowing($user) : false
        ]);
    }

    public function edit()
    {
        return Inertia::render('Profile/Edit');
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = Auth::user();
        $user->update($request->validated());

        if ($request->hasFile('profile_pic')) {
            if ($user->profile_pic) {
                Storage::disk('public')->delete($user->profile_pic);
            }
            $user->update([
                'profile_pic' => $request->file('profile_pic')->store('profile-pictures', 'public')
            ]);
        }

        return redirect()->route('profile.show', $user->username);
    }
}
