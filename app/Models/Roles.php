<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'user_id',
        'empresa_id',
        'rol_super',
        'lider',
        'rol_administrador',
        'aprobador_permisos'
    ];

    protected $collection = 'roles';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function modulos()
    {
        return $this->belongsToMany(Modulos::class,null,'roles_ids', 'modulos_ids');
    }

    public function usuarios()
    {
        return $this->hasMany(User::class,'rol_id');
    }

    public function submodulos()
    {
        return $this->belongsToMany(Submodulos::class,null,'roles_ids', 'submodulos_ids');
    }

}

