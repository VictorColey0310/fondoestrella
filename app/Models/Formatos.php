<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Formatos extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'nombre',
        'descripcion',
        'archivo',
        'empresa_id',
        'experiencia_laboral'

    ];

    protected $collection = 'formatos';
}
