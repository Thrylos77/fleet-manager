<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user->id ?? $this->route('user');

        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required', 'string', 'max:255',
                Rule::unique('users')->ignore($userId)->whereNull('deleted_at')
            ],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($userId)->whereNull('deleted_at')
            ],
            'phone' => [
                'nullable', 'string', 'max:255',
                Rule::unique('users')->ignore($userId)->whereNull('deleted_at')
            ],
            'status' => ['nullable', 'string', Rule::enum(UserStatusEnum::class)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ];
    }
}
