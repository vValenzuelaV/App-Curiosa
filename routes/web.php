<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RelationshipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VisitorAuthController;
use App\Http\Controllers\AdminController;

// ==========================================
// RUTAS PROTEGIDAS PARA VISITANTES (REQUIIEREN IDENTIFICACIÓN)
// ==========================================
Route::middleware('visitor.identified')->group(function () {
    Route::get('/', [RelationshipController::class, 'index'])->name('home');
    Route::get('/cartas', [RelationshipController::class, 'cartas'])->name('cartas');
    Route::get('/momentos', [RelationshipController::class, 'momentos'])->name('momentos');
    Route::get('/musica', [RelationshipController::class, 'musica'])->name('musica');
    Route::get('/respuestas', [RelationshipController::class, 'respuestas'])->name('respuestas');
    Route::post('/cartas/{id}/respuestas', [RelationshipController::class, 'storeRespuesta'])->name('respuestas.store');
    
    // AJAX: Marcar carta como leída cuando Feñi la abre
    Route::post('/cartas/{id}/leer', [RelationshipController::class, 'marcarLeida'])->name('cartas.leer');

    // Agregar canción por visitante
    Route::post('/musica/canciones', [RelationshipController::class, 'storeCancion'])->name('canciones.visitor.store');
});

// ==========================================
// IDENTIFICACIÓN DE VISITANTES
// ==========================================
Route::get('/identificarse', [VisitorAuthController::class, 'showIdentificar'])->name('identificar');
Route::post('/identificarse', [VisitorAuthController::class, 'identificar'])->name('identificar.submit');
Route::post('/identificarse/salir', [VisitorAuthController::class, 'salir'])->name('identificar.logout');

// ==========================================
// RUTAS DE AUTENTICACIÓN ADMIN
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// RUTAS DE ADMINISTRACIÓN (PROTEGIDAS)
// ==========================================
Route::middleware('auth')->prefix('admin')->as('admin.')->group(function () {
    
    // CRUD Cartas
    Route::post('/cartas', [AdminController::class, 'storeCarta'])->name('cartas.store');
    Route::put('/cartas/{id}', [AdminController::class, 'updateCarta'])->name('cartas.update');
    Route::delete('/cartas/{id}', [AdminController::class, 'destroyCarta'])->name('cartas.destroy');

    // CRUD Momentos
    Route::post('/momentos', [AdminController::class, 'storeMomento'])->name('momentos.store');
    Route::put('/momentos/{id}', [AdminController::class, 'updateMomento'])->name('momentos.update');
    Route::delete('/momentos/{id}', [AdminController::class, 'destroyMomento'])->name('momentos.destroy');

    // CRUD Valores Compartidos (Compromisos)
    Route::post('/valores', [AdminController::class, 'storeValor'])->name('valores.store');
    Route::put('/valores/{id}', [AdminController::class, 'updateValor'])->name('valores.update');
    Route::delete('/valores/{id}', [AdminController::class, 'destroyValor'])->name('valores.destroy');

    // CRUD Canciones
    Route::post('/canciones', [AdminController::class, 'storeCancion'])->name('canciones.store');
    Route::put('/canciones/{id}', [AdminController::class, 'updateCancion'])->name('canciones.update');
    Route::delete('/canciones/{id}', [AdminController::class, 'destroyCancion'])->name('canciones.destroy');

    // CRUD Respuestas
    Route::put('/respuestas/{id}', [AdminController::class, 'updateRespuesta'])->name('respuestas.update');
    Route::delete('/respuestas/{id}', [AdminController::class, 'destroyRespuesta'])->name('respuestas.destroy');
});
