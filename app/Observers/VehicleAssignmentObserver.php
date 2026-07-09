<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\AssignmentStatusEnum;
use App\Models\VehicleAssignment;
use InvalidArgumentException;

class VehicleAssignmentObserver
{
    /**
     * Handle the VehicleAssignment "creating" event.
     * Agit comme un filet de sécurité ultime au niveau applicatif.
     */
    public function creating(VehicleAssignment $assignment): void
    {
        // On ne vérifie la contrainte d'exclusivité que pour les affectations actives
        if ($assignment->status !== AssignmentStatusEnum::Active) {
            return;
        }

        $vehicleHasActive = VehicleAssignment::where('vehicle_id', $assignment->vehicle_id)
            ->where('status', AssignmentStatusEnum::Active)
            ->exists();

        if ($vehicleHasActive) {
            throw new InvalidArgumentException("Observer Alert : Le véhicule {$assignment->vehicle_id} a déjà une affectation active.");
        }

        $driverHasActive = VehicleAssignment::where('driver_id', $assignment->driver_id)
            ->where('status', AssignmentStatusEnum::Active)
            ->exists();

        if ($driverHasActive) {
            throw new InvalidArgumentException("Observer Alert : Le chauffeur {$assignment->driver_id} a déjà une affectation active.");
        }
    }
}
