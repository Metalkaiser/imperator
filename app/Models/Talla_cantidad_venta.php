<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talla_cantidad_venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id',
        'producto_id',
        'talla',
        'cantidad',
        'precio',
    ];

    public function productos()
    {
        return $this->belongsTo(Producto::class);
    }
}
