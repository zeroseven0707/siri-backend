<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeSectionItemRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $required = $isUpdate ? 'sometimes' : 'required';

        return [
            'title'        => 'nullable|string|max:255',
            'subtitle'     => 'nullable|string',
            'image'        => 'nullable|string',
            'action_type'  => 'nullable|in:route,url,store,food,service',
            'action_value' => 'nullable|string|max:500',
            'order'        => 'sometimes|integer|min:0',
            'is_active'    => 'sometimes|boolean',
        ];
    }
}
