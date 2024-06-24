<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Apariencia extends Model
{
    use HasFactory;

    
    protected $fillable = [ 
        'color_boton',
        'color_menu',
        'color_letra',
        'color_letra_hover'
    ];

    protected $collection = 'apariencia';
}
