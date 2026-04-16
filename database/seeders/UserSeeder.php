<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(2)->create([
            'role' => 'admin',
            'password' => bcrypt('password')
        ]);

        User::factory()->count(5)->create([
            'role' => 'recruteur',
            'password' => bcrypt('password')
        ]);

        User::factory()->count(10)->create([
            'role' => 'candidat',
            'password' => bcrypt('password')
        ]);
    }
}
