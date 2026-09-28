<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;

class CategoriaController
{
     public function index(): JsonResponse
    {
        $categorias = Categoria::withCount('productos')
            ->orderBy('nombre')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categorias,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                'unique:categorias,nombre',
            ],

            'descripcion' => [
                'nullable',
                'string',
                'max:255',
            ],

            'activo' => [
                'required',
                'boolean',
            ],
        ], [
            'nombre.required' =>
                'El nombre de la categoría es obligatorio.',

            'nombre.unique' =>
                'La categoría ya existe.',

            'activo.required' =>
                'Debes indicar el estado de la categoría.',
        ]);

        $categoria = Categoria::create($datos);

        return response()->json([
            'success' => true,
            'message' => 'Categoría creada correctamente.',
            'data' => $categoria,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $categoria = Categoria::with('productos')
            ->find($id);

        if (!$categoria) {
            return response()->json([
                'success' => false,
                'message' => 'La categoría no existe.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $categoria,
        ]);
    }

    public function update(
        Request $request,
        int $id
    ): JsonResponse {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'success' => false,
                'message' => 'La categoría no existe.',
            ], 404);
        }

        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categorias', 'nombre')
                    ->ignore($categoria->id),
            ],

            'descripcion' => [
                'nullable',
                'string',
                'max:255',
            ],

            'activo' => [
                'required',
                'boolean',
            ],
        ], [
            'nombre.required' =>
                'El nombre de la categoría es obligatorio.',

            'nombre.unique' =>
                'La categoría ya existe.',

            'activo.required' =>
                'Debes indicar el estado de la categoría.',
        ]);

        $categoria->update($datos);

        return response()->json([
            'success' => true,
            'message' => 'Categoría actualizada correctamente.',
            'data' => $categoria,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'success' => false,
                'message' => 'La categoría no existe.',
            ], 404);
        }

        if ($categoria->productos()->exists()) {
            return response()->json([
                'success' => false,
                'message' =>
                    'No puedes eliminar esta categoría porque tiene productos asociados.',
            ], 409);
        }

        $categoria->delete();

        return response()->json([
            'success' => true,
            'message' => 'Categoría eliminada correctamente.',
        ]);
    }
}
