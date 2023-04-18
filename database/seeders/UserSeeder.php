<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $userPassword = '12345678';

        User::factory()->create([
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'user_type' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make($userPassword)
        ]);
    }
}
