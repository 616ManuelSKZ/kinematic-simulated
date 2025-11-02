@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Simulador de Cinemática de los Cuerpos</h1>
        <p class="text-gray-600">Herramienta interactiva para análisis de MRUV y Movimiento Parabólico</p>
    </div>

    <!-- Tarjetas de Módulos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- MRU -->
        <a href="{{ route('mru') }}" class="block">
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6 border-t-4 border-cyan-500">
                <div class="flex items-center mb-4">
                    <div class="bg-cyan-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                    <h3 class="ml-4 text-xl font-semibold text-gray-800">MRU</h3>
                </div>
                <p class="text-gray-600 mb-4">Movimiento Rectilíneo Uniforme (velocidad constante)</p>
                <span class="text-cyan-600 text-sm font-medium">Iniciar simulación →</span>
            </div>
        </a>

        <!-- MRUV -->
        <a href="{{ route('mruv') }}" class="block">
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6 border-t-4 border-blue-500">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </div>
                    <h3 class="ml-4 text-xl font-semibold text-gray-800">MRUV</h3>
                </div>
                <p class="text-gray-600 mb-4">Movimiento Rectilíneo Uniformemente Variado</p>
                <span class="text-blue-600 text-sm font-medium">Iniciar simulación →</span>
            </div>
        </a>

        <!-- Movimiento Parabólico -->
        <a href="{{ route('parabolico') }}" class="block">
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6 border-t-4 border-green-500">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                    </div>
                    <h3 class="ml-4 text-xl font-semibold text-gray-800">Parabólico</h3>
                </div>
                <p class="text-gray-600 mb-4">Lanzamiento de proyectiles y trayectorias</p>
                <span class="text-green-600 text-sm font-medium">Iniciar simulación →</span>
            </div>
        </a>

        <!-- Mediciones y Errores -->
        <a href="{{ route('mediciones.create') }}" class="block">
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6 border-t-4 border-orange-500">
                <div class="flex items-center mb-4">
                    <div class="bg-orange-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="ml-4 text-xl font-semibold text-gray-800">Mediciones</h3>
                </div>
                <p class="text-gray-600 mb-4">Análisis de errores e incertidumbre</p>
                <span class="text-orange-600 text-sm font-medium">Analizar datos →</span>
            </div>
        </a>

        <!-- Rastreador OpenCV -->
        <a href="{{ route('opencv.tracker') }}" class="block">
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6 border-t-4 border-red-500">
                <div class="flex items-center mb-4">
                    <div class="bg-red-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="ml-4 text-xl font-semibold text-gray-800">Rastreador</h3>
                </div>
                <p class="text-gray-600 mb-4">Captura movimiento con tu cámara</p>
                <span class="text-red-600 text-sm font-medium">Usar cámara →</span>
            </div>
        </a>

        <!-- Experimentos Guardados -->
        <a href="{{ route('experimentos.index') }}" class="block">
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6 border-t-4 border-purple-500">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="ml-4 text-xl font-semibold text-gray-800">Experimentos</h3>
                </div>
                <p class="text-gray-600 mb-4">Ver y gestionar tus experimentos guardados</p>
                <span class="text-purple-600 text-sm font-medium">Ver historial →</span>
            </div>
        </a>

        <!-- Ayuda -->
        <a href="{{ route('ayuda') }}" class="block">
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6 border-t-4 border-yellow-500">
                <div class="flex items-center mb-4">
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="ml-4 text-xl font-semibold text-gray-800">Ayuda</h3>
                </div>
                <p class="text-gray-600 mb-4">Fórmulas, guías y procedimientos</p>
                <span class="text-yellow-600 text-sm font-medium">Ver documentación →</span>
            </div>
        </a>
    </div>

    <!-- Últimos Experimentos -->
    @if($ultimosExperimentos->count() > 0)
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Últimos Experimentos</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($ultimosExperimentos as $exp)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $exp->nombre }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 py-1 text-xs rounded-full {{ $exp->tipo === 'mruv' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ strtoupper($exp->tipo) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $exp->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('experimentos.show', $exp) }}" class="text-blue-600 hover:text-blue-800">Ver</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Botón flotante -->
    <div class="fixed bottom-8 right-8">
        <button onclick="document.getElementById('nuevoModal').classList.remove('hidden')" 
                class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg flex items-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span class="ml-2 font-medium">Nuevo Experimento</span>
        </button>
    </div>

    <!-- Modal Nuevo Experimento -->
    <div id="nuevoModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Selecciona el tipo de experimento</h3>
                <div class="space-y-3">
                    <a href="{{ route('mruv') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded text-center">
                        MRUV
                    </a>
                    <a href="{{ route('parabolico') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded text-center">
                        Parabólico
                    </a>
                    <button onclick="document.getElementById('nuevoModal').classList.add('hidden')" 
                            class="block w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-3 px-4 rounded text-center">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection