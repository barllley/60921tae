<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use Illuminate\Http\Request;

class ExhibitionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 5); // По умолчанию 5 элементов

        $exhibitions = Exhibition::with('tickets')
                                 ->paginate($perPage)
                                 ->withQueryString();

        return view('exhibitions.index', compact('exhibitions'));
    }

    public function show($id)
    {
        $exhibition = Exhibition::with('tickets')->findOrFail($id);
        return view('exhibitions.show', compact('exhibition'));
    }
}
