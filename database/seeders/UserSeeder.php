<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Database\Seeders\Data\UserData;

class UserSeeder extends Seeder
{

    private $userPassword = '12345678';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->createAdminUsers();
        $this->createDsUsers();
        $this->createGnUsers();
        $this->createSnUsers();
        
    }

    public function createAdminUsers() {

        $adminUsers = UserData::$adminUsers;
        $userType = 'admin';

        foreach($adminUsers as $adminUser) {

            User::factory()->create([
                'username' => $adminUser['username'],
                'first_name' => $adminUser['first_name'],
                'last_name' => $adminUser['last_name'],
                'user_type' => $userType,
                'email' => $adminUser['email'],
                'password' => Hash::make($this->userPassword)
            ]);

        }
    }

    public function createDsUsers() {

        $dsUsers = UserData::$dsUsers;
        $userType = 'ds';

        foreach($dsUsers as $dsUser) {

            User::factory()->create([
                'username' => $dsUser['username'],
                'first_name' => $dsUser['first_name'],
                'last_name' => $dsUser['last_name'],
                'user_type' => $userType,
                'email' => $dsUser['email'],
                'password' => Hash::make($this->userPassword)
            ]);

        }
    }

    public function createGnUsers() {
        
        $gnUsers = $this->getGnUserData();
        $userType = 'gn';

        foreach($gnUsers as $gnUser) {

            User::factory()->create([
                'username' => $gnUser['username'],
                'first_name' => $gnUser['first_name'],
                'last_name' => $gnUser['last_name'],
                'user_type' => $userType,
                'email' => $gnUser['email'],
                'password' => Hash::make($this->userPassword)
            ]);

        }
    }

    public function createSnUsers() {
        
        $snUsers = $this->getSnUserData();
        $userType = 'sn';

        foreach($snUsers as $snUser) {

            User::factory()->create([
                'username' => $snUser['username'],
                'first_name' => $snUser['first_name'],
                'last_name' => $snUser['last_name'],
                'user_type' => $userType,
                'email' => $snUser['email'],
                'password' => Hash::make($this->userPassword)
            ]);

        }
    }

    public function getGnUserData() {

        return UserData::$gnUsers;
        
    }

    public function getSnUserData() {

        return UserData::$snUsers;
    }
}