<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\RolController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\CategoriaController;


Route::get('/api/usuarios', [UsuarioController::class, 'index']);
Route::post('/api/usuarios', [UsuarioController::class, 'store']);
Route::put('/api/usuarios/{id}', [UsuarioController::class, 'update']);
Route::delete('/api/usuarios/{id}', [UsuarioController::class, 'destroy']);
Route::get('/api/usuarios/{id}', [UsuarioController::class, 'show']);

Route::get('/api/roles', [RolController::class, 'index']);

Route::post('/api/login', [AuthController::class, 'login']);

// Productos
Route::get('/api/productos', [ProductoController::class, 'index']);
Route::post('/api/productos', [ProductoController::class, 'store']);
Route::get('/api/productos/{id}', [ProductoController::class, 'show']);
Route::put('/api/productos/{id}', [ProductoController::class, 'update']);
Route::delete('/api/productos/{id}', [ProductoController::class, 'destroy']);

// Categorías
Route::get('/api/categorias', [CategoriaController::class, 'index']);
Route::post('/api/categorias', [CategoriaController::class, 'store']);
Route::get('/api/categorias/{id}', [CategoriaController::class, 'show']);
Route::put('/api/categorias/{id}', [CategoriaController::class, 'update']);
Route::delete('/api/categorias/{id}', [CategoriaController::class, 'destroy']);

Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');