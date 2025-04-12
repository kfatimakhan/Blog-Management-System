<?php

namespace App\Http\Requests;

use Rules\Password;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$this->user->id],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->user->id],
        'profile_pic' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        'password' => ['nullable', 'confirmed', Password::defaults()],
    ];

    }
}
