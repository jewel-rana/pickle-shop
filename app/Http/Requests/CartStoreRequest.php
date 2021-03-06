<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CartStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'bail|exists:products,id',
            'product_sku' => 'bail|exists:product_variants,sku',
            'qty' => 'bail|integer'
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
