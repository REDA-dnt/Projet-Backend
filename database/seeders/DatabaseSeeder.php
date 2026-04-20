<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CompetenceSeeder;
use Database\Seeders\ProfilSeeder;
use Database\Seeders\OffreSeeder;
use Database\Seeders\CandidatureSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CompetenceSeeder::class,
            ProfilSeeder::class,
            OffreSeeder::class,
            CandidatureSeeder::class,
        ]);
    }
}