<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\FuelTypeEnum;
use App\Enums\VehicleStatusEnum;
use App\Enums\VehicleTypeEnum;
use Carbon\Carbon;

readonly class VehicleData
{
    public function __construct(
        public string $registrationNumber,
        public string $brand,
        public string $model,
        public int $year,
        public VehicleTypeEnum $vehicleType,
        public FuelTypeEnum $fuelType,
        public ?string $color = null,
        public int $mileageKm = 0,
        public ?Carbon $registrationDate = null,
        public VehicleStatusEnum $status = VehicleStatusEnum::Available,
        public ?string $notes = null,
    ) {
    }
}
