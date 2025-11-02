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
        <h1 class="text-3xl font-bold text-gray-800 mt-4">Rastreador de Movimiento con Cámara</h1>
        <p class="text-gray-600">Usa tu cámara para capturar y analizar movimiento en tiempo real</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Panel de Control -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Configuración</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tipo de análisis
                        </label>
                        <select id="tipoAnalisis" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            <option value="caida_libre">Caída Libre (MRUV)</option>
                            <option value="parabolico">Lanzamiento Parabólico</option>
                            <option value="horizontal">Movimiento Horizontal (MRU)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Color a rastrear
                        </label>
                        <div class="grid grid-cols-3 gap-2">
                            <button onclick="setColorRastreo('rojo')" class="bg-red-500 hover:bg-red-600 text-white py-2 rounded">Rojo</button>
                            <button onclick="setColorRastreo('verde')" class="bg-green-500 hover:bg-green-600 text-white py-2 rounded">Verde</button>
                            <button onclick="setColorRastreo('azul')" class="bg-blue-500 hover:bg-blue-600 text-white py-2 rounded">Azul</button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Escala (cm/pixel)
                        </label>
                        <input type="number" step="0.01" id="escala" value="1" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md"
                               placeholder="Ej: 0.5 si 1 pixel = 0.5 cm">
                        <p class="text-xs text-gray-500 mt-1">Usa un objeto de referencia para calibrar</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            FPS para análisis
                        </label>
                        <input type="number" id="fps" value="30" min="10" max="60"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div class="pt-4 space-y-2">
                        <button id="btnIniciarCamara" onclick="iniciarCamara()" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-md">
                            <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Iniciar Cámara
                        </button>
                        <button id="btnIniciarRastreo" onclick="iniciarRastreo()" disabled
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md disabled:opacity-50">
                            Iniciar Rastreo
                        </button>
                        <button id="btnDetener" onclick="detenerRastreo()" disabled
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-md disabled:opacity-50">
                            Detener
                        </button>
                        <button id="btnGuardarDatos" onclick="guardarDatos()" disabled
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-md disabled:opacity-50">
                            Guardar como Experimento
                        </button>
                    </div>
                </div>
            </div>

            <!-- Instrucciones -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <h3 class="font-semibold text-blue-900 mb-2">📋 Instrucciones</h3>
                <ol class="text-sm text-blue-800 space-y-1 list-decimal list-inside">
                    <li>Permite acceso a la cámara</li>
                    <li>Coloca un objeto de color visible</li>
                    <li>Calibra la escala con objeto conocido</li>
                    <li>Inicia rastreo y realiza movimiento</li>
                    <li>Analiza los datos capturados</li>
                </ol>
            </div>
        </div>

        <!-- Vista de Cámara y Análisis -->
        <div class="lg:col-span-2">
            <!-- Video de Cámara -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Vista de Cámara</h2>
                <div class="relative">
                    <video id="videoInput" autoplay playsinline class="w-full rounded-lg border border-gray-300 hidden"></video>
                    <canvas id="canvasOutput" class="w-full rounded-lg border border-gray-300"></canvas>
                    <div id="estadoCamara" class="mt-2 text-sm text-gray-600">
                        Cámara detenida
                    </div>
                </div>
            </div>

            <!-- Datos en Tiempo Real -->
            <div id="panelDatos" class="bg-white rounded-lg shadow-lg p-6 mb-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Datos en Tiempo Real</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-600">Posición X</div>
                        <div id="posX" class="text-xl font-bold text-blue-600">0 cm</div>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-600">Posición Y</div>
                        <div id="posY" class="text-xl font-bold text-green-600">0 cm</div>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-600">Velocidad</div>
                        <div id="velocidad" class="text-xl font-bold text-purple-600">0 cm/s</div>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-600">Puntos</div>
                        <div id="numPuntos" class="text-xl font-bold text-orange-600">0</div>
                    </div>
                </div>
            </div>

            <!-- Gráfica de Trayectoria -->
            <div id="panelGrafica" class="bg-white rounded-lg shadow-lg p-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Trayectoria Capturada</h2>
                <canvas id="graficaTrayectoria" height="300"></canvas>
                <div class="mt-4">
                    <button onclick="analizarDatos()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md">
                        Analizar con IA
                    </button>
                    <button onclick="exportarCSV()" class="ml-2 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-md">
                        Exportar CSV
                    </button>
                </div>
            </div>

            <!-- Resultados del Análisis -->
            <div id="panelResultados" class="bg-white rounded-lg shadow-lg p-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Análisis de Movimiento</h2>
                <div id="resultadosContenido"></div>
            </div>
        </div>
    </div>
</div>

<!-- Cargar OpenCV.js -->
<script async src="https://docs.opencv.org/4.x/opencv.js" onload="onOpenCvReady();" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let videoStream = null;
let isOpenCvReady = false;
let rastreoActivo = false;
let datosCapturados = [];
let colorRastreo = 'rojo';
let ultimoTiempo = 0;
let grafica = null;

// Configuración de colores HSV para rastreo
const coloresHSV = {
    rojo: { lower: [0, 100, 100], upper: [10, 255, 255] },
    verde: { lower: [40, 40, 40], upper: [80, 255, 255] },
    azul: { lower: [100, 100, 100], upper: [130, 255, 255] }
};

function onOpenCvReady() {
    isOpenCvReady = true;
    console.log('✅ OpenCV.js cargado correctamente');
}

function setColorRastreo(color) {
    colorRastreo = color;
    document.querySelectorAll('button[onclick^="setColorRastreo"]').forEach(btn => {
        btn.classList.remove('ring-4', 'ring-offset-2');
    });
    event.target.classList.add('ring-4', 'ring-offset-2');
}

async function iniciarCamara() {
    if (!isOpenCvReady) {
        alert('OpenCV.js aún no está cargado. Espera un momento...');
        return;
    }

    try {
        videoStream = await navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: 'environment', // Cámara trasera en móviles
                width: { ideal: 1280 },
                height: { ideal: 720 }
            }
        });

        const video = document.getElementById('videoInput');
        video.srcObject = videoStream;
        video.onloadedmetadata = () => {
            video.play();
            procesarVideo();
        };

        document.getElementById('estadoCamara').textContent = 'Cámara activa';
        document.getElementById('btnIniciarCamara').disabled = true;
        document.getElementById('btnIniciarRastreo').disabled = false;

    } catch (error) {
        console.error('Error al acceder a la cámara:', error);
        alert('No se pudo acceder a la cámara. Verifica los permisos.');
    }
}

function procesarVideo() {
    const video = document.getElementById('videoInput');
    const canvas = document.getElementById('canvasOutput');
    const ctx = canvas.getContext('2d');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    function procesar() {
        if (!videoStream) return;

        try {
            // Capturar frame del video
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            if (rastreoActivo && isOpenCvReady) {
                rastrearObjeto(canvas, ctx);
            }

        } catch (error) {
            console.error('Error en procesamiento:', error);
        }

        requestAnimationFrame(procesar);
    }

    procesar();
}

function rastrearObjeto(canvas, ctx) {
    try {
        const src = cv.imread(canvas);
        const hsv = new cv.Mat();
        const mask = new cv.Mat();
        const contours = new cv.MatVector();
        const hierarchy = new cv.Mat();

        // Convertir a HSV
        cv.cvtColor(src, hsv, cv.COLOR_RGBA2RGB);
        cv.cvtColor(hsv, hsv, cv.COLOR_RGB2HSV);

        // Crear máscara del color seleccionado
        const lower = new cv.Mat(hsv.rows, hsv.cols, hsv.type(), coloresHSV[colorRastreo].lower);
        const upper = new cv.Mat(hsv.rows, hsv.cols, hsv.type(), coloresHSV[colorRastreo].upper);
        cv.inRange(hsv, lower, upper, mask);

        // Encontrar contornos
        cv.findContours(mask, contours, hierarchy, cv.RETR_EXTERNAL, cv.CHAIN_APPROX_SIMPLE);

        if (contours.size() > 0) {
            // Encontrar el contorno más grande
            let maxArea = 0;
            let maxContour = null;

            for (let i = 0; i < contours.size(); i++) {
                const area = cv.contourArea(contours.get(i));
                if (area > maxArea && area > 100) { // Filtrar ruido
                    maxArea = area;
                    maxContour = contours.get(i);
                }
            }

            if (maxContour) {
                // Calcular centro del objeto
                const moments = cv.moments(maxContour);
                const cx = moments.m10 / moments.m00;
                const cy = moments.m01 / moments.m00;

                // Dibujar en canvas
                ctx.beginPath();
                ctx.arc(cx, cy, 10, 0, 2 * Math.PI);
                ctx.fillStyle = colorRastreo;
                ctx.fill();
                ctx.strokeStyle = 'white';
                ctx.lineWidth = 2;
                ctx.stroke();

                // Guardar datos
                const tiempoActual = Date.now();
                const dt = (tiempoActual - ultimoTiempo) / 1000; // en segundos
                
                if (ultimoTiempo > 0 && dt > 0) {
                    const escala = parseFloat(document.getElementById('escala').value);
                    const x = cx * escala;
                    const y = (canvas.height - cy) * escala; // Invertir Y

                    // Calcular velocidad si hay punto anterior
                    let vx = 0, vy = 0;
                    if (datosCapturados.length > 0) {
                        const anterior = datosCapturados[datosCapturados.length - 1];
                        vx = (x - anterior.x) / dt;
                        vy = (y - anterior.y) / dt;
                    }

                    datosCapturados.push({
                        t: datosCapturados.length * dt,
                        x: parseFloat(x.toFixed(2)),
                        y: parseFloat(y.toFixed(2)),
                        vx: parseFloat(vx.toFixed(2)),
                        vy: parseFloat(vy.toFixed(2))
                    });

                    // Actualizar UI
                    document.getElementById('posX').textContent = x.toFixed(2) + ' cm';
                    document.getElementById('posY').textContent = y.toFixed(2) + ' cm';
                    document.getElementById('velocidad').textContent = Math.sqrt(vx*vx + vy*vy).toFixed(2) + ' cm/s';
                    document.getElementById('numPuntos').textContent = datosCapturados.length;
                }

                ultimoTiempo = tiempoActual;
            }
        }

        // Liberar memoria
        src.delete();
        hsv.delete();
        mask.delete();
        lower.delete();
        upper.delete();
        contours.delete();
        hierarchy.delete();

    } catch (error) {
        console.error('Error en rastreo:', error);
    }
}

function iniciarRastreo() {
    rastreoActivo = true;
    datosCapturados = [];
    ultimoTiempo = Date.now();
    
    document.getElementById('btnIniciarRastreo').disabled = true;
    document.getElementById('btnDetener').disabled = false;
    document.getElementById('panelDatos').classList.remove('hidden');
    document.getElementById('estadoCamara').textContent = 'Rastreando movimiento...';
}

function detenerRastreo() {
    rastreoActivo = false;
    
    document.getElementById('btnIniciarRastreo').disabled = false;
    document.getElementById('btnDetener').disabled = true;
    document.getElementById('estadoCamara').textContent = 'Rastreo detenido';

    if (datosCapturados.length > 5) {
        document.getElementById('btnGuardarDatos').disabled = false;
        mostrarGrafica();
    } else {
        alert('Se necesitan al menos 5 puntos para análisis');
    }
}

function mostrarGrafica() {
    document.getElementById('panelGrafica').classList.remove('hidden');
    
    const ctx = document.getElementById('graficaTrayectoria').getContext('2d');
    
    if (grafica) grafica.destroy();
    
    grafica = new Chart(ctx, {
        type: 'scatter',
        data: {
            datasets: [{
                label: 'Trayectoria',
                data: datosCapturados.map(d => ({x: d.x, y: d.y})),
                backgroundColor: 'rgb(59, 130, 246)',
                borderColor: 'rgb(59, 130, 246)',
                showLine: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                x: { 
                    title: { display: true, text: 'Posición X (cm)' }
                },
                y: { 
                    title: { display: true, text: 'Posición Y (cm)' }
                }
            }
        }
    });
}

function analizarDatos() {
    const tipo = document.getElementById('tipoAnalisis').value;
    let resultado = '';

    if (tipo === 'caida_libre') {
        // Analizar MRUV vertical
        const resultado_analisis = analizarMRUV();
        resultado = `
            <div class="space-y-4">
                <h3 class="font-semibold text-lg">Caída Libre (MRUV)</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 p-4 rounded">
                        <div class="text-sm text-gray-600">Aceleración</div>
                        <div class="text-2xl font-bold">${resultado_analisis.a.toFixed(2)} cm/s²</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded">
                        <div class="text-sm text-gray-600">Velocidad Inicial</div>
                        <div class="text-2xl font-bold">${resultado_analisis.v0.toFixed(2)} cm/s</div>
                    </div>
                </div>
                <p class="text-sm text-gray-600">Gravedad teórica: 980 cm/s². Error: ${Math.abs((resultado_analisis.a - 980)/980*100).toFixed(2)}%</p>
            </div>
        `;
    }

    document.getElementById('panelResultados').classList.remove('hidden');
    document.getElementById('resultadosContenido').innerHTML = resultado;
}

function analizarMRUV() {
    // Regresión cuadrática simple para y = v0*t + 0.5*a*t^2
    const n = datosCapturados.length;
    let sumT = 0, sumT2 = 0, sumT3 = 0, sumT4 = 0;
    let sumY = 0, sumTY = 0, sumT2Y = 0;

    datosCapturados.forEach(d => {
        const t = d.t;
        const y = d.y;
        sumT += t;
        sumT2 += t * t;
        sumT3 += t * t * t;
        sumT4 += t * t * t * t;
        sumY += y;
        sumTY += t * y;
        sumT2Y += t * t * y;
    });

    // Resolver sistema de ecuaciones (simplificado)
    const a = (2 * (n * sumT2Y - sumT2 * sumY)) / (n * sumT4 - sumT2 * sumT2);
    const v0 = (sumTY - 0.5 * a * sumT3) / sumT2;

    return { a, v0 };
}

function exportarCSV() {
    let csv = 'Tiempo (s),Posición X (cm),Posición Y (cm),Velocidad X (cm/s),Velocidad Y (cm/s)\n';
    datosCapturados.forEach(d => {
        csv += `${d.t},${d.x},${d.y},${d.vx},${d.vy}\n`;
    });

    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'rastreo_opencv_' + Date.now() + '.csv';
    a.click();
}

async function guardarDatos() {
    const nombre = prompt('Nombre del experimento:');
    if (!nombre) return;

    const tipo = document.getElementById('tipoAnalisis').value;
    
    try {
        const response = await fetch('{{ route("opencv.guardar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                nombre: nombre,
                tipo: tipo,
                datos: datosCapturados,
                escala: document.getElementById('escala').value,
                color_rastreado: colorRastreo
            })
        });

        if (response.ok) {
            alert('Experimento guardado exitosamente');
            window.location.href = '{{ route("experimentos.index") }}';
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al guardar el experimento');
    }
}

// Limpiar al salir
window.addEventListener('beforeunload', () => {
    if (videoStream) {
        videoStream.getTracks().forEach(track => track.stop());
    }
});
</script>
@endsection