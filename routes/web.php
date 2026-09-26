<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\RolController;

Route::get('/api/usuarios', [UsuarioController::class, 'index']);
Route::post('/api/usuarios', [UsuarioController::class, 'store']);
//Route::put('/api/usuarios/{id}', [UsuarioController::class, 'update']);
//Route::delete('/api/usuarios/{id}', [UsuarioController::class, 'destroy']);

Route::get('/api/roles', [RolController::class, 'index']);

Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');