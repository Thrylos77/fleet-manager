<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTO\DriverData;
use App\Models\Driver;

class UpdateDriverAction
{
    /**
     * Met à jour un chauffeur existant.
     */
    public function execute(Driver $driver, DriverData $data): Driver
    {
        $driver->update([
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

        return $driver;
    }
}
