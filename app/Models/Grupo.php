<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'criterio_ids',
        'user_id',
    ];

    protected $collection = 'grupos';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function criterios()
    {
        return $this->hasMany(Criterio::class, 'grupo_id');
    }
}


