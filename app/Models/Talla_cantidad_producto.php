<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talla_cantidad_producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'talla',
        'cantidad',
    ];
}
