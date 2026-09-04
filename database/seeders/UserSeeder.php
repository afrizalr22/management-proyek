<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::updateOrCreate(
            [
                'email' => 'owner@gmail.com',
            ],
            [
                'name' => 'Owner',
                'password' => Hash::make('password'),
            ]
        );

        $owner->syncRoles(['owner']);

        $mandor = User::updateOrCreate(
            [
                'email' => 'mandor@gmail.com',
            ],
            [
                'name' => 'Mandor',
                'password' => Hash::make('password'),
            ]
        );

        $mandor->syncRoles(['mandor']);

        $pekerja = User::updateOrCreate(
            [
                'email' => 'pekerja@gmail.com',
            ],
            [
                'name' => 'Pekerja',
                'password' => Hash::make('password'),
            ]
        );

        $pekerja->syncRoles(['pekerja']);
    }
}