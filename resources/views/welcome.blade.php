<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Simulador de Cinemática') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex flex-col items-center justify-center min-h-screen px-4 sm:px-6 lg:px-8">

        <!-- Logo institucional -->
        <div class="mt-10 sm:mt-12 flex justify-center">
            <img src="{{ asset('imagenes/logo.png') }}" 
                 alt="Institución Logo" 
                 width="600">
        </div>

        <br>

        <!-- Título y descripción -->
        <div class="text-center mb-10 sm:mb-12">
            <h1 class="text-2xl sm:text-4xl font-bold text-gray-800 mb-3 sm:mb-4 leading-tight">
                Bienvenido al Simulador de Cinemática de los Cuerpos
            </h1>
            <p class="text-gray-600 max-w-md sm:max-w-2xl mx-auto text-sm sm:text-base leading-relaxed">
                Explora nuestros simuladores interactivos y lleva tus conocimientos de física al siguiente nivel.
            </p>
        </div>

        <!-- Tarjetas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-8 w-full max-w-3xl">
            <!-- Login -->
            <div class="bg-white shadow-md rounded-2xl p-6 sm:p-8 hover:shadow-lg transition transform hover:-translate-y-1 border border-gray-100">
                <div class="flex flex-col items-center text-center">
                    <div class="bg-blue-100 text-blue-600 rounded-full p-3 sm:p-4 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 sm:w-10 sm:h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5" />
                        </svg>
                    </div>
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-2">Iniciar Sesión</h2>
                    <p class="text-gray-600 mb-5 sm:mb-6 text-sm sm:text-base leading-snug">
                        Accede con tu cuenta para continuar al panel de simulaciones.
                    </p>
                    <a href="{{ route('login') }}" 
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 sm:px-6 rounded-lg transition text-sm sm:text-base">
                        Ir al Login
                    </a>
                </div>
            </div>

            <!-- Registro -->
            <div class="bg-white shadow-md rounded-2xl p-6 sm:p-8 hover:shadow-lg transition transform hover:-translate-y-1 border border-gray-100">
                <div class="flex flex-col items-center text-center">
                    <div class="bg-green-100 text-green-600 rounded-full p-3 sm:p-4 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 sm:w-10 sm:h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-2">Registrarse</h2>
                    <p class="text-gray-600 mb-5 sm:mb-6 text-sm sm:text-base leading-snug">
                        Crea una cuenta nueva y empieza a experimentar con los simuladores.
                    </p>
                    <a href="{{ route('register') }}" 
                       class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-5 sm:px-6 rounded-lg transition text-sm sm:text-base">
                        Crear Cuenta
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
