<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Owner
        |--------------------------------------------------------------------------
        */

        $owner = User::firstOrCreate(
            ['email' => 'owner@gmail.com'],
            [
                'name' => 'Owner',
                'password' => Hash::make('password'),
            ]
        );

        $owner->assignRole('owner');

        /*
        |--------------------------------------------------------------------------
        | Mandor
        |--------------------------------------------------------------------------
        */

        $mandor = User::firstOrCreate(
            ['email' => 'mandor@gmail.com'],
            [
                'name' => 'Mandor',
                'password' => Hash::make('password'),
            ]
        );

        $mandor->assignRole('mandor');

        /*
        |--------------------------------------------------------------------------
        | Pekerja
        |--------------------------------------------------------------------------
        */

        $worker = User::firstOrCreate(
            ['email' => 'pekerja@gmail.com'],
            [
                'name' => 'Pekerja',
                'password' => Hash::make('password'),
            ]
        );

        $worker->assignRole('pekerja');
    }
}