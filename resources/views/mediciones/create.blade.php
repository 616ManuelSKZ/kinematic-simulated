@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('mediciones.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Volver a mediciones
        </a>
        <h1 class="text-3xl font-bold text-gray-800 mt-4">Análisis de Errores e Incertidumbre</h1>
        <p class="text-gray-600">Registra tus mediciones experimentales y obtén un análisis estadístico completo</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Formulario de Entrada -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6 sticky top-20">
                <h2 class="text-xl font-semibold mb-4">Datos de Medición</h2>

                <form id="formMedicion" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre del experimento
                        </label>
                        <input type="text" id="nombre"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Ej: Medición de masa del bloque" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tipo de magnitud
                        </label>
                        <select id="tipo_magnitud"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="longitud">Longitud</option>
                            <option value="tiempo">Tiempo</option>
                            <option value="masa">Masa</option>
                            <option value="velocidad">Velocidad</option>
                            <option value="aceleracion">Aceleración</option>
                            <option value="otra">Otra</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Unidad de medida
                        </label>
                        <input type="text" id="unidad"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Ej: cm, s, g, m/s" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Valor verdadero (opcional)
                        </label>
                        <input type="number" step="any" id="valor_verdadero"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Si conoces el valor real">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Mediciones (mínimo 3)
                        </label>
                        <div id="medicionesContainer" class="space-y-2">
                            <div class="flex gap-2">
                                <input type="number" step="any"
                                    class="medicion-input flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Medición 1" required>
                                <button type="button" onclick="eliminarMedicion(this)"
                                    class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 disabled:opacity-50"
                                    disabled>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex gap-2">
                                <input type="number" step="any"
                                    class="medicion-input flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Medición 2" required>
                                <button type="button" onclick="eliminarMedicion(this)"
                                    class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 disabled:opacity-50"
                                    disabled>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex gap-2">
                                <input type="number" step="any"
                                    class="medicion-input flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Medición 3" required>
                                <button type="button" onclick="eliminarMedicion(this)"
                                    class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 disabled:opacity-50"
                                    disabled>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="button" onclick="agregarMedicion()"
                            class="mt-2 w-full bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-md text-sm">
                            + Agregar medición
                        </button>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Observaciones
                        </label>
                        <textarea id="observaciones" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Condiciones experimentales, notas, etc."></textarea>
                    </div>

                    <div class="space-y-2 pt-4">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-md transition">
                            Analizar Mediciones
                        </button>
                        <button type="button" id="btnGuardar"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md transition"
                            disabled>
                            Guardar Análisis
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Resultados del Análisis -->
        <div class="lg:col-span-2">

            <!-- Estadísticas Básicas -->
            <div id="panelEstadisticas" class="bg-white rounded-lg shadow-lg p-6 mb-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Estadísticas Básicas</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-xs text-gray-600 mb-1">N° Mediciones</div>
                        <div id="nMediciones" class="text-2xl font-bold text-blue-600">--</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-xs text-gray-600 mb-1">Media</div>
                        <div id="media" class="text-2xl font-bold text-green-600">--</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-xs text-gray-600 mb-1">Desv. Estándar</div>
                        <div id="desvEstandar" class="text-2xl font-bold text-purple-600">--</div>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <div class="text-xs text-gray-600 mb-1">Rango</div>
                        <div id="rango" class="text-2xl font-bold text-orange-600">--</div>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-600">Desv. Estándar Media</div>
                        <div id="desvMedia" class="text-lg font-semibold text-gray-700">--</div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-600">Valor Máximo</div>
                        <div id="valorMax" class="text-lg font-semibold text-gray-700">--</div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-600">Valor Mínimo</div>
                        <div id="valorMin" class="text-lg font-semibold text-gray-700">--</div>
                    </div>
                </div>
            </div>

            <!-- Gráfica de Dispersión -->
            <div id="panelGrafica" class="bg-white rounded-lg shadow-lg p-6 mb-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Gráfica de Mediciones</h2>
                <canvas id="graficaMediciones" height="300"></canvas>
            </div>

            <!-- Errores Absolutos -->
            <div id="panelErrores" class="bg-white rounded-lg shadow-lg p-6 mb-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Análisis de Errores</h2>

                <div class="mb-4">
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <div class="text-sm font-medium text-blue-900">Error Absoluto Promedio</div>
                                <div id="errorAbsPromedio" class="text-lg font-bold text-blue-700">--</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Medición
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Error
                                    Absoluto</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                    id="headerErrorRel" style="display:none">Error Relativo (%)</th>
                            </tr>
                        </thead>
                        <tbody id="tablaErrores" class="bg-white divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Incertidumbre -->
            <div id="panelIncertidumbre" class="bg-white rounded-lg shadow-lg p-6 mb-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Incertidumbre (Tipo A)</h2>

                <div class="space-y-4">
                    <div class="bg-gradient-to-r from-green-50 to-blue-50 p-4 rounded-lg border border-green-200">
                        <h3 class="font-semibold text-gray-800 mb-2">Resultado Final</h3>
                        <div class="flex items-baseline gap-2">
                            <span class="text-sm text-gray-600">Valor con incertidumbre (95%):</span>
                            <span id="resultadoFinal" class="text-xl font-bold text-green-700">--</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600 mb-1">Incertidumbre Estándar</div>
                            <div id="incertidumbreEstandar" class="text-lg font-semibold text-gray-800">--</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600 mb-1">Inc. Expandida (68%)</div>
                            <div id="incertidumbreExp68" class="text-lg font-semibold text-gray-800">--</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600 mb-1">Inc. Expandida (95%)</div>
                            <div id="incertidumbreExp95" class="text-lg font-semibold text-gray-800">--</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600 mb-1">Valor Medio</div>
                            <div id="valorMedio" class="text-lg font-semibold text-gray-800">--</div>
                        </div>
                    </div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                        <p class="text-sm text-gray-700">
                            <strong>Interpretación:</strong> Con un nivel de confianza del 95%, el valor verdadero se
                            encuentra en el intervalo mostrado arriba.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Propagación de Incertidumbre -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Propagación de Incertidumbre</h2>

                <form id="formPropagacion" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Operación
                        </label>
                        <select id="operacion"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="suma">Suma (z = x + y)</option>
                            <option value="resta">Resta (z = x - y)</option>
                            <option value="multiplicacion">Multiplicación (z = x × y)</option>
                            <option value="division">División (z = x / y)</option>
                            <option value="potencia">Potencia (z = x^n)</option>
                        </select>
                    </div>

                    <div id="variablesContainer">
                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Variable X (valor)</label>
                                <input type="number" step="any"
                                    class="var-valor w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Incertidumbre δx</label>
                                <input type="number" step="any"
                                    class="var-incertidumbre w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-3" id="varY">
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Variable Y (valor)</label>
                                <input type="number" step="any"
                                    class="var-valor w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Incertidumbre δy</label>
                                <input type="number" step="any"
                                    class="var-incertidumbre w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                            </div>
                        </div>
                        <div class="mb-3" id="exponente" style="display:none">
                            <label class="block text-xs text-gray-600 mb-1">Exponente (n)</label>
                            <input type="number" step="any" id="expInput"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-md">
                        Calcular Propagación
                    </button>
                </form>

                <div id="resultadoPropagacion" class="mt-4 hidden">
                    <div class="bg-purple-50 border border-purple-200 p-4 rounded-lg">
                        <h3 class="font-semibold text-gray-800 mb-2">Resultado de la Propagación</h3>
                        <div id="resultadoProp" class="text-lg font-bold text-purple-700"></div>
                        <div id="errorRelativoProp" class="text-sm text-gray-600 mt-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tipoSelect = document.getElementById('tipo_magnitud');
    const unidadContainer = document.getElementById('unidad').parentElement;

    const unidadesPorMagnitud = {
        longitud: ['m', 'cm', 'mm', 'km'],
        tiempo: ['s', 'min', 'h', 'ms'],
        masa: ['kg', 'g', 'mg', 'lb'],
        velocidad: ['m/s', 'km/h', 'cm/s'],
        aceleracion: ['m/s²', 'cm/s²'],
        otra: []
    };

    function renderCampoUnidad(tipo) {
        // 🔹 Eliminar cualquier campo anterior (input o select)
        const existente = unidadContainer.querySelector('#unidad');
        if (existente) existente.remove();

        const unidades = unidadesPorMagnitud[tipo] || [];

        if (unidades.length > 0) {
            // Crear select con opciones
            const select = document.createElement('select');
            select.id = 'unidad';
            select.required = true;
            select.className = 'w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500';

            unidades.forEach(u => {
                const opt = document.createElement('option');
                opt.value = u;
                opt.textContent = u;
                select.appendChild(opt);
            });

            const optOtra = document.createElement('option');
            optOtra.value = 'otra';
            optOtra.textContent = 'Otra (escribir manualmente)';
            select.appendChild(optOtra);

            unidadContainer.appendChild(select);

            // Si selecciona "otra", volver a input
            select.addEventListener('change', () => {
                if (select.value === 'otra') {
                    renderCampoUnidad('otra');
                }
            });

        } else {
            // Campo libre (input)
            const input = document.createElement('input');
            input.type = 'text';
            input.id = 'unidad';
            input.required = true;
            input.placeholder = 'Ej: cm, s, g, m/s';
            input.className = 'w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500';
            unidadContainer.appendChild(input);
        }
    }

    // Detectar cambios de tipo
    tipoSelect.addEventListener('change', () => {
        renderCampoUnidad(tipoSelect.value);
    });

    // 🔹 Inicializar al cargar (mostrar select correspondiente)
    renderCampoUnidad(tipoSelect.value);
});
</script>

<script>
let analisisActual = null;
let graficaChart = null;

// Agregar nueva medición
function agregarMedicion() {
    const container = document.getElementById('medicionesContainer');
    const count = container.querySelectorAll('.medicion-input').length + 1;

    const div = document.createElement('div');
    div.className = 'flex gap-2';
    div.innerHTML = `
        <input type="number" step="any" class="medicion-input flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
               placeholder="Medición ${count}" required>
        <button type="button" onclick="eliminarMedicion(this)" class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </button>
    `;
    container.appendChild(div);
    actualizarBotonesEliminar();
}

// Eliminar medición
function eliminarMedicion(btn) {
    const container = document.getElementById('medicionesContainer');
    if (container.querySelectorAll('.medicion-input').length > 3) {
        btn.parentElement.remove();
        actualizarBotonesEliminar();
        // Renumerar placeholders
        container.querySelectorAll('.medicion-input').forEach((input, i) => {
            input.placeholder = `Medición ${i + 1}`;
        });
    }
}

function actualizarBotonesEliminar() {
    const container = document.getElementById('medicionesContainer');
    const botones = container.querySelectorAll('button[onclick^="eliminarMedicion"]');
    const numMediciones = container.querySelectorAll('.medicion-input').length;

    botones.forEach(btn => {
        btn.disabled = numMediciones <= 3;
    });
}

// Cambiar operación en propagación
document.getElementById('operacion').addEventListener('change', (e) => {
    const varY = document.getElementById('varY');
    const exponente = document.getElementById('exponente');

    if (e.target.value === 'potencia') {
        varY.style.display = 'none';
        exponente.style.display = 'block';
    } else {
        varY.style.display = 'grid';
        exponente.style.display = 'none';
    }
});

// Analizar mediciones
document.getElementById('formMedicion').addEventListener('submit', async (e) => {
    e.preventDefault();

    const valores = Array.from(document.querySelectorAll('.medicion-input'))
        .map(input => parseFloat(input.value))
        .filter(v => !isNaN(v));

    if (valores.length < 3) {
        alert('Se requieren mínimo 3 mediciones');
        return;
    }

    const valorVerdadero = document.getElementById('valor_verdadero').value;
    const unidad = document.getElementById('unidad').value;

    try {
        const response = await fetch('{{ route("mediciones.analizar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                valores: valores,
                valor_verdadero: valorVerdadero || null,
                unidad: unidad
            })
        });

        const data = await response.json();
        analisisActual = data.analisis;

        mostrarEstadisticas(data.analisis.estadisticas, unidad);
        mostrarErrores(data.analisis.error_absoluto, data.analisis.error_relativo, unidad);
        mostrarIncertidumbre(data.analisis.incertidumbre, unidad);
        crearGrafica(data.grafica, unidad);

        document.getElementById('btnGuardar').disabled = false;

    } catch (error) {
        console.error('Error:', error);
        alert('Error al analizar las mediciones');
    }
});

function mostrarEstadisticas(stats, unidad) {
    document.getElementById('panelEstadisticas').classList.remove('hidden');
    document.getElementById('nMediciones').textContent = stats.n_mediciones;
    document.getElementById('media').textContent = stats.media + ' ' + unidad;
    document.getElementById('desvEstandar').textContent = stats.desviacion_estandar + ' ' + unidad;
    document.getElementById('rango').textContent = stats.rango + ' ' + unidad;
    document.getElementById('desvMedia').textContent = stats.desviacion_estandar_media + ' ' + unidad;
    document.getElementById('valorMax').textContent = stats.valor_maximo + ' ' + unidad;
    document.getElementById('valorMin').textContent = stats.valor_minimo + ' ' + unidad;
}

function mostrarErrores(errorAbs, errorRel, unidad) {
    document.getElementById('panelErrores').classList.remove('hidden');
    document.getElementById('errorAbsPromedio').textContent = errorAbs.error_absoluto_promedio + ' ' + unidad;

    const tbody = document.getElementById('tablaErrores');
    tbody.innerHTML = '';

    const tieneErrorRel = errorRel !== undefined;
    document.getElementById('headerErrorRel').style.display = tieneErrorRel ? '' : 'none';

    errorAbs.errores.forEach((error, i) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="px-4 py-3 text-sm text-gray-900">${error.medicion}</td>
            <td class="px-4 py-3 text-sm text-gray-900">${error.valor} ${unidad}</td>
            <td class="px-4 py-3 text-sm text-gray-900">${error.error_absoluto} ${unidad}</td>
            ${tieneErrorRel ? `<td class="px-4 py-3 text-sm text-gray-900">${errorRel.errores[i].error_relativo}%</td>` : ''}
        `;
        tbody.appendChild(tr);
    });
}

function mostrarIncertidumbre(inc, unidad) {
    document.getElementById('panelIncertidumbre').classList.remove('hidden');
    document.getElementById('resultadoFinal').textContent = inc.resultado_con_incertidumbre_95 + ' ' + unidad;
    document.getElementById('incertidumbreEstandar').textContent = inc.incertidumbre_estandar + ' ' + unidad;
    document.getElementById('incertidumbreExp68').textContent = inc.incertidumbre_expandida_68 + ' ' + unidad;
    document.getElementById('incertidumbreExp95').textContent = inc.incertidumbre_expandida_95 + ' ' + unidad;
    document.getElementById('valorMedio').textContent = inc.valor_medio + ' ' + unidad;
}

function crearGrafica(datos, unidad) {
    document.getElementById('panelGrafica').classList.remove('hidden');

    const ctx = document.getElementById('graficaMediciones').getContext('2d');
    if (graficaChart) graficaChart.destroy();

    const mediciones = datos.map(d => d.y);
    const media = datos[0].media;
    const limSup = datos[0].limite_superior;
    const limInf = datos[0].limite_inferior;

    graficaChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: datos.map(d => 'Med ' + d.x),
            datasets: [{
                    label: 'Mediciones',
                    data: mediciones,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    type: 'scatter'
                },
                {
                    label: 'Media',
                    data: Array(datos.length).fill(media),
                    borderColor: 'rgb(34, 197, 94)',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    pointRadius: 0
                },
                {
                    label: 'Lím. Superior (σ)',
                    data: Array(datos.length).fill(limSup),
                    borderColor: 'rgb(239, 68, 68)',
                    borderWidth: 1,
                    borderDash: [2, 2],
                    pointRadius: 0
                },
                {
                    label: 'Lím. Inferior (σ)',
                    data: Array(datos.length).fill(limInf),
                    borderColor: 'rgb(239, 68, 68)',
                    borderWidth: 1,
                    borderDash: [2, 2],
                    pointRadius: 0
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    callbacks: {
                        label: (context) => context.dataset.label + ': ' + context.parsed.y.toFixed(4) + ' ' +
                            unidad
                    }
                }
            },
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Valor (' + unidad + ')'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'N° Medición'
                    }
                }
            }
        }
    });
}

// Guardar análisis
document.getElementById('btnGuardar').addEventListener('click', async () => {
    if (!analisisActual) return;

    const valores = Array.from(document.querySelectorAll('.medicion-input'))
        .map(input => parseFloat(input.value))
        .filter(v => !isNaN(v));

    const datos = {
        nombre: document.getElementById('nombre').value,
        tipo_magnitud: document.getElementById('tipo_magnitud').value,
        unidad: document.getElementById('unidad').value,
        valores: valores,
        valor_verdadero: document.getElementById('valor_verdadero').value || null,
        observaciones: document.getElementById('observaciones').value
    };

    try {
        const response = await fetch('{{ route("mediciones.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(datos)
        });

        if (response.redirected) {
            window.location.href = response.url;
            return;
        }

        const result = await response.json();
        if (result.redirect) {
            window.location.href = result.redirect;
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al guardar el análisis');
    }

});

// Propagar incertidumbre
document.getElementById('formPropagacion').addEventListener('submit', async (e) => {
    e.preventDefault();

    const operacion = document.getElementById('operacion').value;
    const valores = Array.from(document.querySelectorAll('.var-valor')).map(i => parseFloat(i.value));
    const incertidumbres = Array.from(document.querySelectorAll('.var-incertidumbre')).map(i => parseFloat(i
        .value));

    const variables = [];

    if (operacion === 'potencia') {
        const exp = parseFloat(document.getElementById('expInput').value);
        variables.push({
            valor: valores[0],
            incertidumbre: incertidumbres[0],
            exponente: exp
        });
    } else {
        variables.push({
            valor: valores[0],
            incertidumbre: incertidumbres[0]
        });
        variables.push({
            valor: valores[1],
            incertidumbre: incertidumbres[1]
        });
    }

    try {
        const response = await fetch('{{ route("mediciones.propagar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                operacion,
                variables
            })
        });

        const data = await response.json();

        if (data.resultado) {
            document.getElementById('resultadoPropagacion').classList.remove('hidden');
            document.getElementById('resultadoProp').textContent = data.resultado.resultado_completo;

            if (data.resultado.error_relativo) {
                document.getElementById('errorRelativoProp').textContent =
                    `Error relativo: ${data.resultado.error_relativo}%`;
            } else {
                document.getElementById('errorRelativoProp').textContent = '';
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error en la propagación de incertidumbre');
    }
});

// Inicializar
actualizarBotonesEliminar();
</script>
@endsection