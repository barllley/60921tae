<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use Illuminate\Http\Request;

class ExhibitionControllerApi extends Controller
{
    /**
     * Display a listing of the resource with pagination
     */
    public function index(Request $request)
    {
        $perpage = $request->perpage ?? 5;
        $page = $request->page ?? 0;

        $exhibitions = Exhibition::with('tickets')
            ->limit($perpage)
            ->offset($perpage * $page)
            ->get();

        return response()->json($exhibitions);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Exhibition::with('tickets')->find($id));
    }

    /**
     * Get total count of exhibitions
     */
    public function total()
    {
        return response()->json([
            'total' => Exhibition::count()
        ]);
    }
}
