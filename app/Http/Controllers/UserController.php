<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\Forgot_passwordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\Reset_passwordRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\verifyUser;
use App\Mail\Forgotpassword;
use App\Models\PasswordResetToken;

class UserController extends Controller
{
    public function Login()
    {
        return view('login');
    }
    public function check_login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::user()->email_verified_at != null) {
                return redirect()->route('home');
            } else {
                return redirect()->back()->with('error', 'Vui lòng xác nhận Email trước khi đăng nhập');
            }
        } else {
            return redirect()->back()->with('error', 'Tài khoản hoặc mật khẩu không đúng');
        }
    }

    public function register()
    {
        return view('register');
    }
    public function check_register(RegisterRequest $request)
    {
        $request->merge(['password' => Hash::make($request->password)]);
        $request->merge(['confirm_password' => Hash::make($request->confirm_password)]);
        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
            'phone_number' => $request->phone_number,
            'role' => 'customer',
            'created_at' =>  date('Y-m-d H:i:s')
        ];
        try {
            $acc = User::create($userData);
            Mail::to($acc->email)->send(new verifyUser($acc));
            return redirect()->route('login')->with('success', 'Đã đăng kí thành công. Vui lòng kiểm tra Email để xác thực');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Đăng ký thất bại' . $th->getMessage());
        }
    }
    public function verify($email)
    {
        $acc = User::where('email', $email)->whereNull('email_verified_at')->firstOrFail();
        // Kiểm tra xem liên kết xác thực có hết hạn không
        if (now()->diffInMinutes($acc->created_at) > config('auth.verification.expire')) {
            $acc->delete();
            return redirect()->route('login')->with('error', 'Liên kết xác thực đã hết hạn vui lòng thử đăng kí lại ');
        } else {
            User::where('email', $email)->update(['email_verified_at' => date('Y-m-d H:i:s')]);
            return redirect()->route('login')->with('success', 'Xác nhận email thành công vui lòng đăng nhập');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
    public function change_password()
    {
        return view('change_password');
    }
    public function check_change_password(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        User::where('id', $user->id)->update(['password' => $user->password]);
        return redirect()->route('home')->with('success', 'Mật khẩu của bạn đã được thay đổi thành công.');
    }
    public function forgot_password()
    {
        return view('forgot_password');
    }
    public function check_forgot_password(Forgot_passwordRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $token = Str::random(50);
        $created_at = now()->addMinutes(config('auth.verification.expire'));

        $data = [
            'email' => $request->email,
            'token' => $token,
            'created_at' => $created_at,
        ];
        if (PasswordResetToken::create($data)) {
            Mail::to($request->email)->send(new Forgotpassword($user, $token));
            return redirect()->route('login')->with('success', 'Vui lòng kiểm tra Email để xác thực ');
        }
    }
    public function reset_password($token)
    {
        $data_token = PasswordResetToken::where('token', $token)->firstOrFail();
        if (now()->diffInMinutes($data_token->created_at) > config('auth.verification.expire')) {
            return redirect()->route('login')->with('error', 'Liên kết đặt lại mật khẩu đã hết hạn,vui lòng thử lại.');
        } else {
            $user = User::where('email', $data_token->email)->firstOrFail();
            return view('reset_password', compact('user'));
        }
    }
    public function check_reset_password(Reset_passwordRequest $request, $token)
    {
        $data_token = PasswordResetToken::where('token', $token)->firstOrFail();
        $user = User::where('email', $data_token->email)->firstOrFail();
        User::where('id', $user->id)->update(['password' => Hash::make($request->new_password), 'email_verified_at' => date('Y-m-d H:i:s')]);
        return redirect()->route('login')->with('success', 'Bạn đã lấy lại mật khẩu thành công xin mời đăng nhập');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }
    public function update(UpdateUserRequest $request)
    {
        $user = Auth::user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->save();
        return redirect()->route('home');
    }
}
