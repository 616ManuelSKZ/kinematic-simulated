<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - {{ config('app.name', 'Simulador de Cinemática') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    <div class="flex items-center justify-center min-h-screen px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-2xl p-8 sm:p-10 w-full max-w-md border-t-4 border-blue-600">
            
            <!-- Encabezado -->
            <div class="text-center mb-6">
                <div class="flex justify-center mb-4">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                        <img src="{{ asset('imagenes/logo.png') }}" 
                            alt="Institución Logo" 
                            width="300">
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Iniciar Sesión</h2>
                <p class="text-gray-600 text-sm mt-1">Accede a tu cuenta para continuar</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Formulario -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-5">
                    <x-input-label for="email" :value="__('Correo Electrónico')" class="text-gray-700 font-medium"/>
                    <x-text-input id="email"
                        class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-lg"
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <x-input-label for="password" :value="__('Contraseña')" class="text-gray-700 font-medium"/>
                    <x-text-input id="password"
                        class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-lg"
                        type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Botón -->
                <div class="flex justify-center">
                    <x-primary-button
                        class="w-full justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition duration-200">
                        {{ __('Entrar') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Enlaces inferiores -->
            <div class="text-center mt-6">
                <p class="text-gray-600 text-sm">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="text-blue-600 font-medium">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>
