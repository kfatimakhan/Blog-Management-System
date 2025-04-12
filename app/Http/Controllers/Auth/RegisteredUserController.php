<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        // Get validated data from the request
        $validated = $request->validated();

        // Create user with basic info
        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Handle profile picture upload if provided
        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')->store('profile-pictures', 'public');
            $user->update(['profile_pic' => $path]);
        }

        // Fire registered event (triggers email verification if enabled)
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        // Redirect to dashboard or intended page
        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Handle an incoming API registration request.
     */
    public function apiRegister(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')->store('profile-pictures', 'public');
            $user->update(['profile_pic' => $path]);
        }

        event(new Registered($user));

        return response()->json([
            'token' => $user->createToken('auth-token')->plainTextToken,
            'user' => $user
        ], 201);
    }
}
