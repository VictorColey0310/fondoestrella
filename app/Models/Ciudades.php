<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Ciudades extends Model
{
    use HasFactory;
    
    protected $fillable = [ 
        'region',
        'codigo_dane_departamento',
        'departamento',
        'codigo_dane_municipio',
        'municipio',
        'estado'
    ];

    protected $collection = 'ciudades';

    public function empresas()
    {
        return $this->hasMany(Empresas::class,'ciudad_id');
    }
    public function usuarios()
    {
        return $this->hasMany(User::class,'municipioExp_id');
    }
}
