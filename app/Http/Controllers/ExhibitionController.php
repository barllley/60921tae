<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use Illuminate\Http\Request;

class ExhibitionController extends Controller
{
    public function index()
    {
        $exhibitions = Exhibition::with('tickets')->get();
        return view('exhibitions.index', compact('exhibitions'));
    }

    public function show($id)
    {
        $exhibition = Exhibition::with('tickets')->findOrFail($id);
        return view('exhibitions.show', compact('exhibition'));
    }
}
