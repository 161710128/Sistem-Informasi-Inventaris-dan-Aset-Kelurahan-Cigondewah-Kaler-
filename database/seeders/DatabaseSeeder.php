<?php

namespace Database\Seeders;

use App\models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'Muhammad Taufik',
                'username' => 'baplang',
                'email' => 'opik@gmail.com',
                'password' => Hash::make('admin'),
                'role' => 'admin'
            ]
        );
        User::create(
            [
                'name' => 'Muhammad Ali',
                'username' => 'ali',
                'email' => 'ali@gmail.com',
                'role' => 'lurah',
                'password' => Hash::make('lurah')
            ]
        );
    }
}
