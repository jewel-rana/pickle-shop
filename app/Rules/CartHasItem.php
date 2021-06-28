<?php

namespace App\Rules;

use App\Services\CartService;
use Illuminate\Contracts\Validation\Rule;

class CartHasItem implements Rule
{
    public function passes($attribute, $value): bool
    {
        return (bool) session()->has('carts');
    }

    public function message(): string
    {
        return __('Sorry! Your cart is empty');
    }
}
