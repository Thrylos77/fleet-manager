<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\VehicleData;
use App\Enums\FuelTypeEnum;
use App\Enums\VehicleStatusEnum;
use App\Enums\VehicleTypeEnum;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\Vehicle;
use App\Services\VehicleService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class VehicleController extends Controller
{
    public function __construct(
        protected VehicleService $vehicleService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json(Vehicle::all());
    }

    public function show(Vehicle $vehicle): JsonResponse
    {
        return response()->json($vehicle);
    }

    public function store(StoreVehicleRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $dto = new VehicleData(
            registrationNumber: $validated['registration_number'],
            brand: $validated['brand'],
            model: $validated['model'],
            year: (int) $validated['year'],
            vehicleType: VehicleTypeEnum::from($validated['vehicle_type']),
            fuelType: FuelTypeEnum::from($validated['fuel_type']),
            color: $validated['color'] ?? null,
            mileageKm: (int) ($validated['mileage_km'] ?? 0),
            registrationDate: isset($validated['registration_date']) ? Carbon::parse($validated['registration_date']) : null,
            status: isset($validated['status']) ? VehicleStatusEnum::from($validated['status']) : VehicleStatusEnum::Available,
            notes: $validated['notes'] ?? null,
        );

        $vehicle = $this->vehicleService->createVehicle($dto);

        return response()->json($vehicle, 201);
    }

    public function update(UpdateVehicleRequest $request, Vehicle $vehicle): JsonResponse
    {
        $validated = $request->validated();

        $dto = new VehicleData(
            registrationNumber: $validated['registration_number'],
            brand: $validated['brand'],
            model: $validated['model'],
            year: (int) $validated['year'],
            vehicleType: VehicleTypeEnum::from($validated['vehicle_type']),
            fuelType: FuelTypeEnum::from($validated['fuel_type']),
            color: $validated['color'] ?? null,
            mileageKm: (int) ($validated['mileage_km'] ?? 0),
            registrationDate: isset($validated['registration_date']) ? Carbon::parse($validated['registration_date']) : null,
            status: isset($validated['status']) ? VehicleStatusEnum::from($validated['status']) : VehicleStatusEnum::Available,
            notes: $validated['notes'] ?? null,
        );

        $vehicle = $this->vehicleService->updateVehicle($vehicle, $dto);

        return response()->json($vehicle);
    }

    public function destroy(Vehicle $vehicle): JsonResponse
    {
        try {
            $this->vehicleService->deleteVehicle($vehicle);
            return response()->json(null, 204);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
