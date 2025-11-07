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
        <h1 class="text-3xl font-bold text-gray-800 mt-4">Simulador MRUV</h1>
        <p class="text-gray-600">Movimiento Rectilíneo Uniformemente Variado</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Panel de Control -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Parámetros</h2>
                
                <form id="formMRUV" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Velocidad inicial (v₀)
                        </label>
                        <div class="flex items-center">
                            <input type="number" step="0.1" id="velocidad_inicial" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   value="0" required>
                            <span class="ml-2 text-gray-600">m/s</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Aceleración (a)
                        </label>
                        <div class="flex items-center">
                            <input type="number" step="0.1" id="aceleracion" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   value="2" required>
                            <span class="ml-2 text-gray-600">m/s²</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tiempo total (t)
                        </label>
                        <div class="flex items-center">
                            <input type="number" step="0.1" id="tiempo_total" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   value="10" min="0.1" required>
                            <span class="ml-2 text-gray-600">s</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Posición inicial (x₀)
                        </label>
                        <div class="flex items-center">
                            <input type="number" step="0.1" id="posicion_inicial" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   value="0">
                            <span class="ml-2 text-gray-600">m</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Intervalo de muestreo (Δt)
                        </label>
                        <div class="flex items-center">
                            <input type="number" step="0.01" id="intervalo" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   value="0.1" min="0.01">
                            <span class="ml-2 text-gray-600">s</span>
                        </div>
                    </div>

                    <div class="pt-4 space-y-2">
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-md transition">
                            Simular
                        </button>
                        <button type="button" id="btnReset" 
                                class="w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-4 rounded-md transition">
                            Reset
                        </button>
                        <button type="button" id="btnGuardar" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md transition" disabled>
                            Guardar Experimento
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Visualización -->
        <div class="lg:col-span-2">
            <!-- Canvas de Animación -->
            <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 mb-6">
                <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Animación</h2>

                <!-- Contenedor flexible para el canvas -->
                <div class="relative border border-gray-300 rounded-lg overflow-hidden bg-gray-50">
                    <div class="w-full overflow-x-auto">
                        <canvas 
                            id="canvasMRUV" 
                            class="block w-full max-w-full h-auto" 
                            width="700" 
                            height="200">
                        </canvas>
                    </div>
                </div>

                <!-- Estado y tiempo -->
                <div class="mt-3 sm:mt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <div id="estadoAnimacion" class="text-sm text-gray-600">
                        Estado: Detenido
                    </div>
                    <div id="tiempoActual" class="text-sm font-medium">
                        t = 0.00 s
                    </div>
                </div>
            </div>

            <!-- Resultados -->
            <div id="panelResultados" class="bg-white rounded-lg shadow-lg p-6 mb-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Resultados</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-600 mb-1">Posición Final</div>
                        <div id="posicionFinal" class="text-2xl font-bold text-blue-600">-- m</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-600 mb-1">Velocidad Final</div>
                        <div id="velocidadFinal" class="text-2xl font-bold text-green-600">-- m/s</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-600 mb-1">Distancia</div>
                        <div id="distanciaTotal" class="text-2xl font-bold text-purple-600">-- m</div>
                    </div>
                </div>
            </div>

            <!-- Gráficas -->
            <div id="panelGraficas" class="bg-white rounded-lg shadow-lg p-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Gráficas</h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="text-md font-medium mb-2">Posición vs Tiempo</h3>
                        <canvas id="graficaPosicion" height="200"></canvas>
                    </div>
                    <div>
                        <h3 class="text-md font-medium mb-2">Velocidad vs Tiempo</h3>
                        <canvas id="graficaVelocidad" height="200"></canvas>
                    </div>
                </div>
                
                <div class="mt-6">
                    <button id="btnExportar" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                        Exportar CSV
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let datosSimulacion = null;
let animacionActiva = false;
let animacionFrame = null;
let graficaPosChart = null;
let graficaVelChart = null;

document.getElementById('formMRUV').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const parametros = {
        velocidad_inicial: parseFloat(document.getElementById('velocidad_inicial').value),
        aceleracion: parseFloat(document.getElementById('aceleracion').value),
        tiempo_total: parseFloat(document.getElementById('tiempo_total').value),
        posicion_inicial: parseFloat(document.getElementById('posicion_inicial').value),
        intervalo: parseFloat(document.getElementById('intervalo').value)
    };

    try {
        const response = await fetch('{{ route("simular") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                tipo: 'mruv',
                parametros: parametros
            })
        });

        datosSimulacion = await response.json();
        
        mostrarResultados(datosSimulacion.resultados);
        crearGraficas(datosSimulacion.datos);
        iniciarAnimacion(datosSimulacion.datos);
        
        document.getElementById('btnGuardar').disabled = false;
        
    } catch (error) {
        console.error('Error:', error);
        alert('Error al realizar la simulación');
    }
});

function mostrarResultados(resultados) {
    document.getElementById('panelResultados').classList.remove('hidden');
    document.getElementById('posicionFinal').textContent = resultados.posicion_final + ' m';
    document.getElementById('velocidadFinal').textContent = resultados.velocidad_final + ' m/s';
    document.getElementById('distanciaTotal').textContent = resultados.distancia_recorrida + ' m';
}

function crearGraficas(datos) {
    document.getElementById('panelGraficas').classList.remove('hidden');
    
    const tiempos = datos.map(d => d.t);
    const posiciones = datos.map(d => d.x);
    const velocidades = datos.map(d => d.v);

    // Gráfica de posición
    const ctxPos = document.getElementById('graficaPosicion').getContext('2d');
    if (graficaPosChart) graficaPosChart.destroy();
    graficaPosChart = new Chart(ctxPos, {
        type: 'line',
        data: {
            labels: tiempos,
            datasets: [{
                label: 'Posición (m)',
                data: posiciones,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                x: { title: { display: true, text: 'Tiempo (s)' }},
                y: { title: { display: true, text: 'Posición (m)' }}
            }
        }
    });

    // Gráfica de velocidad
    const ctxVel = document.getElementById('graficaVelocidad').getContext('2d');
    if (graficaVelChart) graficaVelChart.destroy();
    graficaVelChart = new Chart(ctxVel, {
        type: 'line',
        data: {
            labels: tiempos,
            datasets: [{
                label: 'Velocidad (m/s)',
                data: velocidades,
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                x: { title: { display: true, text: 'Tiempo (s)' }},
                y: { title: { display: true, text: 'Velocidad (m/s)' }}
            }
        }
    });
}

function iniciarAnimacion(datos) {
    const canvas = document.getElementById('canvasMRUV');
    const ctx = canvas.getContext('2d');

    // Calcular dimensiones dinámicas
    const anchoContenedor = canvas.parentElement.offsetWidth;
    canvas.width = anchoContenedor;
    canvas.height = 220;

    // Calcular escala con base en la posición máxima de la simulación
    const maxX = Math.max(...datos.map(d => d.x));
    const margen = 100; // margen lateral para que el carrito no toque bordes
    const escala = (canvas.width - margen * 2) / maxX;

    let indice = 0;
    animacionActiva = true;

    const animar = () => {
        if (!animacionActiva || indice >= datos.length) {
            animacionActiva = false;
            document.getElementById('estadoAnimacion').textContent = 'Estado: Completado';
            return;
        }

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Fondo de pista
        ctx.fillStyle = '#e5e7eb';
        ctx.fillRect(0, canvas.height - 60, canvas.width, 60);

        // Líneas de referencia cada 50 px aprox (ajustadas según ancho)
        ctx.strokeStyle = '#9ca3af';
        ctx.lineWidth = 1;
        const separacion = Math.max(40, canvas.width / 15);
        for (let i = 0; i < canvas.width; i += separacion) {
            ctx.beginPath();
            ctx.moveTo(i, canvas.height - 60);
            ctx.lineTo(i, canvas.height);
            ctx.stroke();
        }

        // Obtener el dato actual
        const dato = datos[indice];
        const posX = margen + dato.x * escala;

        // Dibujar carrito (tamaño proporcional)
        const carroAncho = 30;
        const carroAlto = 20;

        ctx.fillStyle = '#3b82f6';
        ctx.fillRect(posX - carroAncho / 2, canvas.height - 80, carroAncho, carroAlto);

        // Ruedas
        ctx.fillStyle = '#1e40af';
        ctx.beginPath();
        ctx.arc(posX - 10, canvas.height - 58, 6, 0, Math.PI * 2);
        ctx.fill();
        ctx.beginPath();
        ctx.arc(posX + 10, canvas.height - 58, 6, 0, Math.PI * 2);
        ctx.fill();

        // Etiquetas informativas
        ctx.fillStyle = '#1f2937';
        ctx.font = '13px Arial';
        ctx.fillText(`x = ${dato.x.toFixed(2)} m`, posX - 30, canvas.height - 90);
        ctx.fillText(`v = ${dato.v.toFixed(2)} m/s`, posX - 30, canvas.height - 105);

        // Estado UI
        document.getElementById('tiempoActual').textContent = `t = ${dato.t.toFixed(2)} s`;
        document.getElementById('estadoAnimacion').textContent = 'Estado: Animando...';

        indice++;
        animacionFrame = requestAnimationFrame(animar);
    };

    animar();
}


document.getElementById('btnReset').addEventListener('click', () => {
    animacionActiva = false;
    if (animacionFrame) clearTimeout(animacionFrame);
    
    const canvas = document.getElementById('canvasMRUV');
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    document.getElementById('tiempoActual').textContent = 't = 0.00 s';
    document.getElementById('estadoAnimacion').textContent = 'Estado: Detenido';
    document.getElementById('panelResultados').classList.add('hidden');
    document.getElementById('panelGraficas').classList.add('hidden');
    document.getElementById('btnGuardar').disabled = true;
    datosSimulacion = null;
});

document.getElementById('btnExportar').addEventListener('click', () => {
    if (!datosSimulacion) return;
    
    let csv = 'Tiempo (s),Posición (m),Velocidad (m/s)\n';
    datosSimulacion.datos.forEach(d => {
        csv += `${d.t},${d.x},${d.v}\n`;
    });
    
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'mruv_simulacion.csv';
    a.click();
});

document.getElementById('btnGuardar').addEventListener('click', async () => {
    const nombre = prompt('Nombre del experimento:');
    if (!nombre) return;

    const parametros = {
        velocidad_inicial: parseFloat(document.getElementById('velocidad_inicial').value),
        aceleracion: parseFloat(document.getElementById('aceleracion').value),
        tiempo_total: parseFloat(document.getElementById('tiempo_total').value),
        posicion_inicial: parseFloat(document.getElementById('posicion_inicial').value),
        intervalo: parseFloat(document.getElementById('intervalo').value)
    };

    try {
        const response = await fetch('{{ route("experimentos.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                nombre: nombre,
                tipo: 'mruv',
                parametros: parametros,
                resultados: datosSimulacion
            })
        });

        if (response.ok) {
            alert('Experimento guardado exitosamente');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al guardar el experimento');
    }
});
</script>
<style>
#canvasMRUV {
    transition: all 0.3s ease;
}
#canvasMRUV:hover {
    filter: brightness(1.03);
}
</style>

@endsection