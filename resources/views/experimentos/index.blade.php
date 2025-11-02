@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Volver al inicio
        </a>
        <h1 class="text-3xl font-bold text-gray-800 mt-4">Experimentos y Mediciones</h1>
        <p class="text-gray-600">Gestiona todos tus experimentos de cinemática y análisis de mediciones</p>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-lg p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar por nombre</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}" 
                       placeholder="Nombre del experimento..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                <select name="tipo" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="mru" {{ request('tipo') == 'mru' ? 'selected' : '' }}>MRU</option>
                    <option value="mruv" {{ request('tipo') == 'mruv' ? 'selected' : '' }}>MRUV</option>
                    <option value="parabolico" {{ request('tipo') == 'parabolico' ? 'selected' : '' }}>Parabólico</option>
                    <option value="medicion" {{ request('tipo') == 'medicion' ? 'selected' : '' }}>Mediciones</option>
                </select>
            </div>
            <div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                    Filtrar
                </button>
                <a href="{{ route('experimentos.index') }}" class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-md inline-block">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        {{ session('error') }}
    </div>
    @endif

    <!-- Lista de Experimentos -->
    @php
        $tieneContenido = $experimentos->count() > 0 || $mediciones->count() > 0;
        $filtroTipo = request('tipo');
        
        // Combinar y ordenar
        $todosLosItems = collect();
        
        if (!$filtroTipo || $filtroTipo !== 'medicion') {
            foreach($experimentos as $exp) {
                $todosLosItems->push([
                    'tipo_item' => 'experimento',
                    'data' => $exp,
                    'fecha' => $exp->created_at
                ]);
            }
        }
        
        if (!$filtroTipo || $filtroTipo === 'medicion') {
            foreach($mediciones as $med) {
                $todosLosItems->push([
                    'tipo_item' => 'medicion',
                    'data' => $med,
                    'fecha' => $med->created_at
                ]);
            }
        }
        
        $todosLosItems = $todosLosItems->sortByDesc('fecha');
    @endphp

    @if($tieneContenido && $todosLosItems->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($todosLosItems as $item)
            @if($item['tipo_item'] === 'experimento')
                @php $exp = $item['data']; @endphp
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            @if($exp->tipo === 'mru')
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-cyan-100 text-cyan-800">
                                    MRU
                                </span>
                            @elseif($exp->tipo === 'mruv')
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                                    MRUV
                                </span>
                            @else
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                                    PARABÓLICO
                                </span>
                            @endif
                            <span class="text-sm text-gray-500">
                                {{ $exp->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $exp->nombre }}</h3>
                        
                        <div class="text-sm text-gray-600 mb-4">
                            @if($exp->tipo === 'mru')
                                <p>v = {{ $exp->parametros['velocidad'] ?? 'N/A' }} m/s (constante)</p>
                                <p>t = {{ $exp->parametros['tiempo_total'] ?? 'N/A' }} s</p>
                            @elseif($exp->tipo === 'mruv')
                                <p>v₀ = {{ $exp->parametros['velocidad_inicial'] ?? 'N/A' }} m/s</p>
                                <p>a = {{ $exp->parametros['aceleracion'] ?? 'N/A' }} m/s²</p>
                                <p>t = {{ $exp->parametros['tiempo_total'] ?? 'N/A' }} s</p>
                            @else
                                <p>v₀ = {{ $exp->parametros['velocidad_inicial'] ?? 'N/A' }} m/s</p>
                                <p>θ = {{ $exp->parametros['angulo'] ?? 'N/A' }}°</p>
                                <p>y₀ = {{ $exp->parametros['altura_inicial'] ?? 'N/A' }} m</p>
                            @endif
                        </div>

                        @if($exp->notas)
                        <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $exp->notas }}</p>
                        @endif

                        <div class="flex gap-2">
                            <a href="{{ route('experimentos.show', $exp) }}" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded text-sm font-medium">
                                Ver Detalles
                            </a>
                            <form action="{{ route('experimentos.destroy', $exp) }}" method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar este experimento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded text-sm font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                @php $med = $item['data']; @endphp
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-orange-100 text-orange-800">
                                MEDICIÓN
                            </span>
                            <span class="text-sm text-gray-500">
                                {{ $med->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $med->nombre }}</h3>
                        
                        <div class="text-sm text-gray-600 mb-4">
                            <p><strong>Tipo:</strong> {{ ucfirst($med->tipo_magnitud) }}</p>
                            <p><strong>N° Mediciones:</strong> {{ count($med->valores) }}</p>
                            <p><strong>Unidad:</strong> {{ $med->unidad }}</p>
                            @if(isset($med->analisis_resultado['estadisticas']['media']))
                                <p><strong>Media:</strong> {{ $med->analisis_resultado['estadisticas']['media'] }} {{ $med->unidad }}</p>
                            @endif
                        </div>

                        @if($med->valor_verdadero)
                        <div class="mb-4 text-xs bg-blue-50 p-2 rounded">
                            <span class="font-medium">Valor verdadero:</span> {{ $med->valor_verdadero }} {{ $med->unidad }}
                        </div>
                        @endif

                        <div class="flex gap-2">
                            <a href="{{ route('mediciones.show', $med) }}" 
                               class="flex-1 bg-orange-600 hover:bg-orange-700 text-white text-center py-2 px-4 rounded text-sm font-medium">
                                Ver Análisis
                            </a>
                            <form action="{{ route('mediciones.destroy', $med) }}" method="POST" 
                                  onsubmit="return confirm('¿Eliminar esta medición?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded text-sm font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Paginación -->
    @if($experimentos->hasPages())
    <div class="mt-8">
        {{ $experimentos->links() }}
    </div>
    @endif
    @else
    <div class="bg-white rounded-lg shadow-lg p-12 text-center">
        <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">
            @if($filtroTipo)
                No hay experimentos de tipo "{{ strtoupper($filtroTipo) }}"
            @else
                No hay experimentos guardados
            @endif
        </h3>
        <p class="text-gray-600 mb-6">Comienza creando tu primer experimento</p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('mru') }}" class="inline-block bg-cyan-600 hover:bg-cyan-700 text-white font-medium py-3 px-6 rounded-md">
                Crear MRU
            </a>
            <a href="{{ route('mruv') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-md">
                Crear MRUV
            </a>
            <a href="{{ route('parabolico') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-md">
                Crear Parabólico
            </a>
            <a href="{{ route('mediciones.create') }}" class="inline-block bg-orange-600 hover:bg-orange-700 text-white font-medium py-3 px-6 rounded-md">
                Nueva Medición
            </a>
        </div>
    </div>
    @endif

    <!-- Leyenda de colores -->
    <div class="mt-8 bg-white rounded-lg shadow p-4">
        <h3 class="text-sm font-semibold text-gray-700 mb-3">Tipos de experimentos:</h3>
        <div class="flex flex-wrap gap-4 text-sm">
            <div class="flex items-center">
                <span class="px-2 py-1 rounded-full bg-cyan-100 text-cyan-800 text-xs font-medium mr-2">MRU</span>
                <span class="text-gray-600">Movimiento Rectilíneo Uniforme</span>
            </div>
            <div class="flex items-center">
                <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-medium mr-2">MRUV</span>
                <span class="text-gray-600">Movimiento Uniformemente Variado</span>
            </div>
            <div class="flex items-center">
                <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs font-medium mr-2">PARABÓLICO</span>
                <span class="text-gray-600">Movimiento Parabólico</span>
            </div>
            <div class="flex items-center">
                <span class="px-2 py-1 rounded-full bg-orange-100 text-orange-800 text-xs font-medium mr-2">MEDICIÓN</span>
                <span class="text-gray-600">Análisis de Errores</span>
            </div>
        </div>
    </div>
</div>
@endsection