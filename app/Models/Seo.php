<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Seo extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'keyword',
        'favicon',
        'imagen_seo',
        'usuario_actualizador',
    ];
    protected $collection = 'seo';
}
