<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $this->configureOwnerPermissions();
        $this->configureMandorPermissions();
        $this->configurePekerjaPermissions();

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();
    }

    private function configureOwnerPermissions(): void
    {
        $owner = Role::findOrCreate('owner', 'web');

        $owner->syncPermissions([
            'view dashboard',

            'view-any users',
            'view users',
            'create users',
            'update users',
            'delete users',

            'view-any clients',
            'view clients',
            'create clients',
            'update clients',
            'delete clients',

            'view-any quotations',
            'view quotations',
            'create quotations',
            'update quotations',
            'delete quotations',
            'approve quotations',
            'reject quotations',

            'view-any projects',
            'view projects',
            'create projects',
            'update projects',
            'delete projects',
            'assign workers',

            'view-any tasks',
            'view tasks',

            'view-any project progress',
            'view project progress',

            'view-any daily reports',
            'view daily reports',

            'view-any documentations',
            'view documentations',

            'view-any invoices',
            'view invoices',
            'create invoices',
            'update invoices',
            'delete invoices',

            'view-any delivery orders',
            'view delivery orders',
            'create delivery orders',
            'update delivery orders',
            'delete delivery orders',

            'view profile',
            'update profile',
        ]);
    }

    private function configureMandorPermissions(): void
    {
        $mandor = Role::findOrCreate('mandor', 'web');

        $mandor->syncPermissions([
            'view dashboard',

            'view-any projects',
            'view projects',

            'view-any tasks',
            'view tasks',
            'create tasks',
            'update tasks',
            'delete tasks',

            'view-any project progress',
            'view project progress',

            'view-any daily reports',
            'view daily reports',
            'review daily reports',
            'approve daily reports',
            'request daily report revisions',

            'view-any documentations',
            'view documentations',

            'view profile',
            'update profile',
        ]);
    }

    private function configurePekerjaPermissions(): void
    {
        $pekerja = Role::findOrCreate('pekerja', 'web');

        $pekerja->syncPermissions([
            'view dashboard',

            'view projects',

            'view tasks',
            'start tasks',
            'submit tasks',

            'view project progress',

            'view daily reports',
            'create daily reports',
            'update daily reports',
            'delete daily reports',
            'submit daily reports',

            'view documentations',
            'upload documentations',
            'delete documentations',

            'view profile',
            'update profile',
        ]);
    }
}