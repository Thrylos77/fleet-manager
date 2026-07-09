<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTO\DriverData;
use App\Models\Driver;

class CreateDriverAction
{
    /**
     * Crée un nouveau chauffeur.
     */
    public function execute(DriverData $data): Driver
    {
        return Driver::create([
            'user_id' => $data->userId,
            'first_name' => $data->firstName,
            'last_name' => $data->lastName,
            'phone' => $data->phone,
            'email' => $data->email,
            'license_number' => $data->licenseNumber,
            'license_category' => $data->licenseCategory,
            'license_expiry_date' => $data->licenseExpiryDate,
            'status' => $data->status,
            'address' => $data->address,
            'hire_date' => $data->hireDate,
            'notes' => $data->notes,
        ]);
    }
}
