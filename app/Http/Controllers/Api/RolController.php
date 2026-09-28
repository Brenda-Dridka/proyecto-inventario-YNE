<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Rol;
use Illuminate\Http\JsonResponse;

class RolController
{
      public function index(): JsonResponse
    {
        $roles = Rol::orderBy('nombre')->get();

        return response()->json([
            'success' => true,
            'data' => $roles,
        ]);
    }
}
