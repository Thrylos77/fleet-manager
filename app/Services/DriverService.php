<?php

declare(strict_types=1);

namespace App\Services;

use App\Actions\CreateDriverAction;
use App\Actions\UpdateDriverAction;
use App\DTO\DriverData;
use App\Models\Driver;
use Illuminate\Support\Facades\Log;
use Throwable;

class DriverService
{
    public function __construct(
        protected CreateDriverAction $createAction,
        protected UpdateDriverAction $updateAction,
    ) {
    }

    /**
     * Crée un chauffeur.
     */
    public function createDriver(DriverData $data): Driver
    {
        try {
            $driver = $this->createAction->execute($data);
            Log::info("Chauffeur créé.", ['driver_id' => $driver->id]);
            return $driver;
        } catch (Throwable $e) {
            Log::error("Erreur création chauffeur.", ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Met à jour un chauffeur.
     */
    public function updateDriver(Driver $driver, DriverData $data): Driver
    {
        try {
            $driver = $this->updateAction->execute($driver, $data);
            Log::info("Chauffeur mis à jour.", ['driver_id' => $driver->id]);
            return $driver;
        } catch (Throwable $e) {
            Log::error("Erreur maj chauffeur.", ['driver_id' => $driver->id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Supprime un chauffeur.
     */
    public function deleteDriver(Driver $driver): bool
    {
        if ($driver->activeAssignment()->exists()) {
            throw new \InvalidArgumentException("Impossible de supprimer un chauffeur ayant une affectation active.");
        }

        $result = $driver->delete();
        Log::info("Chauffeur supprimé.", ['driver_id' => $driver->id]);
        return (bool) $result;
    }
}
