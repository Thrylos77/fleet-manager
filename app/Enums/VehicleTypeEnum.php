<?php

declare(strict_types=1);

namespace App\Enums;

enum VehicleTypeEnum: string
{
    case Car = 'car';
    case Van = 'van';
    case Truck = 'truck';
    case Bus = 'bus';
    case Motorcycle = 'motorcycle';
    case Other = 'other';

    /**
     * Libellé lisible pour l'affichage UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::Car => 'Voiture',
            self::Van => 'Utilitaire',
            self::Truck => 'Camion',
            self::Bus => 'Bus',
            self::Motorcycle => 'Moto',
            self::Other => 'Autre',
        };
    }
}
