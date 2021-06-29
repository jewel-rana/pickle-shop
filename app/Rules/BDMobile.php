<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BDMobile implements Rule
{
    public function passes($attribute, $value): bool
    {
        return preg_match("/^(01){1}[3456789]{1}(\d){8}$/", $value);
    }

    public function message(): string
    {
        return ':attribute should be a valid Bangladeshi mobile number';
    }
}
