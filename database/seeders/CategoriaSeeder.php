<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $categorias = [
            [
                'nombre' => 'Herramientas',
                'descripcion' => 'Herramientas manuales y eléctricas utilizadas en el almacén.',
                'activo' => true,
            ],
            [
                'nombre' => 'Material eléctrico',
                'descripcion' => 'Cables, conectores, contactos, interruptores y material eléctrico.',
                'activo' => true,
            ],
            [
                'nombre' => 'Material de oficina',
                'descripcion' => 'Artículos y consumibles utilizados para actividades administrativas.',
                'activo' => true,
            ],
            [
                'nombre' => 'Equipo de protección',
                'descripcion' => 'Equipo y accesorios destinados a la protección del personal.',
                'activo' => true,
            ],
            [
                'nombre' => 'Limpieza',
                'descripcion' => 'Productos y materiales para limpieza y mantenimiento.',
                'activo' => true,
            ],
            [
                'nombre' => 'Consumibles',
                'descripcion' => 'Materiales de consumo frecuente utilizados en las operaciones.',
                'activo' => true,
            ],
            [
                'nombre' => 'Refacciones',
                'descripcion' => 'Refacciones y componentes para mantenimiento de maquinaria y equipos.',
                'activo' => true,
            ],
            [
                'nombre' => 'Material de mantenimiento',
                'descripcion' => 'Material utilizado para mantenimiento preventivo y correctivo.',
                'activo' => true,
            ],
            [
                'nombre' => 'Equipo de cómputo',
                'descripcion' => 'Equipos, accesorios y periféricos de cómputo.',
                'activo' => true,
            ],
            [
                'nombre' => 'Papelería',
                'descripcion' => 'Hojas, carpetas, plumas, etiquetas y artículos de papelería.',
                'activo' => true,
            ],
            [
                'nombre' => 'Seguridad',
                'descripcion' => 'Material relacionado con seguridad y señalización.',
                'activo' => true,
            ],
            [
                'nombre' => 'Otros',
                'descripcion' => 'Productos que no pertenecen a las demás categorías.',
                'activo' => true,
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::updateOrCreate(
                [
                    'nombre' => $categoria['nombre'],
                ],
                [
                    'descripcion' => $categoria['descripcion'],
                    'activo' => $categoria['activo'],
                ]
            );
        }
    }
}
