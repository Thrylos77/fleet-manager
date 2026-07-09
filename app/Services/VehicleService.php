<?php

declare(strict_types=1);

namespace App\Services;

use App\Actions\CreateVehicleAction;
use App\Actions\UpdateVehicleAction;
use App\DTO\VehicleData;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Log;
use Throwable;

class VehicleService
{
    public function __construct(
        protected CreateVehicleAction $createAction,
        protected UpdateVehicleAction $updateAction,
    ) {
    }

    /**
     * Crée un véhicule et gère les processus associés.
     */
    public function createVehicle(VehicleData $data): Vehicle
    {
        try {
            $vehicle = $this->createAction->execute($data);
            Log::info("Véhicule créé.", ['vehicle_id' => $vehicle->id, 'registration' => $vehicle->registration_number]);
            return $vehicle;
        } catch (Throwable $e) {
            Log::error("Erreur création véhicule.", ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Met à jour un véhicule.
     */
    public function updateVehicle(Vehicle $vehicle, VehicleData $data): Vehicle
    {
        try {
            $vehicle = $this->updateAction->execute($vehicle, $data);
            Log::info("Véhicule mis à jour.", ['vehicle_id' => $vehicle->id]);
            return $vehicle;
        } catch (Throwable $e) {
            Log::error("Erreur maj véhicule.", ['vehicle_id' => $vehicle->id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Supprime un véhicule.
     */
    public function deleteVehicle(Vehicle $vehicle): bool
    {
        // On pourrait ajouter des vérifications ici (ex: pas d'affectation active)
        if ($vehicle->activeAssignment()->exists()) {
            throw new \InvalidArgumentException("Impossible de supprimer un véhicule avec une affectation active.");
        }

        $result = $vehicle->delete();
        Log::info("Véhicule supprimé.", ['vehicle_id' => $vehicle->id]);
        return (bool) $result;
    }
}
