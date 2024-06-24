<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class CIIU extends Model
{
    use HasFactory;
    
    protected $fillable = [ 
        'codigo',
        'actividad',
        'riesgo',
    ];

    protected $collection = 'CIIU';

  
}
