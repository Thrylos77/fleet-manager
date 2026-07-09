<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\AssignVehicleData;
use App\Enums\AssignmentTypeEnum;
use App\Http\Requests\StoreVehicleAssignmentRequest;
use App\Services\AssignmentService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class VehicleAssignmentController extends Controller
{
    public function __construct(
        protected AssignmentService $assignmentService
    ) {
    }

    /**
     * Assigne un chauffeur à un véhicule.
     */
    public function store(StoreVehicleAssignmentRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $dto = new AssignVehicleData(
            vehicleId: (int) $validated['vehicle_id'],
            driverId: (int) $validated['driver_id'],
            startDate: Carbon::parse($validated['start_date']),
            endDate: isset($validated['end_date']) ? Carbon::parse($validated['end_date']) : null,
            assignmentType: isset($validated['assignment_type']) 
                ? AssignmentTypeEnum::from($validated['assignment_type']) 
                : AssignmentTypeEnum::Primary,
            notes: $validated['notes'] ?? null,
            assignedBy: Auth::id(),
        );

        try {
            $assignment = $this->assignmentService->assignVehicle($dto);

            return response()->json([
                'message' => 'Affectation créée avec succès.',
                'assignment' => $assignment
            ], 201);

        } catch (\InvalidArgumentException $e) {
            // Règle d'Or violée (véhicule ou chauffeur déjà affecté)
            return response()->json([
                'message' => 'Erreur de validation métier.',
                'error' => $e->getMessage()
            ], 422);

        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Une erreur inattendue est survenue lors de l\'affectation.',
                'error' => $e->getMessage() // À masquer en production
            ], 500);
        }
    }
}
