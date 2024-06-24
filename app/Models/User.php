<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'documento',
        'name',
        'segundo_name',
        'primer_apellido',
        'segundo_apellido',
        'email',
        'password',
        'estado',
        'rol_id',
        'user_id',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function findForPassport($identifier)
    {
        return $this->where('documento', $identifier)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Rol()
    {
        return $this->belongsTo(Roles::class, 'rol_id');
    }

    public function empresas()
    {
        return $this->belongsToMany(Empresas::class, null, 'usuarios_ids', 'empresas_ids');
    }
    public function empresa_seleccionada()
    {
        return $this->hasMany(empresa_seleccionada::class, 'user_id');
    }
}
