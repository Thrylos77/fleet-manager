<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // À gérer via Policies plus tard
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required', 'string', 'max:255',
                Rule::unique('users')->whereNull('deleted_at')
            ],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->whereNull('deleted_at')
            ],
            'phone' => [
                'nullable', 'string', 'max:255',
                Rule::unique('users')->whereNull('deleted_at')
            ],
            'status' => ['nullable', 'string', Rule::enum(UserStatusEnum::class)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ];
    }
}
