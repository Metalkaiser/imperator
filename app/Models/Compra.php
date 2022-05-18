<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'carrier_id',
        'costo_envio',
        'total',
        'status',
    ];

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }

    public function compras()
    {
        return $this->hasMany(Talla_cantidad_compra::class);
    }

    public function pagos()
    {
        return $this->hasOne(Pago_compra::class);
    }
}
