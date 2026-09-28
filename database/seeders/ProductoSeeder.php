<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           $categorias = DB::table('categorias')
            ->pluck('id', 'nombre');

        DB::table('productos')->insert([
            // =====================================================
            // HERRAMIENTAS
            // =====================================================

            [
                'articulo' => 'Martillo de uña 16 oz',
                'codigo' => 'HER-001',
                'id_categoria' => $categorias['Herramientas'],
                'cantidad' => 15,
                'unidad_medida' => 'individual',
                'piezas_por_caja' => null,
                'cantidad_cajas' => 0,
                'fecha_alta' => '2026-09-01',
                'stock' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'articulo' => 'Desarmador plano 6"',
                'codigo' => 'HER-002',
                'id_categoria' => $categorias['Herramientas'],
                'cantidad' => 25,
                'unidad_medida' => 'individual',
                'piezas_por_caja' => null,
                'cantidad_cajas' => 0,
                'fecha_alta' => '2026-09-02',
                'stock' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'articulo' => 'Pinzas de electricista 8"',
                'codigo' => 'HER-003',
                'id_categoria' => $categorias['Herramientas'],
                'cantidad' => 10,
                'unidad_medida' => 'individual',
                'piezas_por_caja' => null,
                'cantidad_cajas' => 0,
                'fecha_alta' => '2026-09-03',
                'stock' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'articulo' => 'Juego de llaves combinadas',
                'codigo' => 'HER-004',
                'id_categoria' => $categorias['Herramientas'],
                'cantidad' => 8,
                'unidad_medida' => 'caja',
                'piezas_por_caja' => 12,
                'cantidad_cajas' => 8,
                'fecha_alta' => '2026-09-04',
                'stock' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // =====================================================
            // MATERIAL ELÉCTRICO
            // =====================================================

            [
                'articulo' => 'Cable eléctrico calibre 12',
                'codigo' => 'ELE-001',
                'id_categoria' => $categorias['Material eléctrico'],
                'cantidad' => 500,
                'unidad_medida' => 'individual',
                'piezas_por_caja' => null,
                'cantidad_cajas' => 0,
                'fecha_alta' => '2026-09-05',
                'stock' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'articulo' => 'Contacto eléctrico sencillo',
                'codigo' => 'ELE-002',
                'id_categoria' => $categorias['Material eléctrico'],
                'cantidad' => 40,
                'unidad_medida' => 'caja',
                'piezas_por_caja' => 10,
                'cantidad_cajas' => 4,
                'fecha_alta' => '2026-09-06',
                'stock' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'articulo' => 'Apagador sencillo',
                'codigo' => 'ELE-003',
                'id_categoria' => $categorias['Material eléctrico'],
                'cantidad' => 30,
                'unidad_medida' => 'caja',
                'piezas_por_caja' => 10,
                'cantidad_cajas' => 3,
                'fecha_alta' => '2026-09-07',
                'stock' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // =====================================================
            // MATERIAL DE OFICINA
            // =====================================================

            [
                'articulo' => 'Bolígrafo tinta azul',
                'codigo' => 'OFI-001',
                'id_categoria' => $categorias['Material de oficina'],
                'cantidad' => 100,
                'unidad_medida' => 'caja',
                'piezas_por_caja' => 50,
                'cantidad_cajas' => 2,
                'fecha_alta' => '2026-09-08',
                'stock' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'articulo' => 'Cuaderno profesional',
                'codigo' => 'OFI-002',
                'id_categoria' => $categorias['Material de oficina'],
                'cantidad' => 30,
                'unidad_medida' => 'individual',
                'piezas_por_caja' => null,
                'cantidad_cajas' => 0,
                'fecha_alta' => '2026-09-09',
                'stock' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'articulo' => 'Paquete de hojas tamaño carta',
                'codigo' => 'OFI-003',
                'id_categoria' => $categorias['Material de oficina'],
                'cantidad' => 20,
                'unidad_medida' => 'caja',
                'piezas_por_caja' => 500,
                'cantidad_cajas' => 20,
                'fecha_alta' => '2026-09-10',
                'stock' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // =====================================================
            // CONSUMIBLES
            // =====================================================

            [
                'articulo' => 'Cinta adhesiva transparente',
                'codigo' => 'CON-001',
                'id_categoria' => $categorias['Consumibles'],
                'cantidad' => 50,
                'unidad_medida' => 'caja',
                'piezas_por_caja' => 10,
                'cantidad_cajas' => 5,
                'fecha_alta' => '2026-09-14',
                'stock' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'articulo' => 'Marcador permanente negro',
                'codigo' => 'CON-002',
                'id_categoria' => $categorias['Consumibles'],
                'cantidad' => 40,
                'unidad_medida' => 'caja',
                'piezas_por_caja' => 10,
                'cantidad_cajas' => 4,
                'fecha_alta' => '2026-09-15',
                'stock' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'articulo' => 'Batería alcalina AA',
                'codigo' => 'CON-003',
                'id_categoria' => $categorias['Consumibles'],
                'cantidad' => 0,
                'unidad_medida' => 'caja',
                'piezas_por_caja' => 20,
                'cantidad_cajas' => 0,
                'fecha_alta' => '2026-09-16',
                'stock' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // =====================================================
            // LIMPIEZA
            // =====================================================

            [
                'articulo' => 'Limpiador multiusos',
                'codigo' => 'LIM-001',
                'id_categoria' => $categorias['Limpieza'],
                'cantidad' => 24,
                'unidad_medida' => 'caja',
                'piezas_por_caja' => 6,
                'cantidad_cajas' => 4,
                'fecha_alta' => '2026-09-17',
                'stock' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'articulo' => 'Cloro',
                'codigo' => 'LIM-002',
                'id_categoria' => $categorias['Limpieza'],
                'cantidad' => 12,
                'unidad_medida' => 'individual',
                'piezas_por_caja' => null,
                'cantidad_cajas' => 0,
                'fecha_alta' => '2026-09-18',
                'stock' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'articulo' => 'Escoba industrial',
                'codigo' => 'LIM-003',
                'id_categoria' => $categorias['Limpieza'],
                'cantidad' => 6,
                'unidad_medida' => 'individual',
                'piezas_por_caja' => null,
                'cantidad_cajas' => 0,
                'fecha_alta' => '2026-09-19',
                'stock' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    
    }
}
