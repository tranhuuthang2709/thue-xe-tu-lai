<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class registerLessorController extends Controller
{
    public function showFormRegisterLessor()
    {
        return view('user.register_lessor');
    }

    public function registerAsLessor(Request $request)
    {
        if (!$request->has('terms')) {
            return redirect()->back()->withErrors('Vui lòng đồng ý với điều khoản và điều kiện.');
        }
        $user = Auth::user();
        $user->role = 'lessor';
        $user->save();

        return redirect()->route('home')->with('success', 'Bạn đã đăng ký thành người cho thuê thành công!');
    }
}
