<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class TratamientoDatos extends Model
{
    use HasFactory;

    
    protected $fillable = [ 
        'nombre',
        'descripcion',
        'empresa_id',
        'url',
        'user_id'
    ];

    protected $collection = 'tratamientoDatos';

    public function usuario()
    {
        return $this->hasMany(User::class,'datos_id');
    }
}
