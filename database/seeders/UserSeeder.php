<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    User::factory()->count(2)->create(['role' => 'admin']);

    User::factory()->count(5)->create(['role' => 'recruteur']);

    User::factory()->count(10)->create(['role' => 'candidat']);
}
}
