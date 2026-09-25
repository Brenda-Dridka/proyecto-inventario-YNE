<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;

class UsuarioController
{
     public function index(): JsonResponse
    {
        $usuarios = Usuario::with('rol')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $usuarios,
        ]);
    }
    
}
