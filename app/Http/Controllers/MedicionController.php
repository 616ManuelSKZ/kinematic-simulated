<?php

namespace App\Http\Controllers;

use App\Models\Medicion;
use App\Services\ErrorAnalisisService;
use Illuminate\Http\Request;

class MedicionController extends Controller
{
    protected $errorService;

    public function __construct(ErrorAnalisisService $errorService)
    {
        $this->errorService = $errorService;
    }

    public function index()
    {
        $mediciones = auth()->user()->mediciones()
            ->latest()
            ->paginate(10);

        return view('mediciones.index', compact('mediciones'));
    }

    public function create()
    {
        return view('mediciones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_magnitud' => 'required|in:tiempo,longitud,masa,velocidad,aceleracion,otra',
            'unidad' => 'required|string|max:50',
            'valores' => 'required|array|min:3',
            'valores.*' => 'required|numeric',
            'valor_verdadero' => 'nullable|numeric',
            'observaciones' => 'nullable|string'
        ]);

        // Realizar análisis automático
        $analisis = $this->errorService->analisisCompleto(
            $validated['valores'],
            $validated['valor_verdadero'] ?? null,
            $validated['unidad']
        );

        // Asociar la medición al usuario autenticado
        $validated['user_id'] = auth()->id();
        $validated['analisis_resultado'] = $analisis;

        $medicion = Medicion::create($validated);

        return redirect()->route('mediciones.show', $medicion)
            ->with('success', 'Medición creada y analizada exitosamente');
    }

    public function show(Medicion $medicione)
    {
        // Verificar que la medición pertenece al usuario
        if ($medicione->user_id !== auth()->id()) {
            return redirect()->route('mediciones.index')
                ->with('error', 'No tienes permiso para ver esta medición');
        }

        // Generar datos para gráficas
        $datosGrafica = $this->errorService->generarDatosGrafica($medicione->valores);

        return view('mediciones.show', compact('medicione', 'datosGrafica'));
    }

    public function analizar(Request $request)
    {
        $validated = $request->validate([
            'valores' => 'required|array|min:3',
            'valores.*' => 'required|numeric',
            'valor_verdadero' => 'nullable|numeric',
            'unidad' => 'required|string'
        ]);

        $analisis = $this->errorService->analisisCompleto(
            $validated['valores'],
            $validated['valor_verdadero'] ?? null,
            $validated['unidad']
        );

        $datosGrafica = $this->errorService->generarDatosGrafica($validated['valores']);

        return response()->json([
            'analisis' => $analisis,
            'grafica' => $datosGrafica
        ]);
    }

    public function propagarIncertidumbre(Request $request)
    {
        $validated = $request->validate([
            'operacion' => 'required|in:suma,resta,multiplicacion,division,potencia',
            'variables' => 'required|array|min:1',
            'variables.*.valor' => 'required|numeric',
            'variables.*.incertidumbre' => 'required|numeric|min:0',
            'variables.*.exponente' => 'nullable|numeric'
        ]);

        try {
            $resultado = $this->errorService->propagarIncertidumbre(
                $validated['operacion'],
                $validated['variables']
            );

            return response()->json(['resultado' => $resultado]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function exportar(Medicion $medicion)
    {
        // Verificar que la medición pertenece al usuario
        if ($medicion->user_id !== auth()->id()) {
            return redirect()->route('mediciones.index')
                ->with('error', 'No tienes permiso para exportar esta medición');
        }

        $csv = $this->errorService->exportarAnalisisCSV($medicion->analisis_resultado);

        $filename = "analisis_{$medicion->id}_{$medicion->nombre}.csv";
        
        return response()->streamDownload(function() use ($csv) {
            echo $csv;
        }, $filename, [
            'Content-Type' => 'text/csv'
        ]);
    }

    public function destroy(Medicion $medicione)
    {
        if ($medicione->user_id !== auth()->id()) {
            return redirect()->route('experimentos.index')
                ->with('error', 'No tienes permiso para eliminar esta medición');
        }

        $medicione->delete();

        return redirect()->route('experimentos.index')
            ->with('success', 'Medición eliminada exitosamente');
    }
}