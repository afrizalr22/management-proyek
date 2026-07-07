<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         /*
        |--------------------------------------------------------------------------
        | OWNER
        |--------------------------------------------------------------------------
        */

        $owner = Role::findByName('owner');

        $owner->syncPermissions([

            // Dashboard
            'view dashboard',

            // User
            'view-any users',
            'view users',
            'create users',
            'update users',
            'delete users',

            // Client
            'view-any clients',
            'view clients',
            'create clients',
            'update clients',
            'delete clients',

            // Project
            'view-any projects',
            'view projects',
            'create projects',
            'update projects',
            'delete projects',
            'assign workers',

            // Project Progress
            'view-any project progress',
            'view project progress',

            // Daily Report
            'view-any daily reports',
            'view daily reports',

            // Documentation
            'view-any documentations',
            'view documentations',

            // Quotation
            'view-any quotations',
            'view quotations',
            'create quotations',
            'update quotations',
            'delete quotations',

            // Invoice
            'view-any invoices',
            'view invoices',
            'create invoices',
            'update invoices',
            'delete invoices',

            // Delivery Order
            'view-any delivery orders',
            'view delivery orders',
            'create delivery orders',
            'update delivery orders',
            'delete delivery orders',

            // Profile
            'view profile',
            'update profile',
        ]);

        /*
        |--------------------------------------------------------------------------
        | MANDOR
        |--------------------------------------------------------------------------
        */

        $mandor = Role::findByName('mandor');

        $mandor->syncPermissions([

            'view dashboard',

            'view-any projects',
            'view projects',

            'view-any project progress',
            'view project progress',
            'create project progress',
            'update project progress',
            'delete project progress',

            'view-any daily reports',
            'view daily reports',
            'create daily reports',
            'update daily reports',
            'delete daily reports',

            'view-any documentations',
            'view documentations',
            'upload documentations',
            'delete documentations',

            'view delivery orders',

            'view profile',
            'update profile',
        ]);

        /*
        |--------------------------------------------------------------------------
        | PEKERJA
        |--------------------------------------------------------------------------
        */

        $pekerja = Role::findByName('pekerja');

        $pekerja->syncPermissions([

            'view dashboard',

            'view projects',

            'view project progress',

            'view documentations',
            'upload documentations',

            'view profile',
            'update profile',
        ]);
    }
}
