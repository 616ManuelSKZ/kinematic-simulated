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
        $user = auth()->user();

        // Obtener los últimos experimentos
        $experimentos = $user->experimentos()
            ->select('id', 'nombre', 'tipo', 'created_at')
            ->latest()
            ->get();

        // Obtener las mediciones guardadas
        $mediciones = $user->mediciones()
            ->select('id', 'nombre', 'tipo_magnitud as tipo', 'created_at')
            ->latest()
            ->get();

        // Combinar todos los simuladores
        $historial = collect();

        foreach ($experimentos as $exp) {
            $historial->push([
                'id' => $exp->id,
                'nombre' => $exp->nombre,
                'tipo' => strtoupper($exp->tipo),
                'fecha' => $exp->created_at,
                'ruta' => route('experimentos.show', $exp),
                'color' => match ($exp->tipo) {
                    'mru' => 'bg-cyan-100 text-cyan-800',
                    'mruv' => 'bg-blue-100 text-blue-800',
                    'parabolico' => 'bg-green-100 text-green-800',
                    default => 'bg-gray-100 text-gray-700',
                },
            ]);
        }

        foreach ($mediciones as $med) {
            $historial->push([
                'id' => $med->id,
                'nombre' => $med->nombre,
                'tipo' => 'MEDICIÓN',
                'fecha' => $med->created_at,
                'ruta' => route('mediciones.show', $med),
                'color' => 'bg-orange-100 text-orange-800',
            ]);
        }

        // Si tienes Arduino, puedes agregarlo así:
        /*
        foreach ($user->arduinoExperimentos as $ard) {
            $historial->push([
                'id' => $ard->id,
                'nombre' => $ard->nombre,
                'tipo' => 'ARDUINO',
                'fecha' => $ard->created_at,
                'ruta' => route('arduino.show', $ard),
                'color' => 'bg-teal-100 text-teal-800',
            ]);
        }
        */

        // Ordenar por fecha descendente
        $historial = $historial->sortByDesc('fecha')->take(10);

        // Estadísticas generales
        $estadisticas = [
            'total_experimentos' => $user->experimentos()->count(),
            'total_mediciones' => $user->mediciones()->count(),
            'experimentos_mruv' => $user->experimentos()->tipo('mruv')->count(),
            'experimentos_parabolico' => $user->experimentos()->tipo('parabolico')->count(),
        ];

        return view('dashboard', compact('historial', 'estadisticas'));
    }
}