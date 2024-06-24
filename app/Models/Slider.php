<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'imagen',
        'user_id',
        'empresa_id',
        'url'
    ];

    protected $collection = 'slider';

}
