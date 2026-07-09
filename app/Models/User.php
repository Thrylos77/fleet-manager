<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserStatusEnum;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'status',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatusEnum::class,
        ];
    }

    // =========================================================================
    // Relations
    // =========================================================================

    /**
     * Le profil chauffeur associé à ce compte (one-to-one optionnel).
     */
    public function driver(): HasOne
    {
        return $this->hasOne(Driver::class);
    }

    /**
     * Les véhicules créés par cet utilisateur.
     */
    public function createdVehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'created_by');
    }

    /**
     * Les véhicules modifiés en dernier par cet utilisateur.
     */
    public function updatedVehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'updated_by');
    }

    /**
     * Les chauffeurs créés par cet utilisateur.
     */
    public function createdDrivers(): HasMany
    {
        return $this->hasMany(Driver::class, 'created_by');
    }

    /**
     * Les chauffeurs modifiés en dernier par cet utilisateur.
     */
    public function updatedDrivers(): HasMany
    {
        return $this->hasMany(Driver::class, 'updated_by');
    }

    /**
     * Les affectations réalisées par cet utilisateur (assigned_by).
     */
    public function assignedAssignments(): HasMany
    {
        return $this->hasMany(VehicleAssignment::class, 'assigned_by');
    }

    /**
     * Les affectations créées par cet utilisateur (created_by).
     */
    public function createdAssignments(): HasMany
    {
        return $this->hasMany(VehicleAssignment::class, 'created_by');
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    /**
     * Filtre les utilisateurs avec un statut actif.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', UserStatusEnum::Active);
    }
}
