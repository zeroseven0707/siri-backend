<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'service_id'           => 'required|uuid|exists:services,id',
            'pickup_location'      => 'required|string|max:500',
            'destination_location' => 'required|string|max:500',
            'price'                => 'required|numeric|min:0',
            'notes'                => 'nullable|string|max:1000',
            'food_items'           => 'nullable|array',
            'food_items.*.food_item_id' => 'required_with:food_items|uuid|exists:food_items,id',
            'food_items.*.qty'     => 'required_with:food_items|integer|min:1',
            'food_items.*.price'   => 'required_with:food_items|numeric|min:0',
        ];
    }
}
