<?php

namespace Database\Seeders;

use ChrisReedIO\Bastion\Bastion;
use ChrisReedIO\Bastion\Enums\DefaultPermissions;
use ChrisReedIO\Bastion\Resources\PermissionResource;
use ChrisReedIO\Bastion\Resources\RoleResource;
use ChrisReedIO\Bastion\Resources\UserResource;
use Filament\Facades\Filament;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Models\Role;

use function collect;
use function in_array;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $defaultGuard = config('bastion.default_guard');
        $environment = App::environment();

        // Ensure all permissions are generated
        Bastion::sync();

        $developerRole = Role::firstOrCreate(['name' => 'Developer'], [
            'guard_name' => $defaultGuard,
            'sso_group' => match ($environment) {
                'local', 'staging', 'production' => '',
                default => null,
            },
        ]);

        $adminRole = Role::firstOrCreate(['name' => 'Admin'], [
            'guard_name' => $defaultGuard,
            'sso_group' => match ($environment) {
                'local', 'staging', 'production' => '',
                default => null,
            },
        ]);

        $userRole = Role::firstOrCreate(['name' => 'User'], [
            'guard_name' => $defaultGuard,
            'sso_group' => match ($environment) {
                'local', 'staging', 'production' => '',
                default => null,
            },
        ]);

        $viewerRole = Role::firstOrCreate(['name' => 'Viewer'], [
            'guard_name' => $defaultGuard,
            'sso_group' => match ($environment) {
                'local', 'staging', 'production' => '',
                default => null,
            },
        ]);

        // Add all permissions except Role and Permission management to Admin
        $allResources = collect(Filament::getResources());

        // Admin
        if ($adminRole->permissions()->count() === 0) {
            $resources = $allResources->filter(function ($resource) {
                return ! in_array($resource, [
                    // UserResource::class,
                    RoleResource::class,
                    PermissionResource::class,
                ]);
            });
            $resources->each(function ($resource) use ($adminRole) {
                $resourcePermissions = Bastion::getResourcePermissions($resource);
                $adminRole->givePermissionTo($resourcePermissions);
            });
        }

        // User
        if ($userRole->permissions()->count() === 0) {
            $resources = $allResources->filter(function ($resource) {
                return ! in_array($resource, [
                    UserResource::class,
                    RoleResource::class,
                    PermissionResource::class,
                ]);
            });
            $resources->each(function ($resource) use ($userRole) {
                $resourcePermissions = Bastion::getResourcePermissions($resource, [
                    DefaultPermissions::ViewAny,
                    DefaultPermissions::View,
                    DefaultPermissions::Create,
                    DefaultPermissions::Update,
                    DefaultPermissions::Delete,
                ]);
                $userRole->givePermissionTo($resourcePermissions);
            });
        }

        // Viewer
        if ($viewerRole->permissions()->count() === 0) {
            $resources = $allResources->filter(function ($resource) {
                return ! in_array($resource, [
                    UserResource::class,
                    RoleResource::class,
                    PermissionResource::class,
                ]);
            });
            $resources->each(function ($resource) use ($viewerRole) {
                $resourcePermissions = Bastion::getResourcePermissions($resource, [
                    DefaultPermissions::ViewAny,
                    DefaultPermissions::View,
                ]);
                $viewerRole->givePermissionTo($resourcePermissions);
            });
        }

    }
}
