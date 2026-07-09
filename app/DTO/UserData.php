<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\UserStatusEnum;

readonly class UserData
{
    public function __construct(
        public string $name,
        public string $username,
        public string $email,
        public ?string $phone = null,
        public UserStatusEnum $status = UserStatusEnum::Active,
        public ?string $password = null,
        public ?array $roles = null,
    ) {
    }
}
