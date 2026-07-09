<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTO\AssignVehicleData;
use App\Enums\AssignmentStatusEnum;
use App\Enums\DriverStatusEnum;
use App\Enums\VehicleStatusEnum;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class AssignDriverToVehicleAction
{
    /**
     * Crée une affectation et met à jour les statuts de manière transactionnelle.
     *
     * @param AssignVehicleData $data
     * @return VehicleAssignment
     * @throws \Exception
     */
    public function execute(AssignVehicleData $data): VehicleAssignment
    {
        return DB::transaction(function () use ($data) {
            // 1. Verrouillage pessimiste pour éviter les conditions de course
            $vehicle = Vehicle::where('id', $data->vehicleId)->lockForUpdate()->firstOrFail();
            $driver = Driver::where('id', $data->driverId)->lockForUpdate()->firstOrFail();

            // 2. Vérification applicative (La Règle d'Or)
            if ($vehicle->activeAssignment()->exists()) {
                throw new InvalidArgumentException("Le véhicule {$vehicle->registration_number} a déjà une affectation active.");
            }

            if ($driver->activeAssignment()->exists()) {
                throw new InvalidArgumentException("Le chauffeur {$driver->full_name} a déjà une affectation active.");
            }

            // 3. Création de l'affectation
            $assignment = VehicleAssignment::create([
                'vehicle_id' => $data->vehicleId,
                'driver_id' => $data->driverId,
                'start_date' => $data->startDate,
                'end_date' => $data->endDate,
                'assignment_type' => $data->assignmentType,
                'notes' => $data->notes,
                'assigned_by' => $data->assignedBy,
                'status' => AssignmentStatusEnum::Active,
            ]);

            // 4. Mise à jour des statuts
            $vehicle->update(['status' => VehicleStatusEnum::Assigned]);
            $driver->update(['status' => DriverStatusEnum::Assigned]);

            return $assignment;
        });
    }
}
