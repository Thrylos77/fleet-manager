<?php

declare(strict_types=1);

namespace App\Services;

use App\Actions\AssignDriverToVehicleAction;
use App\DTO\AssignVehicleData;
use App\Models\VehicleAssignment;
use Illuminate\Support\Facades\Log;
use Throwable;

class AssignmentService
{
    public function __construct(
        protected AssignDriverToVehicleAction $assignAction
    ) {
    }

    /**
     * Orchestre l'affectation d'un véhicule à un chauffeur.
     *
     * @param AssignVehicleData $data
     * @return VehicleAssignment
     * @throws Throwable
     */
    public function assignVehicle(AssignVehicleData $data): VehicleAssignment
    {
        try {
            $assignment = $this->assignAction->execute($data);

            Log::info("Nouvelle affectation créée.", [
                'assignment_id' => $assignment->id,
                'vehicle_id' => $data->vehicleId,
                'driver_id' => $data->driverId,
                'assigned_by' => $data->assignedBy,
            ]);

            // Plus tard (V2) : Déclencher un event ou envoyer une notification ici

            return $assignment;

        } catch (Throwable $e) {
            Log::error("Échec lors de l'affectation du véhicule.", [
                'vehicle_id' => $data->vehicleId,
                'driver_id' => $data->driverId,
                'error' => $e->getMessage(),
            ]);
            
            throw $e;
        }
    }
}
