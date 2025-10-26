<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Order::with(['user', 'ticketInstances.ticket'])->get());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Order::with(['user', 'ticketInstances.ticket'])->find($id));
    }
}
