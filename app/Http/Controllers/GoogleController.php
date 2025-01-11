<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $nameParts = explode(' ', $user->name);
            $lastName = $nameParts[0];
            $firstName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';

            $findUser = User::where('google_id', $user->google_id)->Where('email', $user->email)->first();
            if ($findUser) {
                Auth::login($findUser);
                return redirect()->route('home')->with('success', 'Đăng nhập thành công với tài khoản Google!');
            } else {
                $newUser = User::create([
                    'email' => $user->email,
                    'name' => $user->name,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'google_id' => $user->id,
                    'role' => 'customer',
                    'password' => encrypt('123456789'),
                    'email_verified_at' => now(),
                ]);
                Auth::login($newUser);
                return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
            }
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Có lỗi xảy ra khi đăng nhập bằng Google: ' . $e->getMessage());
        }
    }
}
