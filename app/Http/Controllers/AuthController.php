<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Invalid credentials'], 401);
        }

        Auth::login($user);
        $this->migrateCart($user->id);

        return response([
            'user' => $user,
            'token' => $user->createToken('myapptoken')->plainTextToken
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response(['message' => 'Logged out']);
    }

    public function user(Request $request)
    {
        return response(['user' => $request->user()]);
    }

    private function migrateCart($userId)
    {
        $sessionCartItems = CartItem::where('session_id', session()->getId())->get();

        foreach ($sessionCartItems as $cartItem) {
            $existingItem = CartItem::where('user_id', $userId)
                ->where('ticket_id', $cartItem->ticket_id)
                ->first();

            $existingItem
                ? $existingItem->increment('quantity', $cartItem->quantity) && $cartItem->delete()
                : $cartItem->update(['user_id' => $userId, 'session_id' => null]);
        }
    }
}
