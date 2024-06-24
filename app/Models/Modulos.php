<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Modulos extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'nombre',
        'descripcion',
        'icono',
        'usuario_creador',
        'usuario_actualizador',
        'estado'
    ];

    protected $collection = 'modulos';
    public function roles()
    {
        return $this->belongsToMany(Roles::class,null,'modulos_ids', 'roles_ids');
    }

    public function creador()
    {
        return $this->belongsTo(User::class,'usuario_creador');
    }
    public function actualizador()
    {
        return $this->belongsTo(User::class,'usuario_actualizador');
    }
    
    public function submodulos(){
        return $this->hasMany(Submodulos::class,'modulo_id');
    }
}
