<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        $roleUser = Role::create([
            'id' => 1,
            'title' => 'user',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $roleAdmin = Role::create([
            'id' => 2,
            'title' => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $testUser->roles()->save($roleUser);
        $testAdmin->roles()->save($roleAdmin);
    }
}
