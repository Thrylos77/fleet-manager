<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AssignmentStatusEnum;
use App\Enums\FuelTypeEnum;
use App\Enums\VehicleStatusEnum;
use App\Enums\VehicleTypeEnum;
use App\Traits\HasAuditTrail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasAuditTrail, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'registration_number',
        'brand',
        'model',
        'year',
        'vehicle_type',
        'fuel_type',
        'color',
        'mileage_km',
        'registration_date',
        'status',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'vehicle_type' => VehicleTypeEnum::class,
            'fuel_type' => FuelTypeEnum::class,
            'status' => VehicleStatusEnum::class,
            'year' => 'integer',
            'mileage_km' => 'integer',
            'registration_date' => 'date',
        ];
    }

    // =========================================================================
    // Relations
    // =========================================================================

    /**
     * Toutes les affectations (historique complet) de ce véhicule.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(VehicleAssignment::class);
    }

    /**
     * L'affectation active actuelle de ce véhicule (0 ou 1).
     */
    public function activeAssignment(): HasOne
    {
        return $this->hasOne(VehicleAssignment::class)
            ->where('status', AssignmentStatusEnum::Active);
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    /**
     * Véhicules disponibles (non affectés, non inactifs, non archivés).
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', VehicleStatusEnum::Available);
    }

    /**
     * Véhicules actuellement affectés à un chauffeur.
     */
    public function scopeAssigned(Builder $query): Builder
    {
        return $query->where('status', VehicleStatusEnum::Assigned);
    }

    /**
     * Véhicules « en service » (tout sauf inactive et archived).
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotIn('status', [
            VehicleStatusEnum::Inactive,
            VehicleStatusEnum::Archived,
        ]);
    }
}
