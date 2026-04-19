<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $required = $isUpdate ? 'sometimes' : 'required';

        return [
            'name'        => "{$required}|string|max:255",
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'address'     => "{$required}|string|max:500",
            'latitude'    => "{$required}|numeric|between:-90,90",
            'longitude'   => "{$required}|numeric|between:-180,180",
            'is_open'     => 'sometimes|boolean',
        ];
    }
}
