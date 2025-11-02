<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CinematicaService;

class CinematicaServiceTest extends TestCase
{
    public function test_calcula_mruv_correctamente()
    {
        $service = new CinematicaService();
        $params = [
            'velocidad_inicial' => 0,
            'aceleracion' => 2,
            'tiempo_total' => 5,
            'posicion_inicial' => 0,
            'intervalo' => 1
        ];
        
        $resultado = $service->calcularMRUV($params);
        
        $this->assertEquals(25, $resultado['resultados']['posicion_final']);
        $this->assertEquals(10, $resultado['resultados']['velocidad_final']);
    }
}