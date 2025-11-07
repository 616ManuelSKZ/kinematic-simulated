@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado -->
    <div class="mb-8">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Volver al inicio
        </a>
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Equipo de Desarrollo</h1>
        <p class="text-gray-600">Conoce a los desarrolladores detrás del Simulador de Cinemática</p>
    </div>

    <!-- Grid de Desarrolladores -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Desarrollador 1 -->
        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6">
            <div class="flex flex-col items-center">
                <!-- Avatar/Foto -->
                <div class="w-32 h-32 rounded-full overflow-hidden mb-4 border-4 border-white shadow-lg">
                    <img src="{{ asset('imagenes/dev1.png') }}" alt="Desarrollador 1" class="w-full h-full object-cover">
                    <!-- Si no tienes foto, usa esto: -->
                    <!-- <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-4xl font-bold">
                        D1
                    </div> -->
                </div>

                <!-- Información -->
                <h3 class="text-xl font-bold text-gray-800 mb-1 text-center">JAVIER ARMANDO CASTELLANOS SÁNCHEZ</h3>
                <p class="text-sm text-gray-500 mb-4">Desarrollador de Software</p>

                <!-- Contacto -->
                <div class="w-full space-y-2">
                    <div class="flex items-start gap-2 bg-white p-3 rounded-lg shadow-sm">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm text-gray-700 break-all">Caste756699@gmail.com</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white p-3 rounded-lg shadow-sm">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-sm text-gray-700">+503 6101 9414</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desarrollador 2 -->
        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6">
            <div class="flex flex-col items-center">
                <div class="w-32 h-32 rounded-full overflow-hidden mb-4 border-4 border-white shadow-lg">
                    <img src="{{ asset('imagenes/dev2.png') }}" alt="Desarrollador 2" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-1 text-center">MANUEL DE JESÚS RENDEROS HERNÁNDEZ</h3>
                <p class="text-sm text-gray-500 mb-4">Desarrollador de Software</p>
                <div class="w-full space-y-2">
                    <div class="flex items-start gap-2 bg-white p-3 rounded-lg shadow-sm">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm text-gray-700 break-all">503manuelhernandez2002@gmail.com</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white p-3 rounded-lg shadow-sm">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-sm text-gray-700">+503 6123-8848</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desarrollador 3 -->
        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6">
            <div class="flex flex-col items-center">
                <div class="w-32 h-32 rounded-full overflow-hidden mb-4 border-4 border-white shadow-lg">
                    <img src="{{ asset('imagenes/dev3.png') }}" alt="Desarrollador 3" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-1 text-center">EDENILSON JEOVANNY FLORES BARAHONA</h3>
                <p class="text-sm text-gray-500 mb-4">Desarrollador de Software</p>
                <div class="w-full space-y-2">
                    <div class="flex items-start gap-2 bg-white p-3 rounded-lg shadow-sm">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm text-gray-700 break-all">barahonaedenilson54@gmail.com</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white p-3 rounded-lg shadow-sm">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-sm text-gray-700">+503 7359-9776</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desarrollador 4 -->
        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6">
            <div class="flex flex-col items-center">
                <div class="w-32 h-32 rounded-full overflow-hidden mb-4 border-4 border-white shadow-lg">
                    <img src="{{ asset('imagenes/dev4.png') }}" alt="Desarrollador 4" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-1 text-center">ELIAN ISAI ARGUETA AMAYA</h3>
                <p class="text-sm text-gray-500 mb-4">Desarrollador de Software</p>
                <div class="w-full space-y-2">
                    <div class="flex items-start gap-2 bg-white p-3 rounded-lg shadow-sm">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm text-gray-700 break-all">elian.argueta24@itca.edu.sv</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white p-3 rounded-lg shadow-sm">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-sm text-gray-700">+503 7532-4732</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desarrollador 5 -->
        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6">
            <div class="flex flex-col items-center">
                <div class="w-32 h-32 rounded-full overflow-hidden mb-4 border-4 border-white shadow-lg">
                    <img src="{{ asset('imagenes/dev5.png') }}" alt="Desarrollador 5" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-1 text-center">MARIA LUISA RAMOS SANCHEZ</h3>
                <p class="text-sm text-gray-500 mb-4">Desarrollador de Software</p>
                <div class="w-full space-y-2">
                    <div class="flex items-start gap-2 bg-white p-3 rounded-lg shadow-sm">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm text-gray-700 break-all">lu.maria777788@gmail.com</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white p-3 rounded-lg shadow-sm">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-sm text-gray-700">+503 7838-3961</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desarrollador 6 -->
        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6">
            <div class="flex flex-col items-center">
                <div class="w-32 h-32 rounded-full overflow-hidden mb-4 border-4 border-white shadow-lg">
                    <img src="{{ asset('imagenes/dev6.png') }}" alt="Desarrollador 6" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-1 text-center">JOSE EDUARDO GUIDOS CORNEJO</h3>
                <p class="text-sm text-gray-500 mb-4">Desarrollador de Software.</p>
                <div class="w-full space-y-2">
                    <div class="flex items-start gap-2 bg-white p-3 rounded-lg shadow-sm">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm text-gray-700 break-all">jose.guidos24@itca.edu.sv</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white p-3 rounded-lg shadow-sm">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-sm text-gray-700">+503 6836-0265</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón Volver -->
    <div class="flex justify-center">
        <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition text-sm sm:text-base">
            Volver al Inicio
        </a>
    </div>
</div>
@endsection