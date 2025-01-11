<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\registerManage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(registerManage $request)
    {
        $request->merge(['password' => Hash::make($request->password)]);
        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => $request->password,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'created_at' =>  date('Y-m-d H:i:s')
        ];
        User::create($userData);
        return view('admin.user.index')->with('success', 'Thêm người dùng thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'created_at' =>  date('Y-m-d H:i:s')
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('admin.user.index')->with('success', 'Xóa người dùng thành công');
    }
}
