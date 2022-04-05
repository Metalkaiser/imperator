<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'defectuosos',
        'precio',
        'provider_id',
        'carrier_id',
        'costo_envio',
        'total',
        'status',
    ];
}
