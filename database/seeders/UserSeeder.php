<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin 2',
            'username' => 'admin3',
            'id_card' => '123456789',
            'password' => bcrypt('password'),
            'role_id' => 1, // Assuming 1 is the ID for the admin role
        ]);
    }
}
