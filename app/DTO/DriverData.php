<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\DriverStatusEnum;
use Carbon\Carbon;

readonly class DriverData
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $phone,
        public string $licenseNumber,
        public string $licenseCategory,
        public ?int $userId = null,
        public ?string $email = null,
        public ?Carbon $licenseExpiryDate = null,
        public DriverStatusEnum $status = DriverStatusEnum::Available,
        public ?string $address = null,
        public ?Carbon $hireDate = null,
        public ?string $notes = null,
    ) {
    }
}
