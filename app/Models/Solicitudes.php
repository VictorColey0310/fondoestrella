<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Solicitudes extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'user_id',
        'empresa_id',
        'fecha_inicio',
        'fecha_fin',
        'descripcion',
        'archivo',
        'tipo',
        'estado',
        'plan_id'
    
    ];

    protected $collection = 'solicitudes';
    public function usuario()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
