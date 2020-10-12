<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $testAdmin = User::create([
            'id' => 1,
            'name' => 'testadmin',
            'email' => 'testadmin@gmail.com',
            'password' => Hash::make('SiHDHoJuW8qE'),
        ]);

        $testUser = User::create([
            'id' => 2,
            'name' => 'testuser',
            'email' => 'testuser@gmail.com',
            'password' => Hash::make('mv6lRauSKLED'),
        ]);

        $testUser->attachRole(Role::USER_ROLE_SLUG);
        $testAdmin->attachRole(Role::ADMIN_ROLE_SLUG);
    }
}
