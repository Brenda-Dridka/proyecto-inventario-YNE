<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuarioController;

Route::get('/api/usuarios', [UsuarioController::class, 'index']);

Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');