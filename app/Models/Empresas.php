<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'nit',
        'descripcion',
        'usuario_creador',
        'usuario_actualizador',
        'estado',
        'ciiu',
        'direccion',
        'ciudad_id',
        'categoria_id',
        'numero_trabajadores',
        'riesgo',
        'email_facturacion',
        'color',
        'logo'

    ];

    protected $collection = 'empresas';

    public function creador()
    {
        return $this->belongsTo(User::class,'usuario_creador');
    }
    public function actualizador()
    {
        return $this->belongsTo(User::class,'usuario_actualizador');
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class,null,'empresas_ids', 'usuarios_ids');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudades::class,'ciudad_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categorias::class,'categoria_id');
    }

    public function estandarizacion(){
        return $this->belongsToMany(Estandares::class,null,'empresas_ids', 'estandares_ids');
    }
    public function caracterizacion(){
        return $this->belongsToMany(Caracterizacion_empresa::class,null,'empresas_ids', 'caracterizacion_ids');
    }

}
