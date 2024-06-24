<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Submodulos extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'nombre',
        'descripcion',
        'usuario_creador',
        'usuario_actualizador',
        'url',
        'estado',
        'modulo_id'
    ];

    
    protected $collection = 'submodulos';

    public function creador()
    {
        return $this->belongsTo(User::class,'usuario_creador');
    }
    public function actualizador()
    {
        return $this->belongsTo(User::class,'usuario_actualizador');
    }
    public function modulo()
    {
        return $this->belongsTo(Modulos::class,'modulo_id');
    }
    public function subroles()
    {
        return $this->belongsToMany(subRoles::class,null,'submodulos_ids', 'subroles_ids');
    }
}
