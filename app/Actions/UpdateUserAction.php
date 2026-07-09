<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTO\UserData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUserAction
{
    /**
     * Met à jour un utilisateur existant.
     */
    public function execute(User $user, UserData $data): User
    {
        $updateData = [
            'name' => $data->name,
            'username' => $data->username,
            'email' => $data->email,
            'phone' => $data->phone,
            'status' => $data->status,
        ];

        if (!empty($data->password)) {
            $updateData['password'] = Hash::make($data->password);
        }

        $user->update($updateData);

        if ($data->roles !== null) {
            $user->syncRoles($data->roles);
        }

        return $user;
    }
}
