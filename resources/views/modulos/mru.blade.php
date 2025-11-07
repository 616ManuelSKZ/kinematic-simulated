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
        <h1 class="text-3xl font-bold text-gray-800 mt-4">Simulador MRU</h1>
        <p class="text-gray-600">Movimiento Rectilíneo Uniforme (velocidad constante)</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Panel de Control -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Parámetros</h2>
                
                <div class="mb-4 bg-blue-50 border-l-4 border-blue-500 p-3 rounded">
                    <p class="text-sm text-gray-700">
                        <strong>MRU:</strong> Movimiento con velocidad constante (aceleración = 0)
                    </p>
                </div>
                
                <form id="formMRU" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Velocidad constante (v)
                        </label>
                        <div class="flex items-center">
                            <input type="number" step="0.1" id="velocidad" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   value="10" required>
                            <span class="ml-2 text-gray-600">m/s</span>
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

                <!-- Fórmulas -->
                <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Fórmulas MRU</h3>
                    <div class="text-xs text-gray-600 space-y-1">
                        <p><strong>Posición:</strong> x(t) = x₀ + v·t</p>
                        <p><strong>Velocidad:</strong> v = constante</p>
                        <p><strong>Aceleración:</strong> a = 0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visualización -->
        <div class="lg:col-span-2">
            <!-- Canvas de Animación -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Animación</h2>
                <div class="border border-gray-300 rounded-lg overflow-hidden">
                    <canvas id="canvasMRU" width="700" height="200" class="w-full"></canvas>
                </div>
                <div class="mt-4 flex justify-between items-center">
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
                        <div class="text-sm text-gray-600 mb-1">Velocidad (constante)</div>
                        <div id="velocidadConstante" class="text-2xl font-bold text-green-600">-- m/s</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-600 mb-1">Distancia Recorrida</div>
                        <div id="distanciaTotal" class="text-2xl font-bold text-purple-600">-- m</div>
                    </div>
                </div>
            </div>

            <!-- Gráficas -->
            <div id="panelGraficas" class="bg-white rounded-lg shadow-lg p-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Gráficas</h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="text-md font-medium mb-2">Posición vs Tiempo (recta)</h3>
                        <canvas id="graficaPosicion" height="200"></canvas>
                    </div>
                    <div>
                        <h3 class="text-md font-medium mb-2">Velocidad vs Tiempo (constante)</h3>
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

document.getElementById('formMRU').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const parametros = {
        velocidad: parseFloat(document.getElementById('velocidad').value),
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
                tipo: 'mru',
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
    document.getElementById('velocidadConstante').textContent = resultados.velocidad_constante + ' m/s';
    document.getElementById('distanciaTotal').textContent = resultados.distancia_recorrida + ' m';
}

function crearGraficas(datos) {
    document.getElementById('panelGraficas').classList.remove('hidden');
    
    const tiempos = datos.map(d => d.t);
    const posiciones = datos.map(d => d.x);
    const velocidades = datos.map(d => d.v);

    // Gráfica de posición (recta)
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
                tension: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                title: {
                    display: true,
                    text: 'Gráfica lineal - pendiente = velocidad'
                }
            },
            scales: {
                x: { title: { display: true, text: 'Tiempo (s)' }},
                y: { title: { display: true, text: 'Posición (m)' }}
            }
        }
    });

    // Gráfica de velocidad (línea horizontal)
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
                tension: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                title: {
                    display: true,
                    text: 'Velocidad constante (línea horizontal)'
                }
            },
            scales: {
                x: { title: { display: true, text: 'Tiempo (s)' }},
                y: { 
                    title: { display: true, text: 'Velocidad (m/s)' },
                    min: 0
                }
            }
        }
    });
}

function iniciarAnimacion(datos) {
    const canvas = document.getElementById('canvasMRU');
    const ctx = canvas.getContext('2d');
    let indice = 0;
    animacionActiva = true;

    const xMax = Math.max(...datos.map(d => d.x));
    const margenIzquierdo = 50;
    const margenDerecho = 50;
    const anchoUtil = canvas.width - margenIzquierdo - margenDerecho;
    const escala = anchoUtil / xMax; // ajusta la escala dinámicamente

    const animar = () => {
        if (!animacionActiva || indice >= datos.length) {
            animacionActiva = false;
            document.getElementById('estadoAnimacion').textContent = 'Estado: Completado';
            return;
        }

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Pista
        ctx.fillStyle = '#e5e7eb';
        ctx.fillRect(0, canvas.height - 60, canvas.width, 60);

        // Líneas de referencia
        ctx.strokeStyle = '#9ca3af';
        ctx.lineWidth = 1;
        for (let i = 0; i < canvas.width; i += 50) {
            ctx.beginPath();
            ctx.moveTo(i, canvas.height - 60);
            ctx.lineTo(i, canvas.height);
            ctx.stroke();
        }

        // Calcular posición segura del carrito
        const dato = datos[indice];
        let posX = margenIzquierdo + (dato.x * escala);

        // Evitar que salga del canvas
        if (posX > canvas.width - 60) posX = canvas.width - 60;

        // Dibujar carrito
        ctx.fillStyle = '#3b82f6';
        ctx.fillRect(posX - 15, canvas.height - 80, 30, 20);
        ctx.fillStyle = '#1e40af';
        ctx.beginPath();
        ctx.arc(posX - 10, canvas.height - 58, 6, 0, Math.PI * 2);
        ctx.fill();
        ctx.beginPath();
        ctx.arc(posX + 10, canvas.height - 58, 6, 0, Math.PI * 2);
        ctx.fill();

        // Flecha de velocidad
        ctx.strokeStyle = '#10b981';
        ctx.lineWidth = 3;
        ctx.beginPath();
        ctx.moveTo(posX + 20, canvas.height - 70);
        ctx.lineTo(posX + 45, canvas.height - 70);
        ctx.stroke();

        ctx.fillStyle = '#10b981';
        ctx.beginPath();
        ctx.moveTo(posX + 45, canvas.height - 70);
        ctx.lineTo(posX + 40, canvas.height - 75);
        ctx.lineTo(posX + 40, canvas.height - 65);
        ctx.closePath();
        ctx.fill();

        // Texto
        ctx.fillStyle = '#1f2937';
        ctx.font = '14px Arial';
        ctx.fillText(`x = ${dato.x.toFixed(2)} m`, posX - 30, canvas.height - 90);
        ctx.fillText(`v = ${dato.v.toFixed(2)} m/s`, posX - 40, canvas.height - 105);

        // Título
        ctx.fillStyle = '#059669';
        ctx.font = 'bold 16px Arial';
        ctx.fillText('MRU: Velocidad constante', 10, 25);

        document.getElementById('tiempoActual').textContent = `t = ${dato.t.toFixed(2)} s`;
        document.getElementById('estadoAnimacion').textContent = 'Estado: Animando...';

        indice++;
        animacionFrame = setTimeout(animar, 50);
    };

    animar();
}


document.getElementById('btnReset').addEventListener('click', () => {
    animacionActiva = false;
    if (animacionFrame) clearTimeout(animacionFrame);
    
    const canvas = document.getElementById('canvasMRU');
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
    a.download = 'mru_simulacion.csv';
    a.click();
});

document.getElementById('btnGuardar').addEventListener('click', async () => {
    const nombre = prompt('Nombre del experimento:');
    if (!nombre) return;

    const parametros = {
        velocidad: parseFloat(document.getElementById('velocidad').value),
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
                tipo: 'mru',
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
@endsection