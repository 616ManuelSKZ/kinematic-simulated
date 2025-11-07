@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado -->
    <div class="mb-8 text-center">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Volver al inicio
        </a>
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Acerca de</h1>
        <p class="text-gray-600">Conoce más sobre este proyecto educativo</p>
    </div>

    <div class="max-w-4xl mx-auto">
        <!-- Logo y nombre de la institución -->
        <div class="bg-white rounded-lg shadow-xl p-8 mb-8">
            <div class="flex flex-col items-center mb-6">
                <!-- Logo ITCA-FEPADE -->
                <div class="mb-6">
                    <img src="{{ asset('imagenes/logo.png') }}" alt="Logo ITCA-FEPADE" class="h-32 w-auto">
                    <!-- Si no tienes el logo, usa esto: -->
                    <!-- <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl p-8 shadow-2xl">
                        <div class="text-white text-center">
                            <div class="text-5xl font-bold mb-2">ITCA</div>
                            <div class="text-3xl font-semibold">FEPADE</div>
                            <div class="text-lg mt-2 opacity-90">Zacatecoluca</div>
                        </div>
                    </div> -->
                </div>

                <h2 class="text-3xl font-bold text-gray-800 mb-2">
                    Instituto Técnico Centroamericano
                </h2>
                <p class="text-xl text-blue-600 font-semibold mb-1">FEPADE</p>
                <p class="text-lg text-gray-600">Sede Zacatecoluca</p>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <p class="text-gray-700 text-center leading-relaxed">
                    Institución líder en educación técnica y tecnológica comprometida con la 
                    formación de profesionales competentes para el desarrollo de El Salvador.
                </p>
            </div>
        </div>

        <!-- Información del Proyecto -->
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg shadow-lg p-8 mb-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                Sobre el Proyecto
            </h3>
            <div class="space-y-4 text-gray-700">
                <p>
                    El <strong>Simulador de Cinemática de los Cuerpos</strong> es una herramienta educativa 
                    desarrollada por estudiantes del ITCA-FEPADE Zacatecoluca con el objetivo de facilitar 
                    el aprendizaje de conceptos fundamentales de física.
                </p>
                <p>
                    Este proyecto integra tecnología web moderna con principios físicos para crear 
                    experiencias interactivas de aprendizaje, permitiendo a estudiantes y docentes 
                    experimentar con diferentes tipos de movimiento en tiempo real.
                </p>
            </div>
        </div>

        <!-- Características del Sistema -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Funcionalidades del Sistema
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-start space-x-3 p-4 bg-blue-50 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-gray-800">Simulaciones MRU y MRUV</h4>
                        <p class="text-sm text-gray-600">Visualización de movimiento rectilíneo uniforme y variado</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-4 bg-green-50 rounded-lg">
                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-gray-800">Tiro Parabólico</h4>
                        <p class="text-sm text-gray-600">Análisis de trayectorias de proyectiles</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-4 bg-orange-50 rounded-lg">
                    <svg class="w-6 h-6 text-orange-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-gray-800">Análisis de Errores</h4>
                        <p class="text-sm text-gray-600">Cálculo de incertidumbre en mediciones</p>
                    </div>
                </div>

                <!-- <div class="flex items-start space-x-3 p-4 bg-purple-50 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-gray-800">Rastreo con OpenCV</h4>
                        <p class="text-sm text-gray-600">Captura de movimiento real con cámara</p>
                    </div>
                </div> -->

                <div class="flex items-start space-x-3 p-4 bg-teal-50 rounded-lg">
                    <svg class="w-6 h-6 text-teal-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-gray-800">Integración Arduino</h4>
                        <p class="text-sm text-gray-600">Captura de datos con sensores HC-SR04</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-4 bg-red-50 rounded-lg">
                    <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-gray-800">Historial de Experimentos</h4>
                        <p class="text-sm text-gray-600">Guarda y gestiona tus simulaciones</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tecnologías Utilizadas -->
        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg shadow-lg p-8 mb-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                </svg>
                Tecnologías Utilizadas
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                    <p class="font-semibold text-gray-800">Laravel</p>
                    <p class="text-xs text-gray-600">Framework Backend</p>
                </div>
                <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                    <p class="font-semibold text-gray-800">PHP</p>
                    <p class="text-xs text-gray-600">Lenguaje Servidor</p>
                </div>
                <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                    <p class="font-semibold text-gray-800">JavaScript</p>
                    <p class="text-xs text-gray-600">Interactividad</p>
                </div>
                <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                    <p class="font-semibold text-gray-800">Tailwind CSS</p>
                    <p class="text-xs text-gray-600">Diseño UI</p>
                </div>
                <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                    <p class="font-semibold text-gray-800">MySQL</p>
                    <p class="text-xs text-gray-600">Base de Datos</p>
                </div>
                <!-- <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                    <p class="font-semibold text-gray-800">OpenCV</p>
                    <p class="text-xs text-gray-600">Visión Artificial</p>
                </div> -->
                <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                    <p class="font-semibold text-gray-800">Arduino</p>
                    <p class="text-xs text-gray-600">IoT</p>
                </div>
                <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                    <p class="font-semibold text-gray-800">Chart.js</p>
                    <p class="text-xs text-gray-600">Gráficas</p>
                </div>
            </div>
        </div>

        <!-- Frase Motivacional -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-xl p-8 text-center">
            <p class="text-white text-xl font-semibold italic mb-2">
                "Formando profesionales técnicos comprometidos con el desarrollo de El Salvador"
            </p>
            <p class="text-blue-100 text-sm">ITCA-FEPADE Zacatecoluca</p>
        </div>

        <!-- Botón Volver -->
        <div class="flex justify-center mt-8">
            <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow-lg transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Inicio
            </a>
        </div>
    </div>
</div>
@endsection