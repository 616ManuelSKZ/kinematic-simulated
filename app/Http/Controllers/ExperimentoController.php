<?php

namespace App\Http\Controllers;

use App\Models\Experimento;
use App\Services\CinematicaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExperimentoController extends Controller
{
    protected $cinematicaService;

    public function __construct(CinematicaService $cinematicaService)
    {
        $this->cinematicaService = $cinematicaService;
    }

    public function index(Request $request)
    {
        // Capturar filtros
        $buscar = $request->input('buscar');
        $tipo = $request->input('tipo');

        // Query base de experimentos
        $queryExperimentos = auth()->user()->experimentos()->latest();

        // Filtro por nombre
        if ($buscar) {
            $queryExperimentos->where('nombre', 'like', '%' . $buscar . '%');
        }

        // Filtro por tipo (solo MRU, MRUV o Parabólico)
        if ($tipo && in_array($tipo, ['mru', 'mruv', 'parabolico'])) {
            $queryExperimentos->where('tipo', $tipo);
        }

        // Paginar experimentos (solo si no se filtró por "medicion")
        $experimentos = $queryExperimentos->paginate(10)->appends($request->query());

        // Si el filtro es "medicion", mostrar solo mediciones
        if ($tipo === 'medicion') {
            $experimentos = collect(); // vacío
        }

        // Query base de mediciones
        $queryMediciones = auth()->user()->mediciones()->latest();

        // Filtro por nombre (aplica también a mediciones)
        if ($buscar) {
            $queryMediciones->where('nombre', 'like', '%' . $buscar . '%');
        }

        // Si el filtro es distinto de “medicion”, mostrar todas o según filtro
        if (!$tipo || $tipo === 'medicion') {
            $mediciones = $queryMediciones->take(10)->get();
        } else {
            $mediciones = collect(); // vacío
        }

        return view('experimentos.index', compact('experimentos', 'mediciones'));
    }


    public function create(Request $request)
    {
        $tipo = $request->input('tipo', 'mruv');
        return view('experimentos.create', compact('tipo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:mru,mruv,parabolico',
            'parametros' => 'required|array',
            'resultados' => 'nullable|array',
            'notas' => 'nullable|string'
        ]);

        // Asociar el experimento al usuario autenticado
        $validated['user_id'] = auth()->id();

        $experimento = Experimento::create($validated);

        // Si es una petición AJAX, devolver JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Experimento guardado exitosamente',
                'redirect' => route('experimentos.show', $experimento)
            ]);
        }

        return redirect()->route('experimentos.show', $experimento)
            ->with('success', 'Experimento creado exitosamente');
    }

    public function show(Experimento $experimento)
    {
        // Verificar que el experimento pertenece al usuario autenticado
        if ($experimento->user_id !== auth()->id()) {
            return redirect()->route('experimentos.index')
                ->with('error', 'No tienes permiso para ver este experimento');
        }
        
        return view('experimentos.show', compact('experimento'));
    }

    public function simular(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:mru,mruv,parabolico',
            'parametros' => 'required|array'
        ]);

        $resultado = match($validated['tipo']) {
            'mru' => $this->cinematicaService->calcularMRU($validated['parametros']),
            'mruv' => $this->cinematicaService->calcularMRUV($validated['parametros']),
            'parabolico' => $this->cinematicaService->calcularParabolico($validated['parametros']),
        };

        return response()->json($resultado);
    }

    public function exportar(Experimento $experimento, Request $request)
    {
        // Verificar que el experimento pertenece al usuario
        if ($experimento->user_id !== auth()->id()) {
            return redirect()->route('experimentos.index')
                ->with('error', 'No tienes permiso para exportar este experimento');
        }

        $formato = $request->input('formato', 'csv');
        
        if (!isset($experimento->resultados['datos'])) {
            return back()->with('error', 'No hay datos para exportar');
        }

        if ($formato === 'csv') {
            $csv = $this->cinematicaService->exportarCSV(
                $experimento->resultados['datos'],
                $experimento->tipo
            );

            $filename = "experimento_{$experimento->id}_{$experimento->nombre}.csv";
            
            return response()->streamDownload(function() use ($csv) {
                echo $csv;
            }, $filename, [
                'Content-Type' => 'text/csv'
            ]);
        }

        return back()->with('error', 'Formato no soportado');
    }

    public function comparar(Experimento $experimento, Request $request)
    {
        // Verificar que el experimento pertenece al usuario
        if ($experimento->user_id !== auth()->id()) {
            return redirect()->route('experimentos.index')
                ->with('error', 'No tienes permiso para modificar este experimento');
        }

        $request->validate([
            'archivo_csv' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('archivo_csv');
        $datos_experimentales = $this->parsearCSV($file);

        $datos_teoricos = $experimento->resultados['datos'] ?? [];

        $variable = $experimento->tipo === 'mruv' ? 'x' : 'y';
        $rmse = $this->cinematicaService->calcularRMSE(
            $datos_teoricos,
            $datos_experimentales,
            $variable
        );

        $path = $file->store('datos_experimentales', 'public');

        $experimento->datosExperimentales()->create([
            'archivo_csv' => $path,
            'datos' => $datos_experimentales,
            'error_rmse' => $rmse
        ]);

        return back()->with('success', "Datos comparados. Error RMSE: {$rmse}");
    }

    public function destroy(Experimento $experimento)
    {
        // Verificar que el experimento pertenece al usuario
        if ($experimento->user_id !== auth()->id()) {
            return redirect()->route('experimentos.index')
                ->with('error', 'No tienes permiso para eliminar este experimento');
        }

        $experimento->delete();

        return redirect()->route('experimentos.index')
            ->with('success', 'Experimento eliminado exitosamente');
    }

    /**
     * Guardar datos capturados con OpenCV
     */
    public function guardarOpenCV(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string',
            'datos' => 'required|array',
            'escala' => 'nullable|numeric',
            'color_rastreado' => 'nullable|string'
        ]);

        $experimento = Experimento::create([
            'user_id' => auth()->id(),
            'nombre' => $validated['nombre'],
            'tipo' => 'opencv_' . $validated['tipo'],
            'parametros' => [
                'escala' => $validated['escala'] ?? 1,
                'color_rastreado' => $validated['color_rastreado'] ?? 'rojo',
                'tipo_analisis' => $validated['tipo']
            ],
            'resultados' => [
                'datos' => $validated['datos']
            ],
            'notas' => 'Datos capturados con cámara y OpenCV.js'
        ]);

        return response()->json([
            'success' => true,
            'experimento_id' => $experimento->id
        ]);
    }

    /**
     * Guardar datos capturados con Arduino
     */
    public function guardarArduino(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'datos' => 'required|array|min:1',
                'datos.*.t' => 'required|numeric',
                'datos.*.d' => 'required|numeric',
                'datos.*.v' => 'required|numeric',
                'datos.*.a' => 'required|numeric',
                'sensor' => 'nullable|string',
                'arduino' => 'nullable|string'
            ]);

            // Calcular estadísticas
            $datos = $validated['datos'];
            $n = count($datos);
            
            $distProm = array_sum(array_column($datos, 'd')) / $n;
            $velProm = array_sum(array_column($datos, 'v')) / $n;
            $acelProm = array_sum(array_column($datos, 'a')) / $n;

            $experimento = Experimento::create([
                'user_id' => auth()->id(),
                'nombre' => $validated['nombre'],
                'tipo' => 'arduino_sensor',
                'parametros' => [
                    'sensor' => $validated['sensor'] ?? 'HC-SR04',
                    'arduino' => $validated['arduino'] ?? 'Uno R3',
                    'num_muestras' => $n,
                    'tiempo_total' => end($datos)['t']
                ],
                'resultados' => [
                    'datos' => $datos,
                    'promedios' => [
                        'distancia' => round($distProm, 2),
                        'velocidad' => round($velProm, 2),
                        'aceleracion' => round($acelProm, 2)
                    ]
                ],
                'notas' => 'Datos capturados con Arduino ' . ($validated['arduino'] ?? 'Uno R3') . ' y sensor ' . ($validated['sensor'] ?? 'HC-SR04') . '. Total: ' . $n . ' muestras.'
            ]);

            return response()->json([
                'success' => true,
                'experimento_id' => $experimento->id,
                'message' => 'Experimento guardado correctamente'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error guardando experimento Arduino: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }

    private function parsearCSV($file): array
    {
        $datos = [];
        $handle = fopen($file->getRealPath(), 'r');
        
        $headers = fgetcsv($handle);
        
        while (($row = fgetcsv($handle)) !== false) {
            $datos[] = array_combine($headers, $row);
        }
        
        fclose($handle);
        
        return $datos;
    }
}