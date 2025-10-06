<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $weekStart = now();
        $weekEnd = now()->addDays(7);

        $weeklyExhibitions = Exhibition::where('start_date', '<=', $weekEnd)
            ->where('end_date', '>=', $weekStart)
            ->orderBy('start_date')
            ->take(6)
            ->get();

        $allExhibitionsCount = Exhibition::count();

        return view('home', compact('weeklyExhibitions', 'allExhibitionsCount'));
    }
}
