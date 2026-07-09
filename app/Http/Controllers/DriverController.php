<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\DriverData;
use App\Enums\DriverStatusEnum;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\Driver;
use App\Services\DriverService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class DriverController extends Controller
{
    public function __construct(
        protected DriverService $driverService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json(Driver::all());
    }

    public function show(Driver $driver): JsonResponse
    {
        return response()->json($driver);
    }

    public function store(StoreDriverRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $dto = new DriverData(
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            phone: $validated['phone'],
            licenseNumber: $validated['license_number'],
            licenseCategory: $validated['license_category'],
            userId: isset($validated['user_id']) ? (int) $validated['user_id'] : null,
            email: $validated['email'] ?? null,
            licenseExpiryDate: isset($validated['license_expiry_date']) ? Carbon::parse($validated['license_expiry_date']) : null,
            status: isset($validated['status']) ? DriverStatusEnum::from($validated['status']) : DriverStatusEnum::Available,
            address: $validated['address'] ?? null,
            hireDate: isset($validated['hire_date']) ? Carbon::parse($validated['hire_date']) : null,
            notes: $validated['notes'] ?? null,
        );

        $driver = $this->driverService->createDriver($dto);

        return response()->json($driver, 201);
    }

    public function update(UpdateDriverRequest $request, Driver $driver): JsonResponse
    {
        $validated = $request->validated();

        $dto = new DriverData(
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            phone: $validated['phone'],
            licenseNumber: $validated['license_number'],
            licenseCategory: $validated['license_category'],
            userId: isset($validated['user_id']) ? (int) $validated['user_id'] : null,
            email: $validated['email'] ?? null,
            licenseExpiryDate: isset($validated['license_expiry_date']) ? Carbon::parse($validated['license_expiry_date']) : null,
            status: isset($validated['status']) ? DriverStatusEnum::from($validated['status']) : DriverStatusEnum::Available,
            address: $validated['address'] ?? null,
            hireDate: isset($validated['hire_date']) ? Carbon::parse($validated['hire_date']) : null,
            notes: $validated['notes'] ?? null,
        );

        $driver = $this->driverService->updateDriver($driver, $dto);

        return response()->json($driver);
    }

    public function destroy(Driver $driver): JsonResponse
    {
        try {
            $this->driverService->deleteDriver($driver);
            return response()->json(null, 204);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
