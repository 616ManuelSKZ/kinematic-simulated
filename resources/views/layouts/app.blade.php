<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Simulador de Cinemática') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        
        <!-- Navigation -->
        <nav x-data="{ open: false }" class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo y Menú Principal -->
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="flex items-center">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span class="ml-2 text-xl font-bold text-gray-800">Cinemática</span>
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                            <a href="{{ route('dashboard') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Inicio
                            </a>

                            <!-- Dropdown de Simuladores -->
                            <div x-data="{ openSim: false }" class="relative">
                                <button @click="openSim = !openSim" 
                                    class="inline-flex items-center px-3 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-600 hover:text-gray-900 hover:border-gray-300 focus:outline-none transition">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Simuladores
                                    <svg class="ml-1 w-4 h-4 text-gray-500 transition-transform duration-200" 
                                        :class="{ 'rotate-180': openSim }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Menú desplegable -->
                                <div x-show="openSim" 
                                    @click.away="openSim = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute left-0 mt-2 w-60 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                                    style="display: none;">

                                    <!-- Opciones principales -->
                                    <div class="py-1">
                                        <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Simuladores</div>
                                        <a href="{{ route('mru') }}" 
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">
                                            ⚙️ <span>MRU — Rectilíneo Uniforme</span>
                                        </a>
                                        <a href="{{ route('mruv') }}" 
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">
                                            🚀 <span>MRUV — Uniformemente Variado</span>
                                        </a>
                                        <a href="{{ route('parabolico') }}" 
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition">
                                            🎯 <span>Movimiento Parabólico</span>
                                        </a>
                                        <a href="{{ route('mediciones.create') }}" 
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700 transition">
                                            📏 <span>Análisis de Mediciones</span>
                                        </a>
                                        <a href="{{ route('arduino.sensor') }}" 
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition">
                                            🔧 <span>MRU con Arduino + Sensor</span>
                                        </a>
                                    </div>

                                    <hr class="my-1">

                                    <!-- Sección secundaria -->
                                    <div class="py-1">
                                        <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Utilidades</div>
                                        <a href="{{ route('experimentos.index') }}" 
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition">
                                            📂 <span>Mis Experimentos</span>
                                        </a>
                                        <a href="{{ route('ayuda') }}" 
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition">
                                            💡 <span>Centro de Ayuda</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Desarrolladores -->
                            <a href="{{ route('desarrolladores') }}" 
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors 
                            {{ request()->routeIs('desarrolladores') 
                                    ? 'border-violet-500 text-gray-900' 
                                    : 'border-transparent text-gray-500 hover:text-violet-700 hover:border-violet-300' }}">
                                <svg class="w-4 h-4 mr-2 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M15 10l4.55 2.27a2 2 0 010 3.46L15 18m-6 0l-4.55-2.27a2 2 0 010-3.46L9 10m6-4H9m6 0a3 3 0 013 3v1a3 3 0 01-3 3H9a3 3 0 01-3-3V9a3 3 0 013-3h6z" />
                                </svg>
                                Desarrolladores
                            </a>

                            <!-- Acerca de -->
                            <a href="{{ route('acerca-de') }}" 
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors 
                            {{ request()->routeIs('acerca-de') 
                                    ? 'border-slate-500 text-gray-900' 
                                    : 'border-transparent text-gray-500 hover:text-slate-700 hover:border-slate-300' }}">
                                <svg class="w-4 h-4 mr-2 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                </svg>
                                Acerca de
                            </a>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <!-- Dropdown Usuario -->
                        <div class="relative">
                            <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <span class="ml-2">{{ auth()->user()->name }}</span>
                                    <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50"
                                 style="display: none;">
                                
                                <!-- <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Mi Perfil
                                </a> -->

                                <a href="{{ route('experimentos.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Mis Experimentos
                                </a>

                                <hr class="my-1">

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Hamburger (Mobile) -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu (Mobile) -->
            <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1" x-data="{ openSimMob: false }">
                    
                    <!-- Inicio -->
                    <a href="{{ route('dashboard') }}" 
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium 
                    {{ request()->routeIs('dashboard') 
                        ? 'border-blue-500 text-blue-700 bg-blue-50' 
                        : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                        🏠 Inicio
                    </a>

                    <!-- Simuladores con submenú colorido -->
                    <button @click="openSimMob = !openSimMob"
                            class="w-full flex justify-between items-center pl-3 pr-4 py-2 border-l-4 text-base font-medium border-transparent text-gray-700 hover:text-blue-700 hover:bg-blue-50 hover:border-blue-300 focus:outline-none">
                        <span>🧪 Simuladores</span>
                        <svg :class="{ 'rotate-180': openSimMob }" 
                            class="w-5 h-5 transform transition-transform text-gray-500" 
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Submenú con íconos -->
                    <div x-show="openSimMob"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="ml-6 border-l border-gray-200 pl-3 space-y-1 mt-1"
                        style="display: none;">

                        <!-- MRU -->
                        <a href="{{ route('mru') }}" 
                        class="flex items-center gap-2 py-2 px-2 rounded-md text-sm text-blue-700 hover:bg-blue-50 transition">
                            ⚙️ 
                            <span>MRU — Rectilíneo Uniforme</span>
                        </a>

                        <!-- MRUV -->
                        <a href="{{ route('mruv') }}" 
                        class="flex items-center gap-2 py-2 px-2 rounded-md text-sm text-sky-700 hover:bg-sky-50 transition">
                            🚀 
                            <span>MRUV — Uniformemente Variado</span>
                        </a>

                        <!-- Parabólico -->
                        <a href="{{ route('parabolico') }}" 
                        class="flex items-center gap-2 py-2 px-2 rounded-md text-sm text-green-700 hover:bg-green-50 transition">
                            🎯 
                            <span>Movimiento Parabólico</span>
                        </a>

                        <!-- Mediciones -->
                        <a href="{{ route('mediciones.create') }}" 
                        class="flex items-center gap-2 py-2 px-2 rounded-md text-sm text-orange-700 hover:bg-orange-50 transition">
                            📏 
                            <span>Análisis de Mediciones</span>
                        </a>

                        <!-- Arduino -->
                        <a href="{{ route('arduino.sensor') }}" 
                        class="flex items-center gap-2 py-2 px-2 rounded-md text-sm text-teal-700 hover:bg-teal-50 transition">
                            🔧 
                            <span>MRU con Arduino + Sensor</span>
                        </a>
                    </div>

                    <!-- Otros enlaces -->
                    <a href="{{ route('experimentos.index') }}" 
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium 
                    {{ request()->routeIs('experimentos.*') 
                        ? 'border-purple-500 text-purple-700 bg-purple-50' 
                        : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                        📂 Experimentos
                    </a>

                    <a href="{{ route('ayuda') }}" 
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium 
                    {{ request()->routeIs('ayuda') 
                        ? 'border-yellow-500 text-yellow-700 bg-yellow-50' 
                        : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                        💡 Ayuda
                    </a>

                    <!-- 🎨 Desarrolladores -->
                    <a href="{{ route('desarrolladores') }}" 
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium 
                    {{ request()->routeIs('desarrolladores') 
                        ? 'border-violet-500 text-violet-700 bg-violet-50' 
                        : 'border-transparent text-gray-600 hover:text-violet-700 hover:bg-violet-50 hover:border-violet-300' }}">
                        👨‍💻 Desarrolladores
                    </a>

                    <!-- ℹ️ Acerca de -->
                    <a href="{{ route('acerca-de') }}" 
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium 
                    {{ request()->routeIs('acerca-de') 
                        ? 'border-slate-500 text-slate-700 bg-slate-50' 
                        : 'border-transparent text-gray-600 hover:text-slate-700 hover:bg-slate-50 hover:border-slate-300' }}">
                        ℹ️ Acerca de
                    </a>
                </div>

                <!-- User Options (Mobile) -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800">{{ auth()->user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="block w-full text-left px-4 py-2 text-base font-medium text-red-600 hover:bg-red-50">
                                🚪 Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Simuladores</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('mru') }}" class="text-gray-600 hover:text-blue-600">MRU</a></li>
                            <li><a href="{{ route('mruv') }}" class="text-gray-600 hover:text-blue-600">MRUV</a></li>
                            <li><a href="{{ route('parabolico') }}" class="text-gray-600 hover:text-blue-600">Movimiento Parabólico</a></li>
                            <li><a href="{{ route('mediciones.create') }}" class="text-gray-600 hover:text-blue-600">Mediciones</a></li>
                            <li><a href="{{ route('arduino.sensor') }}" class="text-gray-600 hover:text-blue-600">Arduino + Sensor</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Recursos</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('ayuda') }}" class="text-gray-600 hover:text-blue-600">Centro de Ayuda</a></li>
                            <li><a href="{{ route('experimentos.index') }}" class="text-gray-600 hover:text-blue-600">Mis Experimentos</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Información del Proyecto</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('desarrolladores') }}" class="text-gray-600 hover:text-blue-600">Desarrolladores</a></li>
                            <li><a href="{{ route('acerca-de') }}" class="text-gray-600 hover:text-blue-600">Acerca de</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Sobre el Proyecto</h3>
                        <p class="text-gray-600 text-sm">
                            Simulador educativo para el estudio de cinemática y análisis de movimientos.
                        </p>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-200 pt-8 text-center">
                    <p class="text-gray-500 text-sm">
                        &copy; {{ date('Y') }} Simulador de Cinemática. Todos los derechos reservados.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Alpine.js para interactividad -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>