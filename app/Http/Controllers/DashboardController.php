<?php

namespace App\Http\Controllers;

use App\Models\Experimento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $ultimosExperimentos = auth()->user()
            ->experimentos()
            ->latest()
            ->take(5)
            ->get();

        $estadisticas = [
            'total_experimentos' => auth()->user()->experimentos()->count(),
            'experimentos_mruv' => auth()->user()->experimentos()->tipo('mruv')->count(),
            'experimentos_parabolico' => auth()->user()->experimentos()->tipo('parabolico')->count(),
        ];

        return view('dashboard', compact('ultimosExperimentos', 'estadisticas'));
    }
}