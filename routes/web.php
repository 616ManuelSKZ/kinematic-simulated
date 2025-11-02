<?php

use App\Http\Controllers\ExperimentoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicionController;
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

    // Ayuda
    Route::get('/ayuda', function () {
        return view('ayuda.index');
    })->name('ayuda');
});

require __DIR__.'/auth.php';