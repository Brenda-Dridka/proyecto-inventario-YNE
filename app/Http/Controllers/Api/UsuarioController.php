<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

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
      public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
            ],

            'apellido' => [
                'required',
                'string',
                'max:100',
            ],

            'no_empleado' => [
                'required',
                'string',
                'max:50',
                'unique:usuarios,no_empleado',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
            ],

            'id_rol' => [
                'required',
                'integer',
                'exists:roles,id',
            ],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',

            'no_empleado.required' => 'El número de empleado es obligatorio.',
            'no_empleado.unique' => 'El número de empleado ya está registrado.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',

            'id_rol.required' => 'Debes seleccionar un rol.',
            'id_rol.exists' => 'El rol seleccionado no existe.',
        ]);

        $datos['no_empleado'] = $datos['no_empleado'];
        $datos['password'] = Hash::make($datos['password']);
        $usuario = Usuario::create($datos);
        $usuario->load('rol');

        return response()->json([
            'success' => true,
            'message' => 'Empleado creado correctamente.',
            'data' => $usuario,
        ], 201);
    }
    
}
