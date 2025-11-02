<?php

namespace App\Services;

class ErrorAnalisisService
{
    /**
     * Calcula estadísticas básicas de un conjunto de mediciones
     */
    public function calcularEstadisticas(array $mediciones): array
    {
        $n = count($mediciones);
        
        if ($n === 0) {
            throw new \InvalidArgumentException('Se requiere al menos una medición');
        }

        // Media aritmética
        $media = array_sum($mediciones) / $n;

        // Desviación estándar
        $varianza = 0;
        foreach ($mediciones as $valor) {
            $varianza += pow($valor - $media, 2);
        }
        $desviacion_estandar = sqrt($varianza / $n);

        // Desviación estándar de la media
        $desviacion_media = $desviacion_estandar / sqrt($n);

        // Valor máximo y mínimo
        $max = max($mediciones);
        $min = min($mediciones);
        $rango = $max - $min;

        return [
            'n_mediciones' => $n,
            'media' => round($media, 6),
            'desviacion_estandar' => round($desviacion_estandar, 6),
            'desviacion_estandar_media' => round($desviacion_media, 6),
            'valor_maximo' => round($max, 6),
            'valor_minimo' => round($min, 6),
            'rango' => round($rango, 6)
        ];
    }

    /**
     * Calcula error absoluto para cada medición respecto al valor verdadero
     */
    public function calcularErrorAbsoluto(array $mediciones, float $valor_verdadero = null): array
    {
        $estadisticas = $this->calcularEstadisticas($mediciones);
        $valor_referencia = $valor_verdadero ?? $estadisticas['media'];

        $errores = [];
        foreach ($mediciones as $index => $medicion) {
            $error_abs = abs($medicion - $valor_referencia);
            $errores[] = [
                'medicion' => $index + 1,
                'valor' => round($medicion, 6),
                'error_absoluto' => round($error_abs, 6)
            ];
        }

        $error_absoluto_promedio = array_sum(array_column($errores, 'error_absoluto')) / count($errores);

        return [
            'errores' => $errores,
            'error_absoluto_promedio' => round($error_absoluto_promedio, 6),
            'valor_referencia' => round($valor_referencia, 6)
        ];
    }

    /**
     * Calcula error relativo (en porcentaje)
     */
    public function calcularErrorRelativo(array $mediciones, float $valor_verdadero = null): array
    {
        $estadisticas = $this->calcularEstadisticas($mediciones);
        $valor_referencia = $valor_verdadero ?? $estadisticas['media'];

        if ($valor_referencia == 0) {
            throw new \InvalidArgumentException('El valor de referencia no puede ser cero para calcular error relativo');
        }

        $errores = [];
        foreach ($mediciones as $index => $medicion) {
            $error_abs = abs($medicion - $valor_referencia);
            $error_rel = ($error_abs / abs($valor_referencia)) * 100;
            
            $errores[] = [
                'medicion' => $index + 1,
                'valor' => round($medicion, 6),
                'error_absoluto' => round($error_abs, 6),
                'error_relativo' => round($error_rel, 4) // en porcentaje
            ];
        }

        $error_relativo_promedio = array_sum(array_column($errores, 'error_relativo')) / count($errores);

        return [
            'errores' => $errores,
            'error_relativo_promedio' => round($error_relativo_promedio, 4),
            'valor_referencia' => round($valor_referencia, 6)
        ];
    }

    /**
     * Calcula incertidumbre tipo A (estadística)
     */
    public function calcularIncertidumbreTipoA(array $mediciones): array
    {
        $estadisticas = $this->calcularEstadisticas($mediciones);

        // Nivel de confianza del 95% (k=2 aproximadamente)
        $factor_cobertura_95 = 2;
        $incertidumbre_expandida_95 = $estadisticas['desviacion_estandar_media'] * $factor_cobertura_95;

        // Nivel de confianza del 68% (k=1)
        $factor_cobertura_68 = 1;
        $incertidumbre_expandida_68 = $estadisticas['desviacion_estandar_media'] * $factor_cobertura_68;

        return [
            'incertidumbre_estandar' => round($estadisticas['desviacion_estandar_media'], 6),
            'incertidumbre_expandida_68' => round($incertidumbre_expandida_68, 6),
            'incertidumbre_expandida_95' => round($incertidumbre_expandida_95, 6),
            'valor_medio' => round($estadisticas['media'], 6),
            'resultado_con_incertidumbre_95' => round($estadisticas['media'], 6) . ' ± ' . round($incertidumbre_expandida_95, 6),
            'resultado_con_incertidumbre_68' => round($estadisticas['media'], 6) . ' ± ' . round($incertidumbre_expandida_68, 6)
        ];
    }

    /**
     * Propagación de incertidumbre para operaciones básicas
     */
    public function propagarIncertidumbre(string $operacion, array $variables): array
    {
        // variables = [['valor' => x, 'incertidumbre' => δx], ['valor' => y, 'incertidumbre' => δy], ...]
        
        switch ($operacion) {
            case 'suma':
            case 'resta':
                return $this->propagacionSumaResta($variables);
            
            case 'multiplicacion':
            case 'division':
                return $this->propagacionMultiplicacionDivision($variables);
            
            case 'potencia':
                return $this->propagacionPotencia($variables);
            
            default:
                throw new \InvalidArgumentException('Operación no soportada');
        }
    }

    /**
     * Propagación para suma y resta: δz = √(δx² + δy²)
     */
    private function propagacionSumaResta(array $variables): array
    {
        $valores = array_column($variables, 'valor');
        $incertidumbres = array_column($variables, 'incertidumbre');

        $resultado = array_sum($valores);
        
        $suma_cuadrados = 0;
        foreach ($incertidumbres as $inc) {
            $suma_cuadrados += pow($inc, 2);
        }
        
        $incertidumbre_resultado = sqrt($suma_cuadrados);

        return [
            'resultado' => round($resultado, 6),
            'incertidumbre' => round($incertidumbre_resultado, 6),
            'resultado_completo' => round($resultado, 6) . ' ± ' . round($incertidumbre_resultado, 6)
        ];
    }

    /**
     * Propagación para multiplicación y división: (δz/z)² = (δx/x)² + (δy/y)²
     */
    private function propagacionMultiplicacionDivision(array $variables): array
    {
        $resultado = 1;
        $suma_errores_relativos_cuadrados = 0;

        foreach ($variables as $var) {
            $valor = $var['valor'];
            $inc = $var['incertidumbre'];
            
            if ($valor == 0) {
                throw new \InvalidArgumentException('No se puede propagar incertidumbre con valores de cero');
            }

            $resultado *= $valor;
            $error_relativo = $inc / abs($valor);
            $suma_errores_relativos_cuadrados += pow($error_relativo, 2);
        }

        $error_relativo_resultado = sqrt($suma_errores_relativos_cuadrados);
        $incertidumbre_resultado = abs($resultado) * $error_relativo_resultado;

        return [
            'resultado' => round($resultado, 6),
            'incertidumbre' => round($incertidumbre_resultado, 6),
            'error_relativo' => round($error_relativo_resultado * 100, 4), // en %
            'resultado_completo' => round($resultado, 6) . ' ± ' . round($incertidumbre_resultado, 6)
        ];
    }

    /**
     * Propagación para potencia: δ(x^n) = |n * x^(n-1)| * δx
     */
    private function propagacionPotencia(array $variables): array
    {
        if (count($variables) !== 1 || !isset($variables[0]['exponente'])) {
            throw new \InvalidArgumentException('Para potencia se requiere una variable con exponente');
        }

        $var = $variables[0];
        $x = $var['valor'];
        $dx = $var['incertidumbre'];
        $n = $var['exponente'];

        $resultado = pow($x, $n);
        $incertidumbre = abs($n * pow($x, $n - 1)) * $dx;

        return [
            'resultado' => round($resultado, 6),
            'incertidumbre' => round($incertidumbre, 6),
            'resultado_completo' => round($resultado, 6) . ' ± ' . round($incertidumbre, 6)
        ];
    }

    /**
     * Análisis completo de un conjunto de mediciones
     */
    public function analisisCompleto(array $mediciones, float $valor_verdadero = null, string $unidad = ''): array
    {
        $estadisticas = $this->calcularEstadisticas($mediciones);
        $error_absoluto = $this->calcularErrorAbsoluto($mediciones, $valor_verdadero);
        $incertidumbre = $this->calcularIncertidumbreTipoA($mediciones);

        $resultado = [
            'estadisticas' => $estadisticas,
            'error_absoluto' => $error_absoluto,
            'incertidumbre' => $incertidumbre,
            'unidad' => $unidad
        ];

        // Solo calcular error relativo si hay valor verdadero
        if ($valor_verdadero !== null && $valor_verdadero != 0) {
            $resultado['error_relativo'] = $this->calcularErrorRelativo($mediciones, $valor_verdadero);
        }

        return $resultado;
    }

    /**
     * Genera datos para gráfica de dispersión de mediciones
     */
    public function generarDatosGrafica(array $mediciones): array
    {
        $estadisticas = $this->calcularEstadisticas($mediciones);
        $media = $estadisticas['media'];
        $desviacion = $estadisticas['desviacion_estandar'];

        $datos_grafica = [];
        foreach ($mediciones as $index => $valor) {
            $datos_grafica[] = [
                'x' => $index + 1,
                'y' => $valor,
                'media' => $media,
                'limite_superior' => $media + $desviacion,
                'limite_inferior' => $media - $desviacion
            ];
        }

        return $datos_grafica;
    }

    /**
     * Exporta resultados a formato CSV
     */
    public function exportarAnalisisCSV(array $analisis): string
    {
        $csv = "ANÁLISIS DE ERRORES E INCERTIDUMBRE\n\n";
        
        // Estadísticas
        $csv .= "ESTADÍSTICAS BÁSICAS\n";
        $csv .= "Número de mediciones,{$analisis['estadisticas']['n_mediciones']}\n";
        $csv .= "Media,{$analisis['estadisticas']['media']}\n";
        $csv .= "Desviación estándar,{$analisis['estadisticas']['desviacion_estandar']}\n";
        $csv .= "Desviación estándar de la media,{$analisis['estadisticas']['desviacion_estandar_media']}\n";
        $csv .= "Valor máximo,{$analisis['estadisticas']['valor_maximo']}\n";
        $csv .= "Valor mínimo,{$analisis['estadisticas']['valor_minimo']}\n";
        $csv .= "Rango,{$analisis['estadisticas']['rango']}\n\n";

        // Errores absolutos
        $csv .= "ERRORES ABSOLUTOS\n";
        $csv .= "Medición,Valor,Error Absoluto\n";
        foreach ($analisis['error_absoluto']['errores'] as $error) {
            $csv .= "{$error['medicion']},{$error['valor']},{$error['error_absoluto']}\n";
        }
        $csv .= "\nError absoluto promedio,{$analisis['error_absoluto']['error_absoluto_promedio']}\n\n";

        // Incertidumbre
        $csv .= "INCERTIDUMBRE\n";
        $csv .= "Incertidumbre estándar,{$analisis['incertidumbre']['incertidumbre_estandar']}\n";
        $csv .= "Incertidumbre expandida (68%),{$analisis['incertidumbre']['incertidumbre_expandida_68']}\n";
        $csv .= "Incertidumbre expandida (95%),{$analisis['incertidumbre']['incertidumbre_expandida_95']}\n";
        $csv .= "Resultado final (95%),{$analisis['incertidumbre']['resultado_con_incertidumbre_95']}\n";

        return $csv;
    }
}