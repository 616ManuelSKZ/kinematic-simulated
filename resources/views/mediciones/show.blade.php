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
        <h1 class="text-3xl font-bold text-gray-800 mt-4">{{ $medicione->nombre }}</h1>
        <div class="flex items-center gap-4 mt-2">
            <span class="px-3 py-1 text-sm font-medium rounded-full bg-orange-100 text-orange-800">
                {{ strtoupper($medicione->tipo_magnitud) }}
            </span>
            <span class="text-gray-600 text-sm">{{ $medicione->created_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Información y Acciones -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Información</h2>
                <div class="space-y-3">
                    <div>
                        <div class="text-sm text-gray-600">Tipo de magnitud</div>
                        <div class="text-lg font-semibold">{{ ucfirst($medicione->tipo_magnitud) }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Unidad</div>
                        <div class="text-lg font-semibold">{{ $medicione->unidad }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">N° Mediciones</div>
                        <div class="text-lg font-semibold">{{ count($medicione->valores) }}</div>
                    </div>
                    @if($medicione->valor_verdadero)
                    <div>
                        <div class="text-sm text-gray-600">Valor verdadero</div>
                        <div class="text-lg font-semibold">{{ $medicione->valor_verdadero }} {{ $medicione->unidad }}</div>
                    </div>
                    @endif
                </div>
            </div>

            @if($medicione->observaciones)
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-3">Observaciones</h3>
                <p class="text-gray-600 text-sm">{{ $medicione->observaciones }}</p>
            </div>
            @endif

            <div class="space-y-2">
                <a href="{{ route('mediciones.exportar', $medicione) }}" 
                   class="block w-full bg-orange-600 hover:bg-orange-700 text-white text-center py-3 px-4 rounded-md font-medium">
                    Exportar CSV
                </a>
                <form action="{{ route('mediciones.destroy', $medicione) }}" method="POST" 
                      onsubmit="return confirm('¿Estás seguro de eliminar esta medición?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="block w-full bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-md font-medium">
                        Eliminar Medición
                    </button>
                </form>
            </div>
        </div>

        <!-- Resultados -->
        <div class="lg:col-span-2">
            
            @if(isset($medicione->analisis_resultado['estadisticas']))
            <!-- Estadísticas -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Estadísticas Básicas</h2>
                @php $stats = $medicione->analisis_resultado['estadisticas']; @endphp
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-xs text-gray-600 mb-1">Media</div>
                        <div class="text-xl font-bold text-blue-600">{{ $stats['media'] }} {{ $medicione->unidad }}</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-xs text-gray-600 mb-1">Desv. Estándar</div>
                        <div class="text-xl font-bold text-purple-600">{{ $stats['desviacion_estandar'] }} {{ $medicione->unidad }}</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-xs text-gray-600 mb-1">Máximo</div>
                        <div class="text-xl font-bold text-green-600">{{ $stats['valor_maximo'] }} {{ $medicione->unidad }}</div>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <div class="text-xs text-gray-600 mb-1">Mínimo</div>
                        <div class="text-xl font-bold text-red-600">{{ $stats['valor_minimo'] }} {{ $medicione->unidad }}</div>
                    </div>
                </div>
            </div>

            <!-- Incertidumbre -->
            @if(isset($medicione->analisis_resultado['incertidumbre']))
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Incertidumbre</h2>
                @php $inc = $medicione->analisis_resultado['incertidumbre']; @endphp
                <div class="bg-gradient-to-r from-green-50 to-blue-50 p-4 rounded-lg border border-green-200 mb-4">
                    <h3 class="font-semibold text-gray-800 mb-2">Resultado Final (95% confianza)</h3>
                    <div class="text-2xl font-bold text-green-700">
                        {{ $inc['resultado_con_incertidumbre_95'] }} {{ $medicione->unidad }}
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-sm text-gray-600">Inc. Estándar</div>
                        <div class="text-lg font-semibold">{{ $inc['incertidumbre_estandar'] }} {{ $medicione->unidad }}</div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-sm text-gray-600">Inc. Expandida (68%)</div>
                        <div class="text-lg font-semibold">{{ $inc['incertidumbre_expandida_68'] }} {{ $medicione->unidad }}</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Gráfica -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Gráfica de Mediciones</h2>
                <canvas id="graficaMediciones" height="250"></canvas>
            </div>

            <!-- Tabla de Errores -->
            @if(isset($medicione->analisis_resultado['error_absoluto']))
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Análisis de Errores</h2>
                @php $errorAbs = $medicione->analisis_resultado['error_absoluto']; @endphp
                
                <div class="mb-4 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <div class="text-sm font-medium text-blue-900">Error Absoluto Promedio</div>
                    <div class="text-2xl font-bold text-blue-700">{{ $errorAbs['error_absoluto_promedio'] }} {{ $medicione->unidad }}</div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Medición</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Error Absoluto</th>
                                @if(isset($medicione->analisis_resultado['error_relativo']))
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Error Relativo (%)</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($errorAbs['errores'] as $i => $error)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $error['medicion'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $error['valor'] }} {{ $medicione->unidad }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $error['error_absoluto'] }} {{ $medicione->unidad }}</td>
                                @if(isset($medicione->analisis_resultado['error_relativo']))
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $medicione->analisis_resultado['error_relativo']['errores'][$i]['error_relativo'] }}%
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const datosGrafica = @json($datosGrafica);
const unidad = '{{ $medicione->unidad }}';

const ctx = document.getElementById('graficaMediciones').getContext('2d');
const mediciones = datosGrafica.map(d => d.y);
const media = datosGrafica[0].media;
const limSup = datosGrafica[0].limite_superior;
const limInf = datosGrafica[0].limite_inferior;

new Chart(ctx, {
    type: 'line',
    data: {
        labels: datosGrafica.map(d => 'Med ' + d.x),
        datasets: [
            {
                label: 'Mediciones',
                data: mediciones,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                pointRadius: 6,
                pointHoverRadius: 8,
                type: 'scatter'
            },
            {
                label: 'Media',
                data: Array(datosGrafica.length).fill(media),
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 2,
                borderDash: [5, 5],
                pointRadius: 0
            },
            {
                label: 'Lím. Superior (σ)',
                data: Array(datosGrafica.length).fill(limSup),
                borderColor: 'rgb(239, 68, 68)',
                borderWidth: 1,
                borderDash: [2, 2],
                pointRadius: 0
            },
            {
                label: 'Lím. Inferior (σ)',
                data: Array(datosGrafica.length).fill(limInf),
                borderColor: 'rgb(239, 68, 68)',
                borderWidth: 1,
                borderDash: [2, 2],
                pointRadius: 0
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true },
            tooltip: {
                callbacks: {
                    label: (context) => context.dataset.label + ': ' + context.parsed.y.toFixed(4) + ' ' + unidad
                }
            }
        },
        scales: {
            y: {
                title: { display: true, text: 'Valor (' + unidad + ')' }
            },
            x: {
                title: { display: true, text: 'N° Medición' }
            }
        }
    }
});
</script>
@endsection