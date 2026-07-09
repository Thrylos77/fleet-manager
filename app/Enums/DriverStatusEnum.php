<?php

declare(strict_types=1);

namespace App\Enums;

enum DriverStatusEnum: string
{
    case Available = 'available';
    case Assigned = 'assigned';
    case Unavailable = 'unavailable';
    case Inactive = 'inactive';
    case Archived = 'archived';

    /**
     * Libellé lisible pour l'affichage UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::Available => 'Disponible',
            self::Assigned => 'Affecté',
            self::Unavailable => 'Indisponible',
            self::Inactive => 'Inactif',
            self::Archived => 'Archivé',
        };
    }
}
