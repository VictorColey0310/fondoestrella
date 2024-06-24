<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class RedesSociales extends Model
{

    use HasFactory;

    protected $fillable = [
        'url',
        'icono',
        'codigo',
        'user_id',
        'empresa_id',
        'nombre',
    ];

    protected $collection = 'redes_sociales';
}
