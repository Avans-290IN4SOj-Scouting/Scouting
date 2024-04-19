<?php

namespace App\Http\Requests;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'old-password' => ['required'],
            'new-password' => ['required', Password::defaults()],
            'repeat-password' => ['required', 'same:new-password'],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'old-password' => [
                'required' => __('common.required', ['attribute' => __('auth/profile.current_password')]),
            ],
            'new-password' => [
                'required' => __('common.required', ['attribute' => __('auth/profile.new_password')]),
                'password' => __('auth/profile.password_requirements'),
            ],
            'repeat-password' => [
                'required' => __('common.required', ['attribute' => __('auth/profile.repeat_password')]),
                'same' => __('auth/profile.password_mismatch'),
            ],
        ];
    }
}
