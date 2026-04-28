<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'name'            => 'sometimes|string|max:255',
            'email'           => "sometimes|email|unique:users,email,{$userId},id",
            'phone'           => "sometimes|string|max:20|unique:users,phone,{$userId},id",
            'address'         => 'sometimes|nullable|string|max:500',
            'latitude'        => 'sometimes|nullable|numeric|between:-90,90',
            'longitude'       => 'sometimes|nullable|numeric|between:-180,180',
            'profile_picture' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp,heic,heif|max:5120',
        ];
    }
}
