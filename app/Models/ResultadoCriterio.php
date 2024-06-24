<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class ResultadoCriterio extends Model
{
    use HasFactory;

    protected $fillable = [
        'imagen',
        'descripcion',
        'resultado',
        'criterio_id',
        'propuesta_id',
        'user_id',
        'empresa_id',
    ];

    protected $collection = 'resultados_criterios';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresas::class);
    }

public function propuesta()
    {
        return $this->belongsTo(Propuesta::class);
    }
    public function criterio()
    {
        return $this->belongsTo(Criterio::class);
    }
}
