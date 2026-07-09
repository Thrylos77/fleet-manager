<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\DriverStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDriverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => [
                'nullable', 'integer', 'exists:users,id',
                Rule::unique('drivers')->whereNull('deleted_at')
            ],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => [
                'required', 'string', 'max:255',
                Rule::unique('drivers')->whereNull('deleted_at')
            ],
            'email' => [
                'nullable', 'email', 'max:255',
                Rule::unique('drivers')->whereNull('deleted_at')
            ],
            'license_number' => [
                'required', 'string', 'max:255',
                Rule::unique('drivers')->whereNull('deleted_at')
            ],
            'license_category' => ['required', 'string', 'max:255'],
            'license_expiry_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', Rule::enum(DriverStatusEnum::class)],
            'address' => ['nullable', 'string'],
            'hire_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
