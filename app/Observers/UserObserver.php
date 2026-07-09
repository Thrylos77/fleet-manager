<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "updated" event.
     * Synchronise les informations du compte utilisateur vers le profil chauffeur lié.
     */
    public function updated(User $user): void
    {
        if ($user->wasChanged(['name', 'email', 'phone']) && $user->driver()->exists()) {
            // Sépare le nom complet en prénom / nom pour le chauffeur (simplifié)
            $parts = explode(' ', trim($user->name), 2);
            $firstName = $parts[0] ?: 'Inconnu';
            $lastName = $parts[1] ?? '';

            $updateData = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $user->email,
            ];

            // Ne pas écraser le téléphone du chauffeur si l'utilisateur n'en a pas
            // (car driver.phone est obligatoire en base de données)
            if (!empty($user->phone)) {
                $updateData['phone'] = $user->phone;
            }

            $user->driver()->update($updateData);
        }
    }
}
