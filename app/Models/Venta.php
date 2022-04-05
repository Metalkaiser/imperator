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

    public function ventas()
    {
        return $this->hasMany(Talla_cantidad_venta::class);
    }

    public function envios()
    {
        return $this->hasMany(Envio_venta::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago_venta::class);
    }

    public function promociones()
    {
        return $this->belongsTo(Promo::class);
    }

    public function plataformas()
    {
        return $this->belongsTo(Plataforma::class);
    }
}
