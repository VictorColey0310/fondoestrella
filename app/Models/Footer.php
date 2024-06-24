<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'url',
        'user_id',
        'empresa_id',
    ];

    protected $collection = 'footer';
}
