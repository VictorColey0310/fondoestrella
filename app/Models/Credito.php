<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Credito extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo',
        'monto',
        'plazo_maximo',
        'tasa_interes',
        'tasa_preferencial',
        'novacion',
        'requisitos',
        'imagen',
        'user_id',
        'empresa_id',
    ];

    protected $collection = 'credito';
}
