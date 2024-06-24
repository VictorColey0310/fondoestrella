<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'telefono',
        'direccion',
        'user_id',
        'empresa_id',
    ];

    protected $collection = 'contacto';
}
