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
        <h1 class="text-3xl font-bold text-gray-800 mt-4">Simulador de Movimiento Parabólico</h1>
        <p class="text-gray-600">Lanzamiento de proyectiles y trayectorias</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Panel de Control -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Parámetros</h2>
                
                <form id="formParabolico" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Velocidad inicial (v₀)
                        </label>
                        <div class="flex items-center">
                            <input type="number" step="0.1" id="velocidad_inicial" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" 
                                   value="20" min="0.1" required>
                            <span class="ml-2 text-gray-600">m/s</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Ángulo (θ): <span id="anguloValor" class="text-green-600 font-medium">45</span>°
                        </label>
                        <input type="range" id="angulo" min="1" max="89" value="45" 
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>1°</span>
                            <span>45°</span>
                            <span>89°</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Altura inicial (y₀)
                        </label>
                        <div class="flex items-center">
                            <input type="number" step="0.1" id="altura_inicial" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" 
                                   value="0" min="0">
                            <span class="ml-2 text-gray-600">m</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Gravedad (g)
                        </label>
                        <div class="flex items-center">
                            <input type="number" step="0.01" id="gravedad" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" 
                                   value="9.81" min="0.1">
                            <span class="ml-2 text-gray-600">m/s²</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Intervalo (Δt)
                        </label>
                        <div class="flex items-center">
                            <input type="number" step="0.001" id="intervalo" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" 
                                   value="0.01" min="0.001">
                            <span class="ml-2 text-gray-600">s</span>
                        </div>
                    </div>

                    <div class="pt-4 space-y-2">
                        <button type="submit" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md transition">
                            Simular
                        </button>
                        <button type="button" id="btnReset" 
                                class="w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-4 rounded-md transition">
                            Reset
                        </button>
                        <button type="button" id="btnGuardar" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-md transition" disabled>
                            Guardar Experimento
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Visualización -->
        <div class="lg:col-span-2">
            <!-- Canvas de Animación -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Trayectoria</h2>
                <div class="border border-gray-300 rounded-lg overflow-hidden bg-gradient-to-b from-blue-50 to-green-50">
                    <canvas id="canvasParabolico" width="700" height="400" class="w-full"></canvas>
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
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-xs text-gray-600 mb-1">Tiempo de Vuelo</div>
                        <div id="tiempoVuelo" class="text-xl font-bold text-green-600">-- s</div>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-xs text-gray-600 mb-1">Alcance Máximo</div>
                        <div id="alcanceMaximo" class="text-xl font-bold text-blue-600">-- m</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-xs text-gray-600 mb-1">Altura Máxima</div>
                        <div id="alturaMaxima" class="text-xl font-bold text-purple-600">-- m</div>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <div class="text-xs text-gray-600 mb-1">Velocidad Impacto</div>
                        <div id="velocidadImpacto" class="text-xl font-bold text-orange-600">-- m/s</div>
                    </div>
                </div>
                
                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-600">Componente v₀ₓ</div>
                        <div id="v0x" class="text-lg font-semibold text-gray-700">-- m/s</div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-600">Componente v₀ᵧ</div>
                        <div id="v0y" class="text-lg font-semibold text-gray-700">-- m/s</div>
                    </div>
                </div>
            </div>

            <!-- Gráficas -->
            <div id="panelGraficas" class="bg-white rounded-lg shadow-lg p-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Gráficas</h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="text-md font-medium mb-2">Trayectoria (y vs x)</h3>
                        <canvas id="graficaTrayectoria" height="200"></canvas>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-md font-medium mb-2">Posición X vs Tiempo</h3>
                            <canvas id="graficaPosX" height="150"></canvas>
                        </div>
                        <div>
                            <h3 class="text-md font-medium mb-2">Posición Y vs Tiempo</h3>
                            <canvas id="graficaPosY" height="150"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <button id="btnExportar" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded">
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
let charts = {};

// Actualizar valor del ángulo en tiempo real
document.getElementById('angulo').addEventListener('input', (e) => {
    document.getElementById('anguloValor').textContent = e.target.value;
});

document.getElementById('formParabolico').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const parametros = {
        velocidad_inicial: parseFloat(document.getElementById('velocidad_inicial').value),
        angulo: parseFloat(document.getElementById('angulo').value),
        altura_inicial: parseFloat(document.getElementById('altura_inicial').value),
        gravedad: parseFloat(document.getElementById('gravedad').value),
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
                tipo: 'parabolico',
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
    document.getElementById('tiempoVuelo').textContent = resultados.tiempo_vuelo + ' s';
    document.getElementById('alcanceMaximo').textContent = resultados.alcance_maximo + ' m';
    document.getElementById('alturaMaxima').textContent = resultados.altura_maxima + ' m';
    document.getElementById('velocidadImpacto').textContent = resultados.velocidad_impacto + ' m/s';
    document.getElementById('v0x').textContent = resultados.componentes_iniciales.vx + ' m/s';
    document.getElementById('v0y').textContent = resultados.componentes_iniciales.vy + ' m/s';
}

function crearGraficas(datos) {
    document.getElementById('panelGraficas').classList.remove('hidden');
    
    const tiempos = datos.map(d => d.t);
    const posX = datos.map(d => d.x);
    const posY = datos.map(d => d.y);

    // Destruir gráficas anteriores
    Object.values(charts).forEach(chart => chart?.destroy());
    charts = {};

    // Gráfica de trayectoria (y vs x)
    const ctxTray = document.getElementById('graficaTrayectoria').getContext('2d');
    charts.trayectoria = new Chart(ctxTray, {
        type: 'line',
        data: {
            labels: posX,
            datasets: [{
                label: 'Trayectoria',
                data: posX.map((x, i) => ({ x: x, y: posY[i] })),
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.4,
                pointRadius: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                x: { 
                    type: 'linear',
                    title: { display: true, text: 'Posición X (m)' }
                },
                y: { 
                    title: { display: true, text: 'Posición Y (m)' },
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfica Posición X vs Tiempo
    const ctxPosX = document.getElementById('graficaPosX').getContext('2d');
    charts.posX = new Chart(ctxPosX, {
        type: 'line',
        data: {
            labels: tiempos,
            datasets: [{
                label: 'Posición X (m)',
                data: posX,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true }},
            scales: {
                x: { title: { display: true, text: 'Tiempo (s)' }},
                y: { title: { display: true, text: 'X (m)' }}
            }
        }
    });

    // Gráfica Posición Y vs Tiempo
    const ctxPosY = document.getElementById('graficaPosY').getContext('2d');
    charts.posY = new Chart(ctxPosY, {
        type: 'line',
        data: {
            labels: tiempos,
            datasets: [{
                label: 'Posición Y (m)',
                data: posY,
                borderColor: 'rgb(168, 85, 247)',
                backgroundColor: 'rgba(168, 85, 247, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true }},
            scales: {
                x: { title: { display: true, text: 'Tiempo (s)' }},
                y: { title: { display: true, text: 'Y (m)' }, beginAtZero: true }
            }
        }
    });
}

function iniciarAnimacion(datos) {
    const canvas = document.getElementById('canvasParabolico');
    const ctx = canvas.getContext('2d');
    let indice = 0;
    animacionActiva = true;

    // Calcular escala
    const maxX = Math.max(...datos.map(d => d.x));
    const maxY = Math.max(...datos.map(d => d.y));
    const escalaX = (canvas.width - 100) / maxX;
    const escalaY = (canvas.height - 100) / maxY;
    const escala = Math.min(escalaX, escalaY);

    const animar = () => {
        if (!animacionActiva || indice >= datos.length) {
            animacionActiva = false;
            document.getElementById('estadoAnimacion').textContent = 'Estado: Completado';
            return;
        }

        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Dibujar suelo
        ctx.fillStyle = '#86efac';
        ctx.fillRect(0, canvas.height - 50, canvas.width, 50);
        
        // Dibujar línea del suelo
        ctx.strokeStyle = '#16a34a';
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(0, canvas.height - 50);
        ctx.lineTo(canvas.width, canvas.height - 50);
        ctx.stroke();

        // Dibujar trayectoria recorrida
        ctx.strokeStyle = '#22c55e';
        ctx.lineWidth = 2;
        ctx.setLineDash([5, 3]);
        ctx.beginPath();
        for (let i = 0; i <= indice; i++) {
            const x = 50 + datos[i].x * escala;
            const y = canvas.height - 50 - datos[i].y * escala;
            if (i === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        }
        ctx.stroke();
        ctx.setLineDash([]);

        // Dibujar proyectil
        const dato = datos[indice];
        const posX = 50 + dato.x * escala;
        const posY = canvas.height - 50 - dato.y * escala;
        
        // Sombra del proyectil
        ctx.fillStyle = 'rgba(0, 0, 0, 0.2)';
        ctx.beginPath();
        ctx.ellipse(50 + dato.x * escala, canvas.height - 45, 8, 3, 0, 0, Math.PI * 2);
        ctx.fill();

        // Proyectil
        ctx.fillStyle = '#ef4444';
        ctx.beginPath();
        ctx.arc(posX, posY, 10, 0, Math.PI * 2);
        ctx.fill();
        
        // Borde del proyectil
        ctx.strokeStyle = '#991b1b';
        ctx.lineWidth = 2;
        ctx.stroke();

        // Vector velocidad
        const vectorScale = 0.5;
        ctx.strokeStyle = '#3b82f6';
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(posX, posY);
        ctx.lineTo(posX + dato.vx * vectorScale, posY - dato.vy * vectorScale);
        ctx.stroke();
        
        // Punta de flecha
        const angle = Math.atan2(-dato.vy, dato.vx);
        ctx.fillStyle = '#3b82f6';
        ctx.beginPath();
        ctx.moveTo(posX + dato.vx * vectorScale, posY - dato.vy * vectorScale);
        ctx.lineTo(
            posX + dato.vx * vectorScale - 10 * Math.cos(angle - Math.PI / 6),
            posY - dato.vy * vectorScale + 10 * Math.sin(angle - Math.PI / 6)
        );
        ctx.lineTo(
            posX + dato.vx * vectorScale - 10 * Math.cos(angle + Math.PI / 6),
            posY - dato.vy * vectorScale + 10 * Math.sin(angle + Math.PI / 6)
        );
        ctx.closePath();
        ctx.fill();

        // Información
        ctx.fillStyle = '#1f2937';
        ctx.font = 'bold 14px Arial';
        ctx.fillText(`x = ${dato.x.toFixed(2)} m`, 10, 20);
        ctx.fillText(`y = ${dato.y.toFixed(2)} m`, 10, 40);
        ctx.fillText(`v = ${dato.v.toFixed(2)} m/s`, 10, 60);
        ctx.fillText(`vₓ = ${dato.vx.toFixed(2)} m/s`, 10, 80);
        ctx.fillText(`vᵧ = ${dato.vy.toFixed(2)} m/s`, 10, 100);

        // Marcadores de distancia
        ctx.fillStyle = '#6b7280';
        ctx.font = '12px Arial';
        const markerInterval = Math.ceil(maxX / 10);
        for (let i = 0; i <= maxX; i += markerInterval) {
            const x = 50 + i * escala;
            ctx.fillText(`${i}m`, x - 10, canvas.height - 30);
            ctx.strokeStyle = '#9ca3af';
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(x, canvas.height - 50);
            ctx.lineTo(x, canvas.height - 45);
            ctx.stroke();
        }

        document.getElementById('tiempoActual').textContent = `t = ${dato.t.toFixed(2)} s`;
        document.getElementById('estadoAnimacion').textContent = 'Estado: Animando...';

        indice++;
        animacionFrame = setTimeout(animar, 30);
    };

    animar();
}

document.getElementById('btnReset').addEventListener('click', () => {
    animacionActiva = false;
    if (animacionFrame) clearTimeout(animacionFrame);
    
    const canvas = document.getElementById('canvasParabolico');
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    document.getElementById('tiempoActual').textContent = 't = 0.00 s';
    document.getElementById('estadoAnimacion').textContent = 'Estado: Detenido';
    document.getElementById('panelResultados').classList.add('hidden');
    document.getElementById('panelGraficas').classList.add('hidden');
    document.getElementById('btnGuardar').disabled = true;
    datosSimulacion = null;
    
    Object.values(charts).forEach(chart => chart?.destroy());
    charts = {};
});

document.getElementById('btnExportar').addEventListener('click', () => {
    if (!datosSimulacion) return;
    
    let csv = 'Tiempo (s),Posición X (m),Posición Y (m),Velocidad X (m/s),Velocidad Y (m/s),Velocidad Total (m/s)\n';
    datosSimulacion.datos.forEach(d => {
        csv += `${d.t},${d.x},${d.y},${d.vx},${d.vy},${d.v}\n`;
    });
    
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'parabolico_simulacion.csv';
    a.click();
});

document.getElementById('btnGuardar').addEventListener('click', async () => {
    const nombre = prompt('Nombre del experimento:');
    if (!nombre) return;

    const parametros = {
        velocidad_inicial: parseFloat(document.getElementById('velocidad_inicial').value),
        angulo: parseFloat(document.getElementById('angulo').value),
        altura_inicial: parseFloat(document.getElementById('altura_inicial').value),
        gravedad: parseFloat(document.getElementById('gravedad').value),
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
                tipo: 'parabolico',
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