<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago_compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'compra_id',
        'tipo',
        'referencia',
        'monto',
        'moneda',
    ];
}
