<?php

namespace App\Http\Requests;

use App\Rules\CartHasItem;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['bail', 'required', new CartHasItem()],
            'customer_email' => 'bail|required|email',
            'customer_address' => 'bail|required'
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
