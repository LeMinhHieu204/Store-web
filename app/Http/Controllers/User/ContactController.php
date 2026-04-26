<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create()
    {
        return view('user.contact.index');
    }

    public function store(Request $request)
    {
        Contact::create($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'message' => ['required', 'string'],
        ]));

        return back()->with('success', 'Tin nhắn của bạn đã được gửi tới quản trị viên.');
    }
}
