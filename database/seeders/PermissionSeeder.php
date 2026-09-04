<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $permissions = [
            /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */

            'view dashboard',

            /*
            |--------------------------------------------------------------------------
            | Users
            |--------------------------------------------------------------------------
            */

            'view-any users',
            'view users',
            'create users',
            'update users',
            'delete users',

            /*
            |--------------------------------------------------------------------------
            | Clients
            |--------------------------------------------------------------------------
            */

            'view-any clients',
            'view clients',
            'create clients',
            'update clients',
            'delete clients',

            /*
            |--------------------------------------------------------------------------
            | Quotations
            |--------------------------------------------------------------------------
            */

            'view-any quotations',
            'view quotations',
            'create quotations',
            'update quotations',
            'delete quotations',
            'approve quotations',
            'reject quotations',

            /*
            |--------------------------------------------------------------------------
            | Projects
            |--------------------------------------------------------------------------
            */

            'view-any projects',
            'view projects',
            'create projects',
            'update projects',
            'delete projects',
            'assign workers',

            /*
            |--------------------------------------------------------------------------
            | Tasks
            |--------------------------------------------------------------------------
            */

            'view-any tasks',
            'view tasks',
            'create tasks',
            'update tasks',
            'delete tasks',
            'start tasks',
            'submit tasks',

            /*
            |--------------------------------------------------------------------------
            | Project Progress
            |--------------------------------------------------------------------------
            */

            'view-any project progress',
            'view project progress',

            /*
            |--------------------------------------------------------------------------
            | Daily Reports
            |--------------------------------------------------------------------------
            */

            'view-any daily reports',
            'view daily reports',
            'create daily reports',
            'update daily reports',
            'delete daily reports',
            'submit daily reports',
            'review daily reports',
            'approve daily reports',
            'request daily report revisions',

            /*
            |--------------------------------------------------------------------------
            | Documentations
            |--------------------------------------------------------------------------
            */

            'view-any documentations',
            'view documentations',
            'upload documentations',
            'delete documentations',

            /*
            |--------------------------------------------------------------------------
            | Invoices
            |--------------------------------------------------------------------------
            */

            'view-any invoices',
            'view invoices',
            'create invoices',
            'update invoices',
            'delete invoices',

            /*
            |--------------------------------------------------------------------------
            | Delivery Orders
            |--------------------------------------------------------------------------
            */

            'view-any delivery orders',
            'view delivery orders',
            'create delivery orders',
            'update delivery orders',
            'delete delivery orders',

            /*
            |--------------------------------------------------------------------------
            | Profile
            |--------------------------------------------------------------------------
            */

            'view profile',
            'update profile',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();
    }
}