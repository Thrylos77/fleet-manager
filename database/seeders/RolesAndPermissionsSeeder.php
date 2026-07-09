<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Réinitialiser le cache des rôles et des permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Création des permissions
        $permissions = [
            'users.view', 'users.create', 'users.update', 'users.delete',
            'vehicles.view', 'vehicles.create', 'vehicles.update', 'vehicles.delete',
            'drivers.view', 'drivers.create', 'drivers.update', 'drivers.delete',
            'assignments.view', 'assignments.manage',
            'roles.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Création des rôles et assignation des permissions

        // Rôle : Admin (Accès total)
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        $roleAdmin->givePermissionTo(Permission::all());

        // Rôle : Manager (Consultation globale + gestion partielle)
        $roleManager = Role::firstOrCreate(['name' => 'Manager']);
        $roleManager->givePermissionTo([
            'users.view',
            'vehicles.view',
            'drivers.view',
            'assignments.view',
        ]);

        // Rôle : Fleet Manager (Gestionnaire de parc, utilisateur métier principal)
        $roleFleetManager = Role::firstOrCreate(['name' => 'Fleet Manager']);
        $roleFleetManager->givePermissionTo([
            'vehicles.view', 'vehicles.create', 'vehicles.update', 'vehicles.delete',
            'drivers.view', 'drivers.create', 'drivers.update', 'drivers.delete',
            'assignments.view', 'assignments.manage',
        ]);

        // Rôle : Driver (Chauffeur, accès très limité)
        // Les permissions réelles d'un chauffeur se font souvent via Policy (ex: viewOwnProfile)
        $roleDriver = Role::firstOrCreate(['name' => 'Driver']);
        // Pas de permission globale pour le moment.
    }
}
