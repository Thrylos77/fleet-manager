<?php

declare(strict_types=1);

namespace App\Enums;

enum FuelTypeEnum: string
{
    case Petrol = 'petrol';
    case Diesel = 'diesel';
    case Hybrid = 'hybrid';
    case Electric = 'electric';
    case Lpg = 'lpg';
    case Other = 'other';

    /**
     * Libellé lisible pour l'affichage UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::Petrol => 'Essence',
            self::Diesel => 'Diesel',
            self::Hybrid => 'Hybride',
            self::Electric => 'Électrique',
            self::Lpg => 'GPL',
            self::Other => 'Autre',
        };
    }
}
