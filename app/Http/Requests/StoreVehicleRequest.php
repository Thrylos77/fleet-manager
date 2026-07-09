<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\FuelTypeEnum;
use App\Enums\VehicleStatusEnum;
use App\Enums\VehicleTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'registration_number' => [
                'required', 'string', 'max:255',
                Rule::unique('vehicles')->whereNull('deleted_at')
            ],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'vehicle_type' => ['required', 'string', Rule::enum(VehicleTypeEnum::class)],
            'fuel_type' => ['required', 'string', Rule::enum(FuelTypeEnum::class)],
            'color' => ['nullable', 'string', 'max:255'],
            'mileage_km' => ['nullable', 'integer', 'min:0'],
            'registration_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', Rule::enum(VehicleStatusEnum::class)],
            'notes' => ['nullable', 'string'],
        ];
    }
}
