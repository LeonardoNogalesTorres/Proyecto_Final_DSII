<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\DirectorController;

// Rutas Públicas (HU-01)
Route::get('/', [AutenticacionController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AutenticacionController::class, 'login']);
Route::post('/logout', [AutenticacionController::class, 'logout']);

// Rutas Protegidas bajo Autenticación y Filtros de Roles
Route::middleware(['web'])->group(function () {

    // Grupo exclusivo: Estudiantes (HU-02)
    Route::middleware(['role:estudiante'])->group(function () {
        Route::get('/estudiante/dashboard', [EstudianteController::class, 'dashboard']);
        Route::post('/estudiante/avance/{proyectoId}', [EstudianteController::class, 'subirAvance']);
    });

    // Grupo exclusivo: Tutores Académicos (HU-03)
    Route::middleware(['role:tutor'])->group(function () {
        Route::get('/tutor/dashboard', [TutorController::class, 'dashboard']);
        Route::get('/tutor/proyecto/{id}', [TutorController::class, 'revisarProyecto']);
        Route::post('/tutor/observacion/{avanceId}', [TutorController::class, 'guardarObservacion']);
    });

    // Grupo exclusivo: Director de Carrera (HU-04)
    Route::middleware(['role:director'])->group(function () {
        Route::get('/director/dashboard', [DirectorController::class, 'dashboard']);
    });

});