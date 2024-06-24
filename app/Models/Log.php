<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'usuario_actualizador',
        'consecutivo',
        'detalle',
        'empresa_id',
    ];

    protected $collection = 'log';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $ultimoConsecutivo = static::max('consecutivo');
        $this->attributes['consecutivo'] = $ultimoConsecutivo + 1;
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function usuarioActualizador()
    {
        return $this->belongsTo(User::class, 'usuario_actualizador');
    }
}
