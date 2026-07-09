<?php

declare(strict_types=1);

namespace App\Enums;

enum AssignmentTypeEnum: string
{
    case Primary = 'primary';
    case Temporary = 'temporary';
    case Replacement = 'replacement';

    /**
     * Libellé lisible pour l'affichage UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::Primary => 'Principale',
            self::Temporary => 'Temporaire',
            self::Replacement => 'Remplacement',
        };
    }
}
