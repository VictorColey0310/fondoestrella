<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Cargos extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'nombre',
        'descripcion',
        'empresa_id'
    ];

    protected $collection = 'cargos';
}

