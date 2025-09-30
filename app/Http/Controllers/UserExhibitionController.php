<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserExhibitionController extends Controller
{
    public function show($id)
    {
        $user = User::with(['exhibitions' => function($query) {
            $query->orderBy('exhibition_user.visited_at', 'desc');
        }])->findOrFail($id);

        return view('users.exhibitions', compact('user'));
    }
}
