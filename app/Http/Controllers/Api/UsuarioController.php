<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

        // Encriptar contraseña
        $datos['password'] = Hash::make($datos['password']);

        // Todo usuario nuevo se crea activo
        $datos['activo'] = 1;

        $usuario = Usuario::create($datos);

        $usuario->load('rol');

        return response()->json([
            'success' => true,
            'message' => 'Empleado creado correctamente.',
            'data' => $usuario,
        ], 201);
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'El usuario no existe.',
            ], 404);
        }

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
                Rule::unique('usuarios', 'no_empleado')
                    ->ignore($usuario->id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:6',
            ],

            'id_rol' => [
                'required',
                'integer',
                'exists:roles,id',
            ],

            'activo' => [
                'required',
                'boolean',
            ],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'no_empleado.required' => 'El número de empleado es obligatorio.',
            'no_empleado.unique' => 'El número de empleado ya está registrado.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'id_rol.required' => 'Debes seleccionar un rol.',
            'id_rol.exists' => 'El rol seleccionado no existe.',
            'activo.required' => 'Debes indicar el estado del usuario.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Contraseña
        |--------------------------------------------------------------------------
        | Si viene vacía/null, conservamos la contraseña actual.
        */
        if (!empty($datos['password'])) {
            $datos['password'] = Hash::make($datos['password']);
        } else {
            unset($datos['password']);
        }

        $usuario->update($datos);

        $usuario->load('rol');

        return response()->json([
            'success' => true,
            'message' => 'Empleado actualizado correctamente.',
            'data' => $usuario,
        ]);
    }
        /**
     * Eliminar usuario
     */
public function destroy(int $id): JsonResponse
{
    $usuario = Usuario::find($id);

    if (!$usuario) {
        return response()->json([
            'success' => false,
            'message' => 'El usuario no existe.',
        ], 404);
    }

    $usuario->delete();

    return response()->json([
        'success' => true,
        'message' => 'Empleado eliminado correctamente.',
    ]);
}

public function show(int $id): JsonResponse
{
    $usuario = Usuario::with('rol')->find($id);

    if (!$usuario) {
        return response()->json([
            'success' => false,
            'message' => 'El usuario no existe.',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $usuario,
    ]);
}
}