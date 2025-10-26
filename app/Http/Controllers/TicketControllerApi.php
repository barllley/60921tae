<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Ticket::with('exhibition')->get());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Ticket::with('exhibition')->find($id));
    }
}
