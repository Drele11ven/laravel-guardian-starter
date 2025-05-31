<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class GoogleAuthController extends Controller
{
    // Redirect user to Google authentication page
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google callback and user authentication
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Check if the user already exists
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Create a new user if not exists
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(uniqid()), // Generate a random password
            ]);
        }

        // Log in the user
        Auth::login($user);

        return redirect('/dashboard');
    }
}
