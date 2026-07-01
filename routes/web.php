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

    // Grupo exclusivo: Estudiantes
    Route::middleware(['role:estudiante'])->group(function () {
        Route::get('/estudiante/inicio', [EstudianteController::class, 'inicio']);
        Route::get('/estudiante/dashboard', [EstudianteController::class, 'dashboard']);
        Route::post('/estudiante/avance/{proyectoId}', [EstudianteController::class, 'subirAvance']);
        Route::get('/estudiante/historico', [EstudianteController::class, 'historico']);
    });

    // Grupo exclusivo: Tutores
    Route::middleware(['role:tutor'])->group(function () {
        Route::get('/tutor/inicio', [TutorController::class, 'inicio']);
        Route::get('/tutor/dashboard', [TutorController::class, 'dashboard']);
        Route::get('/tutor/proyecto/{proyectoId}', [TutorController::class, 'revisarProyecto']);
        Route::post('/tutor/observacion/{avanceId}', [TutorController::class, 'guardarObservacion']);
        Route::post('/tutor/observacion/complemento/{observacionId}', [TutorController::class, 'guardarComplemento']);
        Route::get('/tutor/reportes', [TutorController::class, 'reportes']);

    });

    // Grupo exclusivo: Director de Carrera (HU-04)
    Route::middleware(['role:director'])->group(function () {
        Route::get('/director/dashboard', [DirectorController::class, 'dashboard']);
        Route::get('/director/control-proyectos', [DirectorController::class, 'controlProyectos']);
        Route::post('/director/reasignar/{proyectoId}', [DirectorController::class, 'reasignarTutor']);
        Route::get('/director/docentes', [DirectorController::class, 'docentesAutorizados']);
    });

});