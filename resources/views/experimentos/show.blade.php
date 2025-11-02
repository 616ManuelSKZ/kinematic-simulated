@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('experimentos.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Volver a experimentos
        </a>
        <h1 class="text-3xl font-bold text-gray-800 mt-4">{{ $experimento->nombre }}</h1>
        <div class="flex items-center gap-4 mt-2">
            @if($experimento->tipo === 'mru')
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-cyan-100 text-cyan-800">MRU</span>
            @elseif($experimento->tipo === 'mruv')
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">MRUV</span>
            @else
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">PARABÓLICO</span>
            @endif
            <span class="text-gray-600 text-sm">{{ $experimento->created_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Parámetros -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Parámetros</h2>
                
                @if($experimento->tipo === 'mru')
                    <div class="space-y-3">
                        <div>
                            <div class="text-sm text-gray-600">Velocidad</div>
                            <div class="text-lg font-semibold">{{ $experimento->parametros['velocidad'] ?? 'N/A' }} m/s</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Tiempo total</div>
                            <div class="text-lg font-semibold">{{ $experimento->parametros['tiempo_total'] ?? 'N/A' }} s</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Posición inicial</div>
                            <div class="text-lg font-semibold">{{ $experimento->parametros['posicion_inicial'] ?? 0 }} m</div>
                        </div>
                    </div>
                @elseif($experimento->tipo === 'mruv')
                    <div class="space-y-3">
                        <div>
                            <div class="text-sm text-gray-600">Velocidad inicial (v₀)</div>
                            <div class="text-lg font-semibold">{{ $experimento->parametros['velocidad_inicial'] ?? 'N/A' }} m/s</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Aceleración (a)</div>
                            <div class="text-lg font-semibold">{{ $experimento->parametros['aceleracion'] ?? 'N/A' }} m/s²</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Tiempo total</div>
                            <div class="text-lg font-semibold">{{ $experimento->parametros['tiempo_total'] ?? 'N/A' }} s</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Posición inicial</div>
                            <div class="text-lg font-semibold">{{ $experimento->parametros['posicion_inicial'] ?? 0 }} m</div>
                        </div>
                    </div>
                @else
                    <div class="space-y-3">
                        <div>
                            <div class="text-sm text-gray-600">Velocidad inicial (v₀)</div>
                            <div class="text-lg font-semibold">{{ $experimento->parametros['velocidad_inicial'] ?? 'N/A' }} m/s</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Ángulo (θ)</div>
                            <div class="text-lg font-semibold">{{ $experimento->parametros['angulo'] ?? 'N/A' }}°</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Altura inicial (y₀)</div>
                            <div class="text-lg font-semibold">{{ $experimento->parametros['altura_inicial'] ?? 0 }} m</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Gravedad (g)</div>
                            <div class="text-lg font-semibold">{{ $experimento->parametros['gravedad'] ?? 9.81 }} m/s²</div>
                        </div>
                    </div>
                @endif
            </div>

            @if($experimento->notas)
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold mb-3">Notas</h3>
                <p class="text-gray-600 text-sm">{{ $experimento->notas }}</p>
            </div>
            @endif

            <div class="mt-6 space-y-2">
                <a href="{{ route('experimentos.exportar', $experimento) }}" 
                   class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 px-4 rounded-md font-medium">
                    Exportar CSV
                </a>
                <form action="{{ route('experimentos.destroy', $experimento) }}" method="POST" 
                      onsubmit="return confirm('¿Estás seguro de eliminar este experimento?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="block w-full bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-md font-medium">
                        Eliminar Experimento
                    </button>
                </form>
            </div>
        </div>

        <!-- Resultados -->
        <div class="lg:col-span-2">
            @if(isset($experimento->resultados['resultados']))
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Resultados</h2>
                
                @if($experimento->tipo === 'mru')
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-cyan-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600 mb-1">Posición Final</div>
                            <div class="text-2xl font-bold text-cyan-600">
                                {{ $experimento->resultados['resultados']['posicion_final'] ?? 'N/A' }} m
                            </div>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600 mb-1">Velocidad</div>
                            <div class="text-2xl font-bold text-blue-600">
                                {{ $experimento->resultados['resultados']['velocidad_constante'] ?? 'N/A' }} m/s
                            </div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600 mb-1">Distancia</div>
                            <div class="text-2xl font-bold text-purple-600">
                                {{ $experimento->resultados['resultados']['distancia_recorrida'] ?? 'N/A' }} m
                            </div>
                        </div>
                    </div>
                @elseif($experimento->tipo === 'mruv')
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600 mb-1">Posición Final</div>
                            <div class="text-2xl font-bold text-blue-600">
                                {{ $experimento->resultados['resultados']['posicion_final'] ?? 'N/A' }} m
                            </div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600 mb-1">Velocidad Final</div>
                            <div class="text-2xl font-bold text-green-600">
                                {{ $experimento->resultados['resultados']['velocidad_final'] ?? 'N/A' }} m/s
                            </div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600 mb-1">Distancia</div>
                            <div class="text-2xl font-bold text-purple-600">
                                {{ $experimento->resultados['resultados']['distancia_recorrida'] ?? 'N/A' }} m
                            </div>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-xs text-gray-600 mb-1">Tiempo de Vuelo</div>
                            <div class="text-xl font-bold text-green-600">
                                {{ $experimento->resultados['resultados']['tiempo_vuelo'] ?? 'N/A' }} s
                            </div>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-xs text-gray-600 mb-1">Alcance</div>
                            <div class="text-xl font-bold text-blue-600">
                                {{ $experimento->resultados['resultados']['alcance_maximo'] ?? 'N/A' }} m
                            </div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="text-xs text-gray-600 mb-1">Altura Máx</div>
                            <div class="text-xl font-bold text-purple-600">
                                {{ $experimento->resultados['resultados']['altura_maxima'] ?? 'N/A' }} m
                            </div>
                        </div>
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <div class="text-xs text-gray-600 mb-1">Vel. Impacto</div>
                            <div class="text-xl font-bold text-orange-600">
                                {{ $experimento->resultados['resultados']['velocidad_impacto'] ?? 'N/A' }} m/s
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            @endif

            <!-- Tabla de Datos -->
            @if(isset($experimento->resultados['datos']) && count($experimento->resultados['datos']) > 0)
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Datos de Simulación</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tiempo (s)</th>
                                @if($experimento->tipo === 'parabolico')
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">X (m)</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Y (m)</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vx (m/s)</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vy (m/s)</th>
                                @else
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posición (m)</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Velocidad (m/s)</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach(array_slice($experimento->resultados['datos'], 0, 20) as $dato)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $dato['t'] }}</td>
                                @if($experimento->tipo === 'parabolico')
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $dato['x'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $dato['y'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $dato['vx'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $dato['vy'] }}</td>
                                @else
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $dato['x'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $dato['v'] }}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(count($experimento->resultados['datos']) > 20)
                <p class="text-sm text-gray-500 mt-3 text-center">
                    Mostrando primeros 20 de {{ count($experimento->resultados['datos']) }} puntos. 
                    <a href="{{ route('experimentos.exportar', $experimento) }}" class="text-blue-600 hover:underline">Exportar todos a CSV</a>
                </p>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection