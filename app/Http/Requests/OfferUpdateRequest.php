<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferUpdateRequest extends FormRequest
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
            'type' => 'bail|required|in:discount,bulk_order,buy_one_get_one,min_amount',
            'min_order' => 'bail|required|integer|min:1',
            'amount' => 'bail|required|integer',
            'discount_type' => 'bail|required|in:fixed,percent',
            'offer_start' => 'bail|required|date_format:Y-m-d H:i:s',
            'offer_end' => 'bail|required|date_format:Y-m-d H:i:s',
            'product_ids' => 'bail|required|array'
        ];
    }
}
