<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * Trait de traçabilité pour les modèles disposant de created_by / updated_by.
 *
 * Fournit :
 * - L'auto-fill de created_by et updated_by lors de la création.
 * - L'auto-fill de updated_by lors de la mise à jour.
 * - Les relations Eloquent createdBy() et updatedBy().
 */
trait HasAuditTrail
{
    public static function bootHasAuditTrail(): void
    {
        static::creating(function (self $model): void {
            if (Auth::check()) {
                $model->created_by ??= Auth::id();
                $model->updated_by ??= Auth::id();
            }
        });

        static::updating(function (self $model): void {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
