<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\AssignmentTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // L'autorisation sera gérée par les Policies, mais on met true pour l'instant
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'driver_id' => ['required', 'integer', 'exists:drivers,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'assignment_type' => ['nullable', 'string', Rule::enum(AssignmentTypeEnum::class)],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'start_date.after_or_equal' => 'La date de début ne peut pas être dans le passé.',
            'end_date.after_or_equal' => 'La date de fin doit être ultérieure ou égale à la date de début.',
            'vehicle_id.exists' => 'Le véhicule sélectionné n\'existe pas.',
            'driver_id.exists' => 'Le chauffeur sélectionné n\'existe pas.',
        ];
    }
}
