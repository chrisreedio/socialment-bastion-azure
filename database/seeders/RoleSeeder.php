<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $defaultGuard = config('bastion.default_guard');
        $environment = App::environment();
        $roles = [
            [
                'name' => 'Developer',
                'guard_name' => $defaultGuard,
                'sso_group' => match ($environment) {
                    'local', 'staging' => '',
                    'production' => '',
                    default => null,
                },
            ],
            [
                'name' => 'Admin',
                'guard_name' => $defaultGuard,
                'sso_group' => match ($environment) {
                    'local', 'staging' => '',
                    'production' => '',
                    default => null,
                },
            ],
            [
                'name' => 'User',
                'guard_name' => $defaultGuard,
                'sso_group' => match ($environment) {
                    'local', 'staging' => '',
                    'production' => '',
                    default => null,
                },
            ],
            [
                'name' => 'Viewer',
                'guard_name' => $defaultGuard,
                'sso_group' => match ($environment) {
                    'local', 'staging' => '',
                    'production' => '',
                    default => null,
                },
            ],
        ];

        foreach ($roles as $role) {
            \Spatie\Permission\Models\Role::firstOrCreate([
                'name' => $role['name'],
            ], [
                'guard_name' => $role['guard_name'],
                'sso_group' => $role['sso_group'],
            ]);
        }
    }
}
