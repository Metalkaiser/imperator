<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'codigo',
        'nombre',
        'provider_id',
        'descripcion',
        'precio',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function compras()
    {
        return $this->hasMany(Talla_cantidad_compra::class);
    }

    public function ventas()
    {
        return $this->hasMany(Talla_cantidad_venta::class);
    }
}
