<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plataforma extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
