<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Experimento;
use App\Services\CinematicaService;

class ExperimentoSeeder extends Seeder
{
    protected $cinematicaService;

    public function __construct(CinematicaService $cinematicaService)
    {
        $this->cinematicaService = $cinematicaService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario de prueba si no existe
        $user = User::firstOrCreate(
            ['email' => 'demo@cinematica.com'],
            [
                'name' => 'Usuario Demo',
                'password' => bcrypt('password123')
            ]
        );

        User::updateOrCreate(
            ['email' => 'manuel@gmail.com'],
            [
                'name' => 'Manuel',
                'password' => bcrypt('Manuel123')
            ]
        );

        // Experimento MRUV 1: Aceleración positiva
        $parametrosMruv1 = [
            'velocidad_inicial' => 0,
            'aceleracion' => 2,
            'tiempo_total' => 10,
            'posicion_inicial' => 0,
            'intervalo' => 0.1
        ];
        
        $resultadosMruv1 = $this->cinematicaService->calcularMRUV($parametrosMruv1);
        
        Experimento::create([
            'user_id' => $user->id,
            'nombre' => 'Auto acelerando desde reposo',
            'tipo' => 'mruv',
            'parametros' => $parametrosMruv1,
            'resultados' => $resultadosMruv1,
            'notas' => 'Simulación de un vehículo acelerando uniformemente desde el reposo con a=2 m/s²'
        ]);

        // Experimento MRUV 2: Frenado
        $parametrosMruv2 = [
            'velocidad_inicial' => 20,
            'aceleracion' => -3,
            'tiempo_total' => 6,
            'posicion_inicial' => 0,
            'intervalo' => 0.1
        ];
        
        $resultadosMruv2 = $this->cinematicaService->calcularMRUV($parametrosMruv2);
        
        Experimento::create([
            'user_id' => $user->id,
            'nombre' => 'Vehículo frenando',
            'tipo' => 'mruv',
            'parametros' => $parametrosMruv2,
            'resultados' => $resultadosMruv2,
            'notas' => 'Simulación de frenado con velocidad inicial de 20 m/s y desaceleración de -3 m/s²'
        ]);

        // Experimento Parabólico 1: Ángulo 45°
        $parametrosParab1 = [
            'velocidad_inicial' => 20,
            'angulo' => 45,
            'altura_inicial' => 0,
            'gravedad' => 9.81,
            'intervalo' => 0.01
        ];
        
        $resultadosParab1 = $this->cinematicaService->calcularParabolico($parametrosParab1);
        
        Experimento::create([
            'user_id' => $user->id,
            'nombre' => 'Lanzamiento a 45° - Alcance máximo',
            'tipo' => 'parabolico',
            'parametros' => $parametrosParab1,
            'resultados' => $resultadosParab1,
            'notas' => 'Lanzamiento a 45° que produce el máximo alcance horizontal teórico'
        ]);

        // Experimento Parabólico 2: Lanzamiento vertical
        $parametrosParab2 = [
            'velocidad_inicial' => 15,
            'angulo' => 80,
            'altura_inicial' => 2,
            'gravedad' => 9.81,
            'intervalo' => 0.01
        ];
        
        $resultadosParab2 = $this->cinematicaService->calcularParabolico($parametrosParab2);
        
        Experimento::create([
            'user_id' => $user->id,
            'nombre' => 'Lanzamiento casi vertical',
            'tipo' => 'parabolico',
            'parametros' => $parametrosParab2,
            'resultados' => $resultadosParab2,
            'notas' => 'Lanzamiento con ángulo pronunciado de 80° desde una altura inicial de 2m'
        ]);

        // Experimento Parabólico 3: Tiro horizontal
        $parametrosParab3 = [
            'velocidad_inicial' => 10,
            'angulo' => 5,
            'altura_inicial' => 10,
            'gravedad' => 9.81,
            'intervalo' => 0.01
        ];
        
        $resultadosParab3 = $this->cinematicaService->calcularParabolico($parametrosParab3);
        
        Experimento::create([
            'user_id' => $user->id,
            'nombre' => 'Lanzamiento desde altura - Casi horizontal',
            'tipo' => 'parabolico',
            'parametros' => $parametrosParab3,
            'resultados' => $resultadosParab3,
            'notas' => 'Simulación de un objeto lanzado desde 10m de altura con ángulo pequeño'
        ]);

        // Experimento MRUV 3: Movimiento con velocidad constante
        $parametrosMruv3 = [
            'velocidad_inicial' => 15,
            'aceleracion' => 0,
            'tiempo_total' => 8,
            'posicion_inicial' => 5,
            'intervalo' => 0.1
        ];
        
        $resultadosMruv3 = $this->cinematicaService->calcularMRUV($parametrosMruv3);
        
        Experimento::create([
            'user_id' => $user->id,
            'nombre' => 'Movimiento Rectilíneo Uniforme (MRU)',
            'tipo' => 'mruv',
            'parametros' => $parametrosMruv3,
            'resultados' => $resultadosMruv3,
            'notas' => 'Caso especial de MRUV con a=0, demostrando MRU con velocidad constante de 15 m/s'
        ]);

        $this->command->info('✅ Se han creado 6 experimentos de ejemplo');
        $this->command->info('📧 Usuario: demo@cinematica.com');
        $this->command->info('🔑 Contraseña: password123');
    }
}