<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTO\UserData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    /**
     * Crée un nouvel utilisateur.
     */
    public function execute(UserData $data): User
    {
        $user = User::create([
            'name' => $data->name,
            'username' => $data->username,
            'email' => $data->email,
            'phone' => $data->phone,
            'status' => $data->status,
            'password' => Hash::make($data->password),
        ]);

        if ($data->roles !== null) {
            $user->syncRoles($data->roles);
        }

        return $user;
    }
}
