<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
class Certificado extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'estado_territorio',
        'curso_alturas',
        'fecha_vencimiento',
        'curso_espacios_conf',
        'nivel_curso_espacios',
        'nivel_nccer',
        'especialidad_nccer',
        'certificado_nccer',
        'user_id',
        'certificado_alturas',
        'certificado_confinados',
        'fecha_vencimiento_confi',
        'fecha_vencimiento_nccer',
        'certificado_arc_nccer'
    ];

    protected $collection = 'certificados';

    
}
