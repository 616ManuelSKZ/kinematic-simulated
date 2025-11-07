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
        <h1 class="text-3xl font-bold text-gray-800 mt-4">Captura con Arduino + Sensor HC-SR04</h1>
        <p class="text-gray-600">Conecta tu Arduino Uno R3 con sensor ultrasónico para capturar datos en tiempo real</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Panel de Control -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Conexión Arduino</h2>
                
                <div class="space-y-4">
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded text-sm">
                        <p class="font-semibold text-blue-900 mb-1">Estado:</p>
                        <p id="estadoConexion" class="text-blue-700">Desconectado</p>
                    </div>

                    <button id="btnConectar" onclick="conectarArduino()" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Conectar Arduino
                    </button>

                    <div id="panelConfiguracion" class="hidden space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del experimento
                            </label>
                            <input type="text" id="nombreExperimento" 
                                   placeholder="Ej: Caída libre con sensor"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Duración máxima (segundos)
                            </label>
                            <input type="number" id="duracionMax" value="30" min="5" max="300"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>

                        <button id="btnIniciarCaptura" onclick="iniciarCaptura()" disabled
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md disabled:opacity-50">
                            Iniciar Captura
                        </button>
                        
                        <button id="btnDetenerCaptura" onclick="detenerCaptura()" disabled
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-md disabled:opacity-50">
                            Detener Captura
                        </button>

                        <button id="btnGuardar" onclick="guardarExperimento()" disabled
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-md disabled:opacity-50">
                            Guardar Experimento
                        </button>
                    </div>
                </div>
            </div>

            <!-- Instrucciones -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-4 rounded">
                <h3 class="font-semibold text-blue-900 mb-3">📋 Instrucciones</h3>
                <ol class="text-sm text-blue-800 space-y-2 list-decimal list-inside">
                    <li>Carga el código en tu Arduino Uno R3</li>
                    <li>Conecta el sensor HC-SR04:
                        <ul class="ml-6 mt-1 text-xs space-y-1">
                            <li>• TRIG → Pin 9</li>
                            <li>• ECHO → Pin 10</li>
                            <li>• VCC → 5V</li>
                            <li>• GND → GND</li>
                        </ul>
                    </li>
                    <li>Conecta Arduino por USB</li>
                    <li>Click en "Conectar Arduino"</li>
                    <li>Selecciona el puerto COM</li>
                    <li>Inicia la captura</li>
                    <li>Realiza el movimiento</li>
                    <li>Analiza los datos</li>
                </ol>
            </div>

            <!-- Estado del Arduino -->
            <div class="mt-4 bg-white rounded-lg shadow p-4">
                <h3 class="font-semibold text-gray-800 mb-2">Info del Sensor</h3>
                <div class="text-sm space-y-1">
                    <p><strong>Modelo:</strong> HC-SR04</p>
                    <p><strong>Rango:</strong> 2cm - 400cm</p>
                    <p><strong>Precisión:</strong> ±3mm</p>
                    <p><strong>Frecuencia:</strong> 40kHz</p>
                </div>
            </div>
        </div>

        <!-- Visualización en Tiempo Real -->
        <div class="lg:col-span-2">
            
            <!-- Datos en Tiempo Real -->
            <div id="panelDatosRT" class="bg-white rounded-lg shadow-lg p-6 mb-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Datos en Tiempo Real</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-xs text-gray-600 mb-1">Distancia</div>
                        <div id="distanciaRT" class="text-2xl font-bold text-blue-600">0 cm</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-xs text-gray-600 mb-1">Velocidad</div>
                        <div id="velocidadRT" class="text-2xl font-bold text-green-600">0 cm/s</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-xs text-gray-600 mb-1">Aceleración</div>
                        <div id="aceleracionRT" class="text-2xl font-bold text-purple-600">0 cm/s²</div>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <div class="text-xs text-gray-600 mb-1">Muestras</div>
                        <div id="numMuestras" class="text-2xl font-bold text-orange-600">0</div>
                    </div>
                </div>

                <!-- Monitor Serial -->
                <div class="bg-gray-900 text-green-400 p-4 rounded-lg font-mono text-xs" style="height: 200px; overflow-y: auto; display: flex;" id="monitorSerial">
                    <div id="contenidoSerial"></div>
                </div>
            </div>

            <!-- Gráficas en Tiempo Real -->
            <div id="panelGraficasRT" class="bg-white rounded-lg shadow-lg p-6 mb-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Gráficas en Tiempo Real</h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="text-md font-medium mb-2">Distancia vs Tiempo</h3>
                        <canvas id="graficaDistancia" height="150"></canvas>
                    </div>
                    <div>
                        <h3 class="text-md font-medium mb-2">Velocidad vs Tiempo</h3>
                        <canvas id="graficaVelocidad" height="150"></canvas>
                    </div>
                    <div>
                        <h3 class="text-md font-medium mb-2">Aceleración vs Tiempo</h3>
                        <canvas id="graficaAceleracion" height="150"></canvas>
                    </div>
                </div>
            </div>

            <!-- Análisis Final -->
            <div id="panelAnalisis" class="bg-white rounded-lg shadow-lg p-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Análisis de Datos</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-600 mb-1">Distancia Promedio</div>
                        <div id="distProm" class="text-2xl font-bold text-blue-600">-- cm</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-600 mb-1">Velocidad Promedio</div>
                        <div id="velProm" class="text-2xl font-bold text-green-600">-- cm/s</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-600 mb-1">Aceleración Promedio</div>
                        <div id="acelProm" class="text-2xl font-bold text-purple-600">-- cm/s²</div>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button onclick="exportarCSV()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md">
                        Exportar CSV
                    </button>
                    <button onclick="compararGravedad()" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-md">
                        Comparar con g=980 cm/s²
                    </button>
                </div>

                <div id="resultadoComparacion" class="mt-4 hidden"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let puerto = null;
let lector = null;
let capturandoDatos = false;
let datosCapturados = [];
let tiempoInicio = 0;

// Gráficas
let graficaDist = null;
let graficaVel = null;
let graficaAcel = null;

async function conectarArduino() {
    if (!('serial' in navigator)) {
        alert('❌ Tu navegador no soporta Web Serial API.\n\n✓ Usa Chrome, Edge u Opera.\n✓ Asegúrate de estar en HTTPS o localhost.');
        return;
    }

    try {
        // Solicitar puerto serial
        puerto = await navigator.serial.requestPort();
        await puerto.open({ baudRate: 9600 });

        document.getElementById('estadoConexion').textContent = 'Conectado ✓';
        document.getElementById('estadoConexion').classList.add('text-green-600');
        document.getElementById('btnConectar').disabled = true;
        document.getElementById('panelConfiguracion').classList.remove('hidden');
        document.getElementById('btnIniciarCaptura').disabled = false;

        // Mensaje inicial en monitor
        const contenido = document.getElementById('contenidoSerial');
        contenido.innerHTML = '<div class="text-green-500 font-bold">✓ Arduino conectado</div><div class="text-gray-500">Esperando datos...</div>';

        // Iniciar lectura
        leerDatosSerial();

    } catch (error) {
        console.error('Error al conectar:', error);
        
        let mensaje = 'Error al conectar con Arduino: ';
        if (error.name === 'NotFoundError') {
            mensaje += 'No se seleccionó ningún puerto.';
        } else if (error.name === 'SecurityError') {
            mensaje += 'Permiso denegado. Verifica que estés en HTTPS o localhost.';
        } else {
            mensaje += error.message;
        }
        
        alert(mensaje);
    }
}

async function leerDatosSerial() {
    const decoder = new TextDecoderStream();
    puerto.readable.pipeTo(decoder.writable);
    lector = decoder.readable.getReader();

    let buffer = '';

    try {
        while (true) {
            const { value, done } = await lector.read();
            if (done) break;

            buffer += value;
            const lineas = buffer.split('\n');
            buffer = lineas.pop();

            for (const linea of lineas) {
                procesarLinea(linea.trim());
            }
        }
    } catch (error) {
        console.error('Error leyendo datos:', error);
    }
}

function procesarLinea(linea) {
    if (!linea) return;

    // Mostrar en monitor serial (nuevas líneas arriba)
    const contenido = document.getElementById('contenidoSerial');
    const div = document.createElement('div');
    div.textContent = linea;
    div.className = 'mb-1'; // Espacio entre líneas
    contenido.prepend(div); // Agregar al inicio (arriba)

    // Limitar a 100 líneas para no consumir mucha memoria
    while (contenido.children.length > 100) {
        contenido.removeChild(contenido.lastChild);
    }

    // Parsear datos si estamos capturando
    if (capturandoDatos && linea.includes('Distancia')) {
        try {
            // Extraer valores: "Distancia (cm): 25.5	Velocidad (cm/s): 10.2	Aceleracion (cm/s^2): 5.3"
            const distMatch = linea.match(/Distancia \(cm\):\s*([-\d.]+)/);
            const velMatch = linea.match(/Velocidad \(cm\/s\):\s*([-\d.]+)/);
            const acelMatch = linea.match(/Aceleracion \(cm\/s\^2\):\s*([-\d.]+)/);

            if (distMatch && velMatch && acelMatch) {
                const tiempo = (Date.now() - tiempoInicio) / 1000; // segundos
                const distancia = parseFloat(distMatch[1]);
                const velocidad = parseFloat(velMatch[1]);
                const aceleracion = parseFloat(acelMatch[1]);

                // Guardar datos
                datosCapturados.push({
                    t: parseFloat(tiempo.toFixed(3)),
                    d: parseFloat(distancia.toFixed(2)),
                    v: parseFloat(velocidad.toFixed(2)),
                    a: parseFloat(aceleracion.toFixed(2))
                });

                // Actualizar UI en tiempo real
                document.getElementById('distanciaRT').textContent = distancia.toFixed(2) + ' cm';
                document.getElementById('velocidadRT').textContent = velocidad.toFixed(2) + ' cm/s';
                document.getElementById('aceleracionRT').textContent = aceleracion.toFixed(2) + ' cm/s²';
                document.getElementById('numMuestras').textContent = datosCapturados.length;

                // Actualizar gráficas
                actualizarGraficas();
            }
        } catch (error) {
            console.error('Error parseando línea:', error);
        }
    }
}

function iniciarCaptura() {
    const nombre = document.getElementById('nombreExperimento').value;
    if (!nombre) {
        alert('Ingresa un nombre para el experimento');
        return;
    }

    capturandoDatos = true;
    datosCapturados = [];
    tiempoInicio = Date.now();

    document.getElementById('btnIniciarCaptura').disabled = true;
    document.getElementById('btnDetenerCaptura').disabled = false;
    document.getElementById('panelDatosRT').classList.remove('hidden');
    document.getElementById('panelGraficasRT').classList.remove('hidden');

    // Inicializar gráficas
    inicializarGraficas();

    // Auto-detener después de duración máxima
    const duracion = parseInt(document.getElementById('duracionMax').value) * 1000;
    setTimeout(() => {
        if (capturandoDatos) {
            detenerCaptura();
        }
    }, duracion);
}

function detenerCaptura() {
    capturandoDatos = false;

    document.getElementById('btnIniciarCaptura').disabled = false;
    document.getElementById('btnDetenerCaptura').disabled = true;

    if (datosCapturados.length > 0) {
        document.getElementById('btnGuardar').disabled = false;
        mostrarAnalisis();
    } else {
        alert('No se capturaron datos');
    }
}

function inicializarGraficas() {
    const ctxDist = document.getElementById('graficaDistancia').getContext('2d');
    const ctxVel = document.getElementById('graficaVelocidad').getContext('2d');
    const ctxAcel = document.getElementById('graficaAceleracion').getContext('2d');

    if (graficaDist) graficaDist.destroy();
    if (graficaVel) graficaVel.destroy();
    if (graficaAcel) graficaAcel.destroy();

    const configBase = {
        type: 'line',
        options: {
            responsive: true,
            animation: false,
            scales: {
                x: { title: { display: true, text: 'Tiempo (s)' }},
                y: { beginAtZero: false }
            },
            plugins: { legend: { display: false }}
        }
    };

    graficaDist = new Chart(ctxDist, {
        ...configBase,
        data: {
            labels: [],
            datasets: [{
                label: 'Distancia (cm)',
                data: [],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)'
            }]
        }
    });

    graficaVel = new Chart(ctxVel, {
        ...configBase,
        data: {
            labels: [],
            datasets: [{
                label: 'Velocidad (cm/s)',
                data: [],
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)'
            }]
        }
    });

    graficaAcel = new Chart(ctxAcel, {
        ...configBase,
        data: {
            labels: [],
            datasets: [{
                label: 'Aceleración (cm/s²)',
                data: [],
                borderColor: 'rgb(168, 85, 247)',
                backgroundColor: 'rgba(168, 85, 247, 0.1)'
            }]
        }
    });
}

function actualizarGraficas() {
    if (!graficaDist) return;

    const maxPuntos = 50; // Mostrar últimos 50 puntos
    const datos = datosCapturados.slice(-maxPuntos);

    graficaDist.data.labels = datos.map(d => d.t.toFixed(1));
    graficaDist.data.datasets[0].data = datos.map(d => d.d);
    graficaDist.update('none');

    graficaVel.data.labels = datos.map(d => d.t.toFixed(1));
    graficaVel.data.datasets[0].data = datos.map(d => d.v);
    graficaVel.update('none');

    graficaAcel.data.labels = datos.map(d => d.t.toFixed(1));
    graficaAcel.data.datasets[0].data = datos.map(d => d.a);
    graficaAcel.update('none');
}

function mostrarAnalisis() {
    document.getElementById('panelAnalisis').classList.remove('hidden');

    const distProm = datosCapturados.reduce((sum, d) => sum + d.d, 0) / datosCapturados.length;
    const velProm = datosCapturados.reduce((sum, d) => sum + d.v, 0) / datosCapturados.length;
    const acelProm = datosCapturados.reduce((sum, d) => sum + d.a, 0) / datosCapturados.length;

    document.getElementById('distProm').textContent = distProm.toFixed(2) + ' cm';
    document.getElementById('velProm').textContent = velProm.toFixed(2) + ' cm/s';
    document.getElementById('acelProm').textContent = acelProm.toFixed(2) + ' cm/s²';
}

function compararGravedad() {
    const acelProm = datosCapturados.reduce((sum, d) => sum + d.a, 0) / datosCapturados.length;
    const gTeorica = 980; // cm/s²
    const error = Math.abs((acelProm - gTeorica) / gTeorica * 100);

    const resultado = document.getElementById('resultadoComparacion');
    resultado.classList.remove('hidden');
    resultado.innerHTML = `
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 p-4 rounded-lg border border-blue-200">
            <h4 class="font-semibold text-gray-800 mb-2">Comparación con Gravedad</h4>
            <div class="space-y-2 text-sm">
                <p><strong>Aceleración medida:</strong> ${acelProm.toFixed(2)} cm/s²</p>
                <p><strong>Gravedad teórica:</strong> ${gTeorica} cm/s²</p>
                <p><strong>Error:</strong> <span class="${error < 10 ? 'text-green-600' : 'text-orange-600'} font-bold">${error.toFixed(2)}%</span></p>
                <p class="text-xs text-gray-600 mt-2">
                    ${error < 5 ? '✓ Excelente precisión' : error < 10 ? '✓ Buena precisión' : '⚠️ Revisar configuración del sensor'}
                </p>
            </div>
        </div>
    `;
}

function exportarCSV() {
    let csv = 'Tiempo (s),Distancia (cm),Velocidad (cm/s),Aceleracion (cm/s²)\n';
    datosCapturados.forEach(d => {
        csv += `${d.t},${d.d},${d.v},${d.a}\n`;
    });

    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'arduino_sensor_' + Date.now() + '.csv';
    a.click();
}

async function guardarExperimento() {
    const nombre = document.getElementById('nombreExperimento').value.trim();
    
    if (!nombre) {
        alert('Por favor ingresa un nombre para el experimento');
        document.getElementById('nombreExperimento').focus();
        return;
    }

    if (datosCapturados.length === 0) {
        alert('No hay datos capturados para guardar');
        return;
    }

    // Deshabilitar botón mientras se guarda
    const btnGuardar = document.getElementById('btnGuardar');
    const textoOriginal = btnGuardar.textContent;
    btnGuardar.textContent = 'Guardando...';
    btnGuardar.disabled = true;

    try {
        const response = await fetch('{{ route("arduino.guardar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                nombre: nombre,
                datos: datosCapturados,
                sensor: 'HC-SR04',
                arduino: 'Uno R3'
            })
        });

        const data = await response.json();

        if (response.ok && data.success) {
            alert('✓ Experimento guardado exitosamente con ' + datosCapturados.length + ' muestras');
            
            // Preguntar si quiere ir a ver el experimento
            if (confirm('¿Quieres ver el experimento guardado?')) {
                window.location.href = '{{ route("experimentos.index") }}';
            } else {
                // Resetear para nuevo experimento
                btnGuardar.textContent = textoOriginal;
                btnGuardar.disabled = false;
            }
        } else {
            throw new Error(data.message || 'Error al guardar');
        }
    } catch (error) {
        console.error('Error completo:', error);
        alert('❌ Error al guardar el experimento: ' + error.message);
        btnGuardar.textContent = textoOriginal;
        btnGuardar.disabled = false;
    }
}

// Limpiar al salir
window.addEventListener('beforeunload', async () => {
    if (lector) {
        await lector.cancel();
    }
    if (puerto) {
        await puerto.close();
    }
});
</script>
@endsection