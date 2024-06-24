<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Header extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'url',
        'user_id',
        'empresa_id',
    ];

    protected $collection = 'header';
}
