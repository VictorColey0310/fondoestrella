<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;


class GrupoConvenios extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'imagen',
        'user_id',
        'empresa_id',
    ];

    protected $collection = 'grupo_convenios';

    public function convenios(){
        return $this->hasMany(Convenios::class,'grupo_id');
    }
}
