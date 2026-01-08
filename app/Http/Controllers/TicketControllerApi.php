<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketControllerApi extends Controller
{
    /**
     * Display a listing of the resource with pagination
     */
    public function index(Request $request)
    {
        $perpage = $request->perpage ?? 5;
        $page = $request->page ?? 0;

        $tickets = Ticket::with('exhibition')
            ->limit($perpage)
            ->offset($perpage * $page)
            ->get();

        return response()->json($tickets);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Ticket::with('exhibition')->find($id));
    }

    /**
     * Get total count of tickets
     */
    public function total()
    {
        return response()->json([
            'total' => Ticket::count()
        ]);
    }
}
