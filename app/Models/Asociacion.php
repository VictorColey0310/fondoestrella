<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Asociacion extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'url1',
        'user_id',
        'empresa_id',
        'url2'
    ];

    protected $collection = 'asociacion';
}
