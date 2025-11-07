<?php

use App\Http\Controllers\ExperimentoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicionController;
use App\Http\Controllers\AcercaController;
use App\Http\Controllers\DesarrolladorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Rutas de experimentos
    Route::resource('experimentos', ExperimentoController::class);
    
    // Simulación en tiempo real (AJAX)
    Route::post('/simular', [ExperimentoController::class, 'simular'])
        ->name('simular');
    
    // Exportar datos
    Route::get('/experimentos/{experimento}/exportar', [ExperimentoController::class, 'exportar'])
        ->name('experimentos.exportar');
    
    // Comparar con datos experimentales
    Route::post('/experimentos/{experimento}/comparar', [ExperimentoController::class, 'comparar'])
        ->name('experimentos.comparar');

    // Módulos de cinemática
    Route::get('/mru', function () {
        return view('modulos.mru');
    })->name('mru');

    Route::get('/mruv', function () {
        return view('modulos.mruv');
    })->name('mruv');

    Route::get('/parabolico', function () {
        return view('modulos.parabolico');
    })->name('parabolico');

    // Módulo de mediciones y análisis de errores
    Route::resource('mediciones', MedicionController::class);
    
    Route::post('/mediciones/analizar', [MedicionController::class, 'analizar'])
        ->name('mediciones.analizar');
    
    Route::post('/mediciones/propagar', [MedicionController::class, 'propagarIncertidumbre'])
        ->name('mediciones.propagar');
    
    Route::get('/mediciones/{medicion}/exportar', [MedicionController::class, 'exportar'])
        ->name('mediciones.exportar');

    // Rastreador con OpenCV
    Route::get('/opencv-tracker', function () {
        return view('modulos.opencv-tracker');
    })->name('opencv.tracker');

    Route::post('/opencv/guardar', [ExperimentoController::class, 'guardarOpenCV'])
        ->name('opencv.guardar');

    // Captura con Arduino
    Route::get('/arduino-sensor', function () {
        return view('modulos.arduino-sensor');
    })->name('arduino.sensor');

    Route::post('/arduino/guardar', [ExperimentoController::class, 'guardarArduino'])
        ->name('arduino.guardar');

    // Ayuda
    Route::get('/ayuda', function () {
        return view('ayuda.index');
    })->name('ayuda');

    // Ruta para mostrar los desarrolladores
    Route::get('/desarrolladores', function () {
        return view('desarrolladores');
    })->name('desarrolladores');

    // Ruta para mostrar la información "Acerca de"
    Route::get('/acerca-de', function () {
        return view('acerca-de');
    })->name('acerca-de');
});

require __DIR__.'/auth.php';