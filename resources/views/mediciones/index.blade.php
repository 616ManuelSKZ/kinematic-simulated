@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Análisis de Mediciones</h1>
            <p class="text-gray-600">Tus mediciones y análisis de errores guardados</p>
        </div>
        <a href="{{ route('mediciones.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-medium py-3 px-6 rounded-md inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nueva Medición
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if($mediciones->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($mediciones as $medicion)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-800">
                        {{ strtoupper($medicion->tipo_magnitud) }}
                    </span>
                    <span class="text-sm text-gray-500">
                        {{ $medicion->created_at->diffForHumans() }}
                    </span>
                </div>
                
                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $medicion->nombre }}</h3>
                
                <div class="text-sm text-gray-600 mb-4 space-y-1">
                    <p><strong>N° Mediciones:</strong> {{ $medicion->numero_mediciones }}</p>
                    <p><strong>Unidad:</strong> {{ $medicion->unidad }}</p>
                    @if($medicion->analisis_resultado)
                        <p><strong>Media:</strong> {{ $medicion->analisis_resultado['estadisticas']['media'] ?? 'N/A' }} {{ $medicion->unidad }}</p>
                        <p><strong>σ:</strong> {{ $medicion->analisis_resultado['estadisticas']['desviacion_estandar'] ?? 'N/A' }} {{ $medicion->unidad }}</p>
                    @endif
                </div>

                @if($medicion->valor_verdadero)
                <div class="mb-4 text-xs bg-blue-50 p-2 rounded">
                    <span class="font-medium">Valor verdadero:</span> {{ $medicion->valor_verdadero }} {{ $medicion->unidad }}
                </div>
                @endif

                <div class="flex gap-2">
                    <a href="{{ route('mediciones.show', $medicion) }}" 
                       class="flex-1 bg-orange-600 hover:bg-orange-700 text-white text-center py-2 px-4 rounded text-sm font-medium">
                        Ver Análisis
                    </a>
                    <form action="{{ route('mediciones.destroy', $medicion) }}" method="POST" 
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
        @endforeach
    </div>

    <!-- Paginación -->
    <div class="mt-8">
        {{ $mediciones->links() }}
    </div>
    @else
    <div class="bg-white rounded-lg shadow-lg p-12 text-center">
        <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">No hay mediciones guardadas</h3>
        <p class="text-gray-600 mb-6">Comienza a analizar tus datos experimentales</p>
        <a href="{{ route('mediciones.create') }}" class="inline-block bg-orange-600 hover:bg-orange-700 text-white font-medium py-3 px-6 rounded-md">
            Crear Primera Medición
        </a>
    </div>
    @endif
</div>
@endsection