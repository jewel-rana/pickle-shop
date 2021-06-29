<?php

namespace App\Http\Requests;

use App\Rules\BDMobile;
use App\Rules\OrderDeliverable;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderDeliveryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => ['bail', 'required', 'integer', 'exists:orders,id', new OrderDeliverable()],
            'delivery_man_name' => 'bail|required|string',
            'delivery_man_mobile' => ['bail', 'required', new BDMobile()]
        ];
    }

    protected function failedValidation(Validator $validator) {
        $response = [
            'success' => false,
            'message' => __('Validation failed'),
            'errors' => $validator->errors()
        ];
        throw new HttpResponseException(response()->json($response, 422));
    }
}
