<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolPermisoSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Administrador
        |--------------------------------------------------------------------------
        */

        $administrador = DB::table('roles')
            ->where('nombre', 'Administrador')
            ->value('id');

        $permisosAdministrador = DB::table('permisos')
            ->pluck('id');

        foreach ($permisosAdministrador as $permisoId) {
            DB::table('rol_permiso')->updateOrInsert(
                [
                    'rol_id' => $administrador,
                    'permiso_id' => $permisoId,
                ],
                [
                    'rol_id' => $administrador,
                    'permiso_id' => $permisoId,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Almacenista
        |--------------------------------------------------------------------------
        */

        $almacenista = DB::table('roles')
            ->where('nombre', 'Almacenista')
            ->value('id');

        $permisosAlmacenista = DB::table('permisos')
            ->whereIn('nombre', [
                'productos.ver',
                'productos.crear',
                'productos.editar',
            ])
            ->pluck('id');

        foreach ($permisosAlmacenista as $permisoId) {
            DB::table('rol_permiso')->updateOrInsert(
                [
                    'rol_id' => $almacenista,
                    'permiso_id' => $permisoId,
                ],
                [
                    'rol_id' => $almacenista,
                    'permiso_id' => $permisoId,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Consulta
        |--------------------------------------------------------------------------
        */

        $consulta = DB::table('roles')
            ->where('nombre', 'Consulta')
            ->value('id');

        $permisosConsulta = DB::table('permisos')
            ->whereIn('nombre', [
                'productos.ver',
            ])
            ->pluck('id');

        foreach ($permisosConsulta as $permisoId) {
            DB::table('rol_permiso')->updateOrInsert(
                [
                    'rol_id' => $consulta,
                    'permiso_id' => $permisoId,
                ],
                [
                    'rol_id' => $consulta,
                    'permiso_id' => $permisoId,
                ]
            );
        }
    }
}
