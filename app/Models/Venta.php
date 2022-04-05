<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_cliente',
        'ciudad_cliente',
        'telefono_cliente',
        'plataforma_id',
        'comision_ml',
        'promo_id',
        'status',
    ];
}
