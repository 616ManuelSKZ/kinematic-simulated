<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - {{ config('app.name', 'Simulador de Cinemática') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    <div class="flex items-center justify-center min-h-screen px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-2xl p-8 sm:p-10 w-full max-w-md border-t-4 border-green-600">

            <!-- Encabezado -->
            <div class="text-center mb-6">
                <div class="flex justify-center mb-4">
                    <div class="bg-green-100 text-green-600 p-3 rounded-full">
                        <img src="{{ asset('imagenes/logo.png') }}" 
                            alt="Institución Logo" 
                            width="300">
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Crear Cuenta</h2>
                <p class="text-gray-600 text-sm mt-1">Regístrate para acceder al simulador</p>
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nombre -->
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Nombre')" class="text-gray-700 font-medium" />
                    <x-text-input id="name" 
                        class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-lg" 
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Correo Electrónico')" class="text-gray-700 font-medium" />
                    <x-text-input id="email" 
                        class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-lg"
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Contraseña -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Contraseña')" class="text-gray-700 font-medium" />
                    <x-text-input id="password" 
                        class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-lg"
                        type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Confirmar contraseña -->
                <div class="mb-6">
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-gray-700 font-medium" />
                    <x-text-input id="password_confirmation"
                        class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-lg"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Botones -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <p class="text-gray-600">
                        ¿Ya tienes cuenta?
                        <a href="{{ route('login') }}" 
                            class="text-sm text-green-600 hover:text-green-600 transition font-medium text-center sm:text-left">
                            Inicia sesión
                        </a>
                    </p>
                    

                    <x-primary-button 
                        class="w-full sm:w-auto justify-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg transition duration-200">
                        {{ __('Registrarse') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
