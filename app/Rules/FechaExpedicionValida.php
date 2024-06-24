<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class FechaExpedicionValida implements Rule
{
    protected $fechaNacimiento;

    public function __construct($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function passes($attribute, $value)
    {
        if (!$this->fechaNacimiento) {
            return false;
        }

        $fechaNacimiento = Carbon::createFromFormat('Y-m-d', $this->fechaNacimiento);
        $fechaExpedicion = Carbon::createFromFormat('Y-m-d', $value);
      
        // Verificar que la fecha de expedición sea mayor a 18 años de la fecha de nacimiento
        return $fechaExpedicion->diffInYears($fechaNacimiento) >= 18;
    }

    public function message()
    {
        return 'La fecha de expedición debe ser mayor a 18 años de la fecha de nacimiento.';
    }
}
