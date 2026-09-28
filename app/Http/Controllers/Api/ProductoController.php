<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ProductoController
{
    /**
     * Obtener todos los productos.
     */
    public function index(): JsonResponse
    {
        $productos = Producto::with('categoria')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $productos,
        ]);
    }

    /**
     * Crear un producto.
     */
    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'articulo' => [
                'required',
                'string',
                'max:150',
            ],

            'codigo' => [
                'required',
                'string',
                'max:50',
                'unique:productos,codigo',
            ],

            'id_categoria' => [
                'required',
                'integer',
                'exists:categorias,id',
            ],

            'cantidad' => [
                'required',
                'numeric',
                'min:0',
            ],

            'unidad_medida' => [
                'required',
                Rule::in([
                    'individual',
                    'caja',
                ]),
            ],

            'piezas_por_caja' => [
                'nullable',
                'integer',
                'min:1',
                'required_if:unidad_medida,caja',
            ],

            'cantidad_cajas' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'fecha_alta' => [
                'required',
                'date_format:d/m/Y',
            ],

            'stock' => [
                'required',
                'boolean',
            ],
        ], [
            'articulo.required' =>
                'El artículo es obligatorio.',

            'articulo.max' =>
                'El artículo no puede tener más de 150 caracteres.',

            'codigo.required' =>
                'El código es obligatorio.',

            'codigo.unique' =>
                'El código ya está registrado.',

            'codigo.max' =>
                'El código no puede tener más de 50 caracteres.',

            'id_categoria.required' =>
                'Debes seleccionar una categoría.',

            'id_categoria.exists' =>
                'La categoría seleccionada no existe.',

            'cantidad.required' =>
                'La cantidad es obligatoria.',

            'cantidad.numeric' =>
                'La cantidad debe ser numérica.',

            'cantidad.min' =>
                'La cantidad no puede ser negativa.',

            'unidad_medida.required' =>
                'Debes seleccionar el tipo de unidad.',

            'unidad_medida.in' =>
                'La unidad seleccionada no es válida.',

            'piezas_por_caja.required_if' =>
                'Debes indicar cuántas piezas contiene cada caja.',

            'piezas_por_caja.integer' =>
                'Las piezas por caja deben ser un número entero.',

            'piezas_por_caja.min' =>
                'Una caja debe contener al menos una pieza.',

            'cantidad_cajas.integer' =>
                'La cantidad de cajas debe ser un número entero.',

            'cantidad_cajas.min' =>
                'La cantidad de cajas no puede ser negativa.',

            'fecha_alta.required' =>
                'La fecha de alta es obligatoria.',

            'fecha_alta.date_format' =>
                'La fecha debe tener el formato dd/mm/aaaa.',

            'stock.required' =>
                'Debes indicar el estado del stock.',

            'stock.boolean' =>
                'El estado del stock no es válido.',
        ]);

        /*
         * Convertir la fecha de dd/mm/aaaa
         * a Y-m-d para almacenarla en MySQL.
         */
        $datos['fecha_alta'] = Carbon::createFromFormat(
            'd/m/Y',
            $datos['fecha_alta']
        )->format('Y-m-d');

        /*
         * Si el producto es individual,
         * no necesitamos información de cajas.
         */
        if ($datos['unidad_medida'] === 'individual') {
            $datos['piezas_por_caja'] = null;
            $datos['cantidad_cajas'] = 0;
        }

        /*
         * Si el producto se maneja por cajas,
         * calculamos automáticamente la cantidad total
         * de piezas.
         */
        if ($datos['unidad_medida'] === 'caja') {
            $datos['cantidad_cajas'] =
                $datos['cantidad_cajas'] ?? 0;

            $datos['cantidad'] =
                $datos['cantidad_cajas']
                * $datos['piezas_por_caja'];
        }

        $producto = Producto::create($datos);

        $producto->load('categoria');

        return response()->json([
            'success' => true,
            'message' => 'Producto creado correctamente.',
            'data' => $producto,
        ], 201);
    }

    /**
     * Mostrar un producto.
     */
    public function show(int $id): JsonResponse
    {
        $producto = Producto::with('categoria')
            ->find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'El producto no existe.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $producto,
        ]);
    }

    /**
     * Actualizar un producto.
     */
    public function update(
        Request $request,
        int $id
    ): JsonResponse {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'El producto no existe.',
            ], 404);
        }

        $datos = $request->validate([
            'articulo' => [
                'required',
                'string',
                'max:150',
            ],

            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('productos', 'codigo')
                    ->ignore($producto->id),
            ],

            'id_categoria' => [
                'required',
                'integer',
                'exists:categorias,id',
            ],

            'cantidad' => [
                'required',
                'numeric',
                'min:0',
            ],

            'unidad_medida' => [
                'required',
                Rule::in([
                    'individual',
                    'caja',
                ]),
            ],

            'piezas_por_caja' => [
                'nullable',
                'integer',
                'min:1',
                'required_if:unidad_medida,caja',
            ],

            'cantidad_cajas' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'fecha_alta' => [
                'required',
                'date_format:d/m/Y',
            ],

            'stock' => [
                'required',
                'boolean',
            ],
        ], [
            'articulo.required' =>
                'El artículo es obligatorio.',

            'articulo.max' =>
                'El artículo no puede tener más de 150 caracteres.',

            'codigo.required' =>
                'El código es obligatorio.',

            'codigo.unique' =>
                'El código ya está registrado.',

            'codigo.max' =>
                'El código no puede tener más de 50 caracteres.',

            'id_categoria.required' =>
                'Debes seleccionar una categoría.',

            'id_categoria.exists' =>
                'La categoría seleccionada no existe.',

            'cantidad.required' =>
                'La cantidad es obligatoria.',

            'cantidad.numeric' =>
                'La cantidad debe ser numérica.',

            'cantidad.min' =>
                'La cantidad no puede ser negativa.',

            'unidad_medida.required' =>
                'Debes seleccionar el tipo de unidad.',

            'unidad_medida.in' =>
                'La unidad seleccionada no es válida.',

            'piezas_por_caja.required_if' =>
                'Debes indicar cuántas piezas contiene cada caja.',

            'piezas_por_caja.integer' =>
                'Las piezas por caja deben ser un número entero.',

            'piezas_por_caja.min' =>
                'Una caja debe contener al menos una pieza.',

            'cantidad_cajas.integer' =>
                'La cantidad de cajas debe ser un número entero.',

            'cantidad_cajas.min' =>
                'La cantidad de cajas no puede ser negativa.',

            'fecha_alta.required' =>
                'La fecha de alta es obligatoria.',

            'fecha_alta.date_format' =>
                'La fecha debe tener el formato dd/mm/aaaa.',

            'stock.required' =>
                'Debes indicar el estado del stock.',

            'stock.boolean' =>
                'El estado del stock no es válido.',
        ]);

        /*
         * Convertir la fecha de dd/mm/aaaa
         * a Y-m-d para almacenarla en MySQL.
         */
        $datos['fecha_alta'] = Carbon::createFromFormat(
            'd/m/Y',
            $datos['fecha_alta']
        )->format('Y-m-d');

        /*
         * Si el producto es individual,
         * eliminamos la información de cajas.
         */
        if ($datos['unidad_medida'] === 'individual') {
            $datos['piezas_por_caja'] = null;
            $datos['cantidad_cajas'] = 0;
        }

        /*
         * Si el producto se maneja por cajas,
         * calculamos automáticamente la cantidad total
         * de piezas.
         */
        if ($datos['unidad_medida'] === 'caja') {
            $datos['cantidad_cajas'] =
                $datos['cantidad_cajas'] ?? 0;

            $datos['cantidad'] =
                $datos['cantidad_cajas']
                * $datos['piezas_por_caja'];
        }

        $producto->update($datos);

        $producto->load('categoria');

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado correctamente.',
            'data' => $producto,
        ]);
    }

    /**
     * Eliminar un producto.
     */
    public function destroy(int $id): JsonResponse
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'El producto no existe.',
            ], 404);
        }

        $producto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado correctamente.',
        ]);
    }
}