<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Informacion extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'logo',
        'modelo',
        'instructivo',
        'nombre',
        'whatsapp',
        'terminos_condiciones',
        'politicas_privacidad',
        'usuario_actualizador',
    ];

    protected $collection = 'informacion';
}
