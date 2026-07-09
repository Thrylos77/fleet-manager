<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AssignmentStatusEnum;
use App\Enums\DriverStatusEnum;
use App\Traits\HasAuditTrail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasAuditTrail, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'license_number',
        'license_category',
        'license_expiry_date',
        'status',
        'address',
        'hire_date',
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
            'status' => DriverStatusEnum::class,
            'license_expiry_date' => 'date',
            'hire_date' => 'date',
        ];
    }

    // =========================================================================
    // Accessors
    // =========================================================================

    /**
     * Nom complet du chauffeur (prénom + nom).
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (): string => "{$this->first_name} {$this->last_name}",
        );
    }

    // =========================================================================
    // Relations
    // =========================================================================

    /**
     * Le compte applicatif lié à ce chauffeur (optionnel).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Toutes les affectations (historique complet) de ce chauffeur.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(VehicleAssignment::class);
    }

    /**
     * L'affectation active actuelle de ce chauffeur (0 ou 1).
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
     * Chauffeurs disponibles pour une nouvelle affectation.
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', DriverStatusEnum::Available);
    }

    /**
     * Chauffeurs actuellement affectés à un véhicule.
     */
    public function scopeAssigned(Builder $query): Builder
    {
        return $query->where('status', DriverStatusEnum::Assigned);
    }

    /**
     * Chauffeurs « en service » (tout sauf inactive et archived).
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotIn('status', [
            DriverStatusEnum::Inactive,
            DriverStatusEnum::Archived,
        ]);
    }
}
