<?php

declare(strict_types=1);

namespace App\Enums;

enum UserStatusEnum: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Suspended = 'suspended';

    /**
     * Libellé lisible pour l'affichage UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::Active => 'Actif',
            self::Inactive => 'Inactif',
            self::Suspended => 'Suspendu',
        };
    }
}
