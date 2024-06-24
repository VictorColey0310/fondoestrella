<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class empresa_seleccionada extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'user_id',
        'empresa_id',
    ];

    protected $collection = 'empresas_seleccionada';

    public function empresa()
    {
        return $this->belongsTo(Empresas::class,'empresa_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
