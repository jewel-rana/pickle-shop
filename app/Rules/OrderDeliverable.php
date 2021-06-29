<?php

namespace App\Rules;

use App\Constants\AppConstant;
use App\Models\Order;
use Illuminate\Contracts\Validation\Rule;

class OrderDeliverable implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value): bool
    {
        return (bool) Order::doesnthave('activeDelivery')
            ->where('id', '=', $value)
            ->where('status', '=', AppConstant::ORDER_PENDING)->count();
    }

    public function message(): string
    {
        return __('Your order is not deliverable or already assigned delivery man');
    }
}
