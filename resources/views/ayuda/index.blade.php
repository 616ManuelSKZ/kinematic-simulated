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
        <h1 class="text-3xl font-bold text-gray-800 mt-4">Centro de Ayuda</h1>
        <p class="text-gray-600">Fórmulas, guías y procedimientos para tus experimentos</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Menú lateral -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-4 sticky top-4">
                <h3 class="font-semibold text-gray-800 mb-3">Contenido</h3>
                <nav class="space-y-2">
                    <a href="#mruv" class="block px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded">MRUV</a>
                    <a href="#parabolico" class="block px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded">Movimiento Parabólico</a>
                    <a href="#errores" class="block px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded">Errores Comunes</a>
                </nav>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="lg:col-span-3 space-y-6">
            
            <!-- MRUV -->
            <div id="mruv" class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Movimiento Rectilíneo Uniformemente Variado (MRUV)</h2>
                
                <div class="prose max-w-none">
                    <h3 class="text-xl font-semibold text-gray-800 mt-4 mb-2">Descripción</h3>
                    <p class="text-gray-600 mb-4">
                        El MRUV es un movimiento en línea recta donde la velocidad cambia de manera constante debido a una aceleración uniforme.
                    </p>

                    <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-3">Fórmulas Principales</h3>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                        <div class="border-l-4 border-blue-500 pl-4">
                            <p class="font-mono text-lg mb-1">v(t) = v₀ + a·t</p>
                            <p class="text-sm text-gray-600">Velocidad en función del tiempo</p>
                        </div>
                        <div class="border-l-4 border-green-500 pl-4">
                            <p class="font-mono text-lg mb-1">v₀ᵧ = v₀·sin(θ)</p>
                            <p class="text-sm text-gray-600">Componente vertical de velocidad inicial</p>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-3">Ecuaciones de Posición</h3>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                        <div class="border-l-4 border-purple-500 pl-4">
                            <p class="font-mono text-lg mb-1">x(t) = x₀ + v₀ₓ·t</p>
                            <p class="text-sm text-gray-600">Posición horizontal</p>
                        </div>
                        <div class="border-l-4 border-orange-500 pl-4">
                            <p class="font-mono text-lg mb-1">y(t) = y₀ + v₀ᵧ·t - ½·g·t²</p>
                            <p class="text-sm text-gray-600">Posición vertical</p>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-3">Magnitudes Importantes</h3>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                        <div class="border-l-4 border-red-500 pl-4">
                            <p class="font-mono text-lg mb-1">t_vuelo = (v₀ᵧ + √(v₀ᵧ² + 2·g·y₀)) / g</p>
                            <p class="text-sm text-gray-600">Tiempo de vuelo (con altura inicial)</p>
                        </div>
                        <div class="border-l-4 border-yellow-500 pl-4">
                            <p class="font-mono text-lg mb-1">R = v₀²·sin(2θ) / g</p>
                            <p class="text-sm text-gray-600">Alcance máximo (sin altura inicial)</p>
                        </div>
                        <div class="border-l-4 border-pink-500 pl-4">
                            <p class="font-mono text-lg mb-1">h_max = y₀ + v₀ᵧ² / (2·g)</p>
                            <p class="text-sm text-gray-600">Altura máxima</p>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-3">Ejemplo Práctico</h3>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-gray-700 mb-2">
                            <strong>Problema:</strong> Se lanza un proyectil con velocidad inicial de 20 m/s a 45°. Calcular alcance y altura máxima.
                        </p>
                        <p class="text-gray-700 mb-2">
                            <strong>Datos:</strong> v₀ = 20 m/s, θ = 45°, g = 9.81 m/s², y₀ = 0
                        </p>
                        <p class="text-gray-700 mb-2">
                            <strong>Solución:</strong><br>
                            v₀ₓ = 20·cos(45°) = 14.14 m/s<br>
                            v₀ᵧ = 20·sin(45°) = 14.14 m/s<br>
                            R = (20²·sin(90°)) / 9.81 ≈ 40.77 m<br>
                            h_max = (14.14²) / (2·9.81) ≈ 10.19 m
                        </p>
                    </div>
                </div>
            </div>

            <!-- Errores Comunes -->
            <div id="errores" class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Errores Comunes y Cómo Evitarlos</h2>
                
                <div class="space-y-4">
                    <div class="border-l-4 border-red-500 pl-4 py-2">
                        <h4 class="font-semibold text-gray-800 mb-1">❌ Fricción no considerada</h4>
                        <p class="text-gray-600 text-sm">La fricción en superficies reales reduce la aceleración y velocidad. Usa lubricantes o superficies lisas.</p>
                    </div>

                    <div class="border-l-4 border-orange-500 pl-4 py-2">
                        <h4 class="font-semibold text-gray-800 mb-1">❌ Error en medición del tiempo</h4>
                        <p class="text-gray-600 text-sm">El tiempo de reacción humano es ~0.2s. Usa sensores automáticos o realiza múltiples mediciones.</p>
                    </div>

                    <div class="border-l-4 border-yellow-500 pl-4 py-2">
                        <h4 class="font-semibold text-gray-800 mb-1">❌ Ángulo mal medido</h4>
                        <p class="text-gray-600 text-sm">Un error de 5° puede cambiar el alcance en un 20%. Verifica el ángulo antes de cada lanzamiento.</p>
                    </div>

                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                        <h4 class="font-semibold text-gray-800 mb-1">❌ Resistencia del aire</h4>
                        <p class="text-gray-600 text-sm">Afecta más a objetos ligeros y veloces. Usa proyectiles densos o realiza experimentos en espacios cerrados.</p>
                    </div>

                    <div class="border-l-4 border-green-500 pl-4 py-2">
                        <h4 class="font-semibold text-gray-800 mb-1">❌ Condiciones iniciales inconsistentes</h4>
                        <p class="text-gray-600 text-sm">Asegura que la velocidad inicial y posición sean las mismas en todas las repeticiones.</p>
                    </div>

                    <div class="border-l-4 border-purple-500 pl-4 py-2">
                        <h4 class="font-semibold text-gray-800 mb-1">❌ No considerar la incertidumbre</h4>
                        <p class="text-gray-600 text-sm">Siempre reporta tus mediciones con su incertidumbre (ej: 5.2 ± 0.1 m).</p>
                    </div>
                </div>

                <div class="mt-6 bg-blue-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-blue-800 mb-2">💡 Consejo Pro</h4>
                    <p class="text-gray-700 text-sm">
                        La diferencia entre tus datos experimentales y el modelo teórico es normal. Documenta todas las posibles fuentes de error y analiza cuál tiene mayor impacto en tus resultados.
                    </p>
                </div>
            </div>

            <!-- Recursos Adicionales -->
            <div class="bg-gradient-to-r from-blue-500 to-green-500 rounded-lg shadow-lg p-6 text-white">
                <h2 class="text-2xl font-bold mb-4">¿Necesitas más ayuda?</h2>
                <p class="mb-4">Explora recursos adicionales para mejorar tus experimentos:</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">📚 Tutoriales en Video</h4>
                        <p class="text-sm">Aprende técnicas experimentales paso a paso</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">🧮 Calculadora de Errores</h4>
                        <p class="text-sm">Herramientas para análisis estadístico</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">📊 Ejemplos Resueltos</h4>
                        <p class="text-sm">Casos prácticos con soluciones detalladas</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">💬 Comunidad</h4>
                        <p class="text-sm">Comparte experiencias con otros estudiantes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    html {
        scroll-behavior: smooth;
    }
</style>
@endsection