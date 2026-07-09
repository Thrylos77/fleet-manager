<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'admin@fleetmanager.com'],
            [
                'name' => 'Administrateur',
                'username' => 'admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'status' => \App\Enums\UserStatusEnum::Active->value,
            ]
        );

        if (!$admin->hasRole('Admin')) {
            $admin->assignRole('Admin');
        }
    }
}
