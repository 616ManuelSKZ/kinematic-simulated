<?php

namespace App\Services;

class CinematicaService
{
    /**
     * Calcula MRU (Movimiento Rectilíneo Uniforme)
     */
    public function calcularMRU(array $params): array
    {
        $v = $params['velocidad'];
        $t_max = $params['tiempo_total'];
        $x0 = $params['posicion_inicial'] ?? 0;
        $dt = $params['intervalo'] ?? 0.1;

        $datos = [];
        $t = 0;

        while ($t <= $t_max) {
            $x = $x0 + ($v * $t);
            
            $datos[] = [
                't' => round($t, 3),
                'x' => round($x, 3),
                'v' => round($v, 3)
            ];
            
            $t += $dt;
        }

        $xf = $x0 + ($v * $t_max);

        return [
            'datos' => $datos,
            'resultados' => [
                'posicion_final' => round($xf, 3),
                'velocidad_constante' => round($v, 3),
                'distancia_recorrida' => round(abs($xf - $x0), 3)
            ]
        ];
    }

    /**
     * Calcula MRUV (Movimiento Rectilíneo Uniformemente Variado)
     */
    public function calcularMRUV(array $params): array
    {
        $vi = $params['velocidad_inicial'];
        $a = $params['aceleracion'];
        $t_max = $params['tiempo_total'];
        $x0 = $params['posicion_inicial'] ?? 0;
        $dt = $params['intervalo'] ?? 0.1;

        $datos = [];
        $t = 0;

        while ($t <= $t_max) {
            $v = $vi + ($a * $t);
            $x = $x0 + ($vi * $t) + (0.5 * $a * pow($t, 2));
            
            $datos[] = [
                't' => round($t, 3),
                'x' => round($x, 3),
                'v' => round($v, 3)
            ];
            
            $t += $dt;
        }

        $vf = $vi + ($a * $t_max);
        $xf = $x0 + ($vi * $t_max) + (0.5 * $a * pow($t_max, 2));

        return [
            'datos' => $datos,
            'resultados' => [
                'posicion_final' => round($xf, 3),
                'velocidad_final' => round($vf, 3),
                'distancia_recorrida' => round(abs($xf - $x0), 3)
            ]
        ];
    }

    /**
     * Calcula Movimiento Parabólico
     */
    public function calcularParabolico(array $params): array
    {
        $v0 = $params['velocidad_inicial'];
        $theta = deg2rad($params['angulo']);
        $y0 = $params['altura_inicial'] ?? 0;
        $g = $params['gravedad'] ?? 9.81;
        $dt = $params['intervalo'] ?? 0.01;

        $v0x = $v0 * cos($theta);
        $v0y = $v0 * sin($theta);

        // Calcular tiempo de vuelo
        $discriminante = pow($v0y, 2) + (2 * $g * $y0);
        $t_vuelo = ($v0y + sqrt($discriminante)) / $g;

        $datos = [];
        $t = 0;
        $y_max = $y0;
        $t_max_altura = 0;

        while ($t <= $t_vuelo) {
            $x = $v0x * $t;
            $y = $y0 + ($v0y * $t) - (0.5 * $g * pow($t, 2));
            
            if ($y > $y_max) {
                $y_max = $y;
                $t_max_altura = $t;
            }

            $vx = $v0x;
            $vy = $v0y - ($g * $t);
            $v_magnitud = sqrt(pow($vx, 2) + pow($vy, 2));

            $datos[] = [
                't' => round($t, 4),
                'x' => round($x, 3),
                'y' => round(max($y, 0), 3),
                'vx' => round($vx, 3),
                'vy' => round($vy, 3),
                'v' => round($v_magnitud, 3)
            ];

            if ($y < 0) break;
            $t += $dt;
        }

        $alcance = $v0x * $t_vuelo;
        $altura_maxima = $y0 + (pow($v0y, 2) / (2 * $g));
        
        $vx_impacto = $v0x;
        $vy_impacto = $v0y - ($g * $t_vuelo);
        $v_impacto = sqrt(pow($vx_impacto, 2) + pow($vy_impacto, 2));

        return [
            'datos' => $datos,
            'resultados' => [
                'tiempo_vuelo' => round($t_vuelo, 3),
                'alcance_maximo' => round($alcance, 3),
                'altura_maxima' => round($altura_maxima, 3),
                'velocidad_impacto' => round($v_impacto, 3),
                'componentes_iniciales' => [
                    'vx' => round($v0x, 3),
                    'vy' => round($v0y, 3)
                ]
            ]
        ];
    }

    /**
     * Calcula el error RMSE entre datos teóricos y experimentales
     */
    public function calcularRMSE(array $teoricos, array $experimentales, string $variable): float
    {
        $n = min(count($teoricos), count($experimentales));
        $suma_cuadrados = 0;

        for ($i = 0; $i < $n; $i++) {
            $diff = $teoricos[$i][$variable] - $experimentales[$i][$variable];
            $suma_cuadrados += pow($diff, 2);
        }

        return sqrt($suma_cuadrados / $n);
    }

    /**
     * Exporta datos a formato CSV
     */
    public function exportarCSV(array $datos, string $tipo): string
    {
        $csv = '';
        
        if ($tipo === 'mruv') {
            $csv .= "Tiempo (s),Posición (m),Velocidad (m/s)\n";
            foreach ($datos as $punto) {
                $csv .= "{$punto['t']},{$punto['x']},{$punto['v']}\n";
            }
        } else {
            $csv .= "Tiempo (s),Posición X (m),Posición Y (m),Velocidad X (m/s),Velocidad Y (m/s),Velocidad Total (m/s)\n";
            foreach ($datos as $punto) {
                $csv .= "{$punto['t']},{$punto['x']},{$punto['y']},{$punto['vx']},{$punto['vy']},{$punto['v']}\n";
            }
        }

        return $csv;
    }
}