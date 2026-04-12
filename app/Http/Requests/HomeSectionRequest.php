<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeSectionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $required = $isUpdate ? 'sometimes' : 'required';

        return [
            'title'     => "{$required}|string|max:255",
            'key'       => "{$required}|string|max:100",
            'type'      => "{$required}|in:banner,store_list,food_list,service_list,promo,custom",
            'order'     => 'sometimes|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ];
    }
}
