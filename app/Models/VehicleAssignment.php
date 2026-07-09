<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AssignmentStatusEnum;
use App\Enums\AssignmentTypeEnum;
use App\Traits\HasAuditTrail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleAssignment extends Model
{
    use HasAuditTrail, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'assigned_by',
        'start_date',
        'end_date',
        'status',
        'assignment_type',
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
            'status' => AssignmentStatusEnum::class,
            'assignment_type' => AssignmentTypeEnum::class,
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    // =========================================================================
    // Relations
    // =========================================================================

    /**
     * Le véhicule concerné par cette affectation.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Le chauffeur concerné par cette affectation.
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * L'utilisateur qui a réalisé l'affectation.
     */
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    /**
     * Affectations actuellement actives.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', AssignmentStatusEnum::Active);
    }

    /**
     * Affectations en attente d'activation.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', AssignmentStatusEnum::Pending);
    }

    /**
     * Affectations pour un véhicule donné.
     */
    public function scopeForVehicle(Builder $query, int $vehicleId): Builder
    {
        return $query->where('vehicle_id', $vehicleId);
    }

    /**
     * Affectations pour un chauffeur donné.
     */
    public function scopeForDriver(Builder $query, int $driverId): Builder
    {
        return $query->where('driver_id', $driverId);
    }
}
