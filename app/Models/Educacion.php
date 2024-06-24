<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Educacion extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'nivel',
        'titulo',
        'institucion',
        'ubicacion',
        'fecha_finalizacion',
        'estado',
        'observacionesNivel',
        'user_id',
        'certificado_nivel'
    ];

    protected $collection = 'educacion';
}
