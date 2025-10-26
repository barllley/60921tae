<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use Illuminate\Http\Request;

class ExhibitionControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Exhibition::with('tickets')->get());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Exhibition::with('tickets')->find($id));
    }
}
