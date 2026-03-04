<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvitadoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ConfiguracionController;

Route::post('/invitado/login', [InvitadoController::class, 'login']);
Route::get('/invitados', [InvitadoController::class, 'obtenerTodos']);
Route::get('/invitados/confirmados', [InvitadoController::class, 'obtenerConfirmados']);
Route::put('/invitado/{id}/asistencia', [InvitadoController::class, 'confirmarAsistencia']);
Route::get('/invitado/{id}/resultado', [InvitadoController::class, 'obtenerResultado']);
Route::post('/invitado/{id}/asignar-color', [InvitadoController::class, 'asignarColor']);

// Admin routes
Route::post('/admin/invitado', [AdminController::class, 'crearInvitado']);
Route::post('/admin/sorteo', [AdminController::class, 'abrirSorteo']);

// Colores
Route::get('/colors', [ColorController::class, 'index']);
Route::post('/colors', [ColorController::class, 'store']);

// Configuracion
Route::get('/configuracion', [ConfiguracionController::class, 'show']);
Route::put('/configuracion', [ConfiguracionController::class, 'update']);
