<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'casillero',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
