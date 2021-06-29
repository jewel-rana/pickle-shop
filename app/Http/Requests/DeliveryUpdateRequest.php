<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'delivery_id' => 'bail|required|integer|exists:order_deliveries,id',
            'status' => 'bail|required|in:collected,processing,delivered,failed',
            'message' => 'bail|nullable|string'
        ];
    }
}
