<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\AssignmentTypeEnum;
use Carbon\Carbon;

readonly class AssignVehicleData
{
    public function __construct(
        public int $vehicleId,
        public int $driverId,
        public Carbon $startDate,
        public ?Carbon $endDate = null,
        public AssignmentTypeEnum $assignmentType = AssignmentTypeEnum::Primary,
        public ?string $notes = null,
        public ?int $assignedBy = null,
    ) {
    }
}
