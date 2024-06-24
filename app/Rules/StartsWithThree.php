<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StartsWithThree implements Rule
{
    public function passes($attribute, $value)
    {
        return substr($value, 0, 1) === '3';
    }

    public function message()
    {
        return 'El número del documento debe comenzar con 3.';
    }
}
