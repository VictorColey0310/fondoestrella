<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class SubRoles extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'user_id',
        'empresa_id',
    ];

    protected $collection = 'subroles';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submodulos()
    {
        return $this->belongsToMany(Submodulos::class,null,'subroles_ids', 'submodulos_ids');
    }
}
