<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name'     => 'Admin Principal',
            'email'    => 'admin@mini-linkedin.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'name'     => 'Admin Second',
            'email'    => 'admin2@mini-linkedin.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        \App\Models\User::factory(5)->create(['role' => 'recruteur']);

        \App\Models\User::factory(10)->create(['role' => 'candidat']);
    }
}
