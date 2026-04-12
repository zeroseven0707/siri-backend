<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'identifier'  => 'required|string',
            'password'    => 'required|string',
            'device'      => 'nullable|string|max:255',
            'platform'    => 'nullable|string|max:50',
            'app_version' => 'nullable|string|max:20',
        ];
    }
}
