<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Noformal extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'user_id',
        'tipo_noformal',
        'institucion_noformal',
        'estado_noformal',
        'nombre_noformal',
        'duracion',
        'pais_noformal',
        'certificado_noformal'
    ];

    protected $collection = 'noformal';
}
