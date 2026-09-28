<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('articulo', 150);
            $table->string('codigo', 50)->unique();
            $table->foreignId('id_categoria')
                ->constrained('categorias')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->decimal('cantidad', 12, 2)->default(0);
            $table->enum('unidad_medida', [
                'individual',
                'caja'
            ])->default('individual');

            $table->unsignedInteger('piezas_por_caja')
                ->nullable();

            $table->unsignedInteger('cantidad_cajas')
                ->default(0);

            $table->date('fecha_alta');
            $table->boolean('stock')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
