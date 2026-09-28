<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'articulo',
        'codigo',
        'id_categoria',
        'cantidad',
        'unidad_medida',
        'piezas_por_caja',
        'cantidad_cajas',
        'fecha_alta',
        'stock',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'fecha_alta' => 'date:d/m/Y',
        'stock' => 'boolean',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(
            Categoria::class,
            'id_categoria'
        );
    }
}