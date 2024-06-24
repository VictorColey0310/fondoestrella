<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Tarjetas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'user_id',
        'empresa_id',
        'icono',
        'url'
    ];

    protected $collection = 'tarjetas';
}
