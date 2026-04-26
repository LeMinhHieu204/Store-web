<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DepositTransaction;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('orders.items.product');

        return view('user.profile.index', [
            'user' => $user,
            'latestDeposits' => DepositTransaction::where('user_id', $user->id)->latest()->take(5)->get(),
            'downloadableIds' => OrderItem::query()
                ->select('product_id')
                ->whereHas('order', fn ($query) => $query->where('user_id', $user->id)->where('status', 'completed'))
                ->pluck('product_id')
                ->all(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'confirmed', 'min:6'],
        ]);

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        if (! empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $user->update($payload);

        return back()->with('success', 'Da cap nhat thong tin tai khoan.');
    }
}
