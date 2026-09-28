<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    public function run(): void
    {
        $permisos = [
            // Usuarios
            [
                'nombre' => 'usuarios.ver',
            ],
            [
                'nombre' => 'usuarios.crear',
            ],
            [
                'nombre' => 'usuarios.editar',
            ],
            [
                'nombre' => 'usuarios.eliminar',
            ],

            // Productos
            [
                'nombre' => 'productos.ver',
            ],
            [
                'nombre' => 'productos.crear',
            ],
            [
                'nombre' => 'productos.editar',
            ],
            [
                'nombre' => 'productos.eliminar',
            ],
        ];

        foreach ($permisos as $permiso) {
            DB::table('permisos')->updateOrInsert(
                [
                    'nombre' => $permiso['nombre'],
                ],
                $permiso
            );
        }
    }
}

