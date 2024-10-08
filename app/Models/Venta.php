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
        return $this->hasOne(Envio_venta::class);
    }

    public function pagos()
    {
        return $this->hasOne(Pago_venta::class);
    }

    public function promociones()
    {
        return $this->belongsTo(Promo::class, 'promo_id');
    }

    public function plataformas()
    {
        return $this->belongsTo(Plataforma::class, 'plataforma_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'talla_cantidad_ventas');
    }
}
