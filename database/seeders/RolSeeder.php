<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'nombre' => 'Administrador',
            ],
            [
                'nombre' => 'Almacenista',
            ],
            [
                'nombre' => 'Consulta',
            ],
        ];

        foreach ($roles as $rol) {
            DB::table('roles')->updateOrInsert(
                [
                    'nombre' => $rol['nombre'],
                ],
                $rol
            );
        }
    }
}
