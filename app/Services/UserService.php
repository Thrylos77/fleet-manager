<?php

declare(strict_types=1);

namespace App\Services;

use App\Actions\CreateUserAction;
use App\Actions\UpdateUserAction;
use App\DTO\UserData;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserService
{
    public function __construct(
        protected CreateUserAction $createAction,
        protected UpdateUserAction $updateAction,
    ) {
    }

    /**
     * Crée un utilisateur.
     */
    public function createUser(UserData $data): User
    {
        try {
            $user = $this->createAction->execute($data);
            Log::info("Utilisateur créé.", ['user_id' => $user->id]);
            return $user;
        } catch (Throwable $e) {
            Log::error("Erreur création utilisateur.", ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Met à jour un utilisateur.
     */
    public function updateUser(User $user, UserData $data): User
    {
        try {
            $user = $this->updateAction->execute($user, $data);
            Log::info("Utilisateur mis à jour.", ['user_id' => $user->id]);
            return $user;
        } catch (Throwable $e) {
            Log::error("Erreur maj utilisateur.", ['user_id' => $user->id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Supprime un utilisateur (soft delete).
     */
    public function deleteUser(User $user): bool
    {
        // Ne pas se supprimer soi-même
        if ($user->id === auth()->id()) {
            throw new \InvalidArgumentException("Impossible de supprimer votre propre compte.");
        }

        // On ne supprime pas un admin qui serait le dernier, mais ignorons pour l'instant
        $result = $user->delete();
        Log::info("Utilisateur supprimé.", ['user_id' => $user->id]);
        return (bool) $result;
    }
}
