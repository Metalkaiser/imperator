<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talla_cantidad_compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'compra_id',
        'producto_id',
        'talla',
        'cantidad',
        'defectuosos',
        'precio',
        'provider_id',
    ];
}
