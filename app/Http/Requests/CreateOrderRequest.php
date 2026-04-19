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
            'pickup_lat'           => 'nullable|numeric|between:-90,90',
            'pickup_lng'           => 'nullable|numeric|between:-180,180',
            'destination_location' => 'required|string|max:500',
            'destination_lat'      => 'nullable|numeric|between:-90,90',
            'destination_lng'      => 'nullable|numeric|between:-180,180',
            'price'                => 'required|numeric|min:0',
            'delivery_fee'         => 'nullable|numeric|min:0',
            'notes'                => 'nullable|string|max:1000',
            'food_items'           => 'nullable|array',
            'food_items.*.food_item_id' => 'required_with:food_items|uuid|exists:food_items,id',
            'food_items.*.qty'     => 'required_with:food_items|integer|min:1',
            'food_items.*.price'   => 'required_with:food_items|numeric|min:0',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $user = $this->user();
            if (
                empty($user->address) ||
                empty($user->latitude) ||
                empty($user->longitude)
            ) {
                $validator->errors()->add(
                    'location',
                    'Lengkapi alamat dan lokasi kamu terlebih dahulu sebelum memesan. Perbarui di halaman profil.'
                );
            }
        });
    }
}
