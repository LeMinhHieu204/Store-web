<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', ['users' => User::latest()->get()]);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->validate([
            'role' => ['required', 'in:user,admin'],
        ]));

        return back()->with('success', 'Đã cập nhật phân quyền.');
    }
}
