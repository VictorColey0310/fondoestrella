<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Iconos extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'nombre',
        'icono',
        'codigo'
    ];

    protected $collection = 'iconos';
}
