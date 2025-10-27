<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Возвращаем пользователей безданных
        $users = User::select('id', 'name', 'email', 'is_admin', 'created_at')
                    ->get();

        return response()->json([
            'success' => true,
            'data' => $users,
            'count' => $users->count()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::select('id', 'name', 'email', 'is_admin', 'created_at', 'updated_at')
                    ->with(['orders', 'exhibitions'])
                    ->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Пользователь не найден'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * Получить заказы пользователя
     */
    public function getUserOrders(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Пользователь не найден'
            ], 404);
        }

        $orders = $user->orders()->with(['ticketInstances.ticket'])->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Получить выставки пользователя
     */
    public function getUserExhibitions(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Пользователь не найден'
            ], 404);
        }

        $exhibitions = $user->exhibitions()->get();

        return response()->json([
            'success' => true,
            'data' => $exhibitions
        ]);
    }
}
