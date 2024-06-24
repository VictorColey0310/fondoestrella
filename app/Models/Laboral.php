<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Laboral extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'tipo',
        'nombre_empresa',
        'fecha_ingreso',
        'trabajo_actual',
        'fecha_retiro',
        'pais',
        'telefono',
        'cargo',
        'funciones_logros',
        'user_id',
        'certificado_laboral',
        'certificacion_laboral',
        'c'
    ];

    protected $collection = 'laboral';

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }    
}
