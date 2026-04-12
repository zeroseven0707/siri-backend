<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodItemRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $required = $isUpdate ? 'sometimes' : 'required';

        return [
            'name'         => "{$required}|string|max:255",
            'price'        => "{$required}|numeric|min:0",
            'description'  => 'nullable|string',
            'image'        => 'nullable|string',
            'is_available' => 'sometimes|boolean',
        ];
    }
}
