<?php

namespace App\Http\Controllers\Api;


use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController
{
       public function login(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'no_empleado' => [
                'required',
                'string',
            ],
            'password' => [
                'required',
                'string',
            ],
        ], [
            'no_empleado.required' => 'El número de nómina es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $usuario = Usuario::with('rol')
            ->where('no_empleado', $datos['no_empleado'])
            ->first();

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'El número de nómina o la contraseña son incorrectos.',
            ], 401);
        }

        if (!Hash::check($datos['password'], $usuario->password)) {
            return response()->json([
                'success' => false,
                'message' => 'El número de nómina o la contraseña son incorrectos.',
            ], 401);
        }

        if ((int) $usuario->activo !== 1) {
            return response()->json([
                'success' => false,
                'message' => 'El usuario se encuentra inactivo.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Inicio de sesión correcto.',
            'data' => [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'no_empleado' => $usuario->no_empleado,
                'rol' => $usuario->rol,
                'activo' => $usuario->activo,
            ],
        ]);
    }
}
