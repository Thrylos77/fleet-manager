<?php

declare(strict_types=1);

namespace App\Enums;

enum AssignmentStatusEnum: string
{
    case Pending = 'pending';
    case Active = 'active';
    case Ended = 'ended';
    case Cancelled = 'cancelled';

    /**
     * Libellé lisible pour l'affichage UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::Pending => 'En attente',
            self::Active => 'Active',
            self::Ended => 'Terminée',
            self::Cancelled => 'Annulée',
        };
    }
}
