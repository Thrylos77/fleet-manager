<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTO\VehicleData;
use App\Models\Vehicle;

class UpdateVehicleAction
{
    /**
     * Met à jour un véhicule existant.
     */
    public function execute(Vehicle $vehicle, VehicleData $data): Vehicle
    {
        $vehicle->update([
            'registration_number' => $data->registrationNumber,
            'brand' => $data->brand,
            'model' => $data->model,
            'year' => $data->year,
            'vehicle_type' => $data->vehicleType,
            'fuel_type' => $data->fuelType,
            'color' => $data->color,
            'mileage_km' => $data->mileageKm,
            'registration_date' => $data->registrationDate,
            'status' => $data->status,
            'notes' => $data->notes,
        ]);

        return $vehicle;
    }
}
