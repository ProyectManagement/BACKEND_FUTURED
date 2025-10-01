<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InteligenciaController;
use App\Http\Controllers\CarrerasApiController;
use App\Http\Controllers\GruposApiController;
use App\Http\Controllers\AlumnosApiController;


Route::get('/prediccion/{matricula}', [InteligenciaController::class, 'predecir']);

// Carreras
Route::get('/carreras', [CarrerasApiController::class, 'index']);

// Grupos según carrera
Route::get('/grupos/{idCarrera}', [GruposApiController::class, 'getByCarrera']);

Route::get('/alumnos-todos', [AlumnosApiController::class, 'index']);
