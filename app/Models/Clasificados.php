<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Clasificados extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'imagen',
        'user_id',
        'empresa_id',
        'descripcion'
    ];

    protected $collection = 'clasificados';
}
