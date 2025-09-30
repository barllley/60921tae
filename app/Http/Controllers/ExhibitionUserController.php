<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use Illuminate\Http\Request;

class ExhibitionUserController extends Controller
{
    public function show($id)
    {
        $exhibition = Exhibition::with(['users' => function($query) {
            $query->orderBy('exhibition_user.visited_at', 'desc');
        }])->findOrFail($id);

        return view('exhibitions.users', compact('exhibition'));
    }
}
