<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'nombre',
        'descripcion',
    ];

    protected $collection = 'categorias';

    public function empresas()
    {
        return $this->hasMany(Empresas::class,'ciudad_id');
    }
}
