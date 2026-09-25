<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Obtener roles
        |--------------------------------------------------------------------------
        */

        $administrador = DB::table('roles')
            ->where('nombre', 'Administrador')
            ->value('id');

        $almacenista = DB::table('roles')
            ->where('nombre', 'Almacenista')
            ->value('id');

        $consulta = DB::table('roles')
            ->where('nombre', 'Consulta')
            ->value('id');

        /*
        |--------------------------------------------------------------------------
        | Usuarios
        |--------------------------------------------------------------------------
        */

        $usuarios = [
            [
                'nombre' => 'Brenda',
                'apellido' => 'Ruiz',
                'id_rol' => $administrador,
                'no_empleado' => '840',
                'password' => Hash::make('0811'),
            ],

            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'id_rol' => $almacenista,
                'no_empleado' => '123',
                'password' => Hash::make('password123'),
            ],

            [
                'nombre' => 'María',
                'apellido' => 'García',
                'id_rol' => $consulta,
                'no_empleado' => '0410',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($usuarios as $usuario) {
            DB::table('usuarios')->updateOrInsert(
                [
                    'no_empleado' => $usuario['no_empleado'],
                ],
                $usuario
            );
        }
    }
}
